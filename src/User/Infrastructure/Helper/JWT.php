<?php

namespace App\User\Infrastructure\Helper;

use App\User\Domain\Exception\InvalidJWTException;
use App\User\Domain\Exception\TokenExpiredException;
use App\User\Domain\Helper\JWTInterface;
use App\User\Domain\Representation\AccessTokenUserData;
use App\User\Domain\Representation\RefreshTokenUserData;
use App\User\Domain\ValueObject\Tokens;
use DateTimeImmutable;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;
use OpenSSLAsymmetricKey;
use UnexpectedValueException;

class JWT implements JWTInterface
{
    public const ACCESS_SUB = 'auth_access';
    public const REFRESH_SUB = 'auth_refresh';
    private OpenSSLAsymmetricKey $privateKey;
    private Key $publicKey;

    public function __construct(
        private array $config
    )
    {
        $this->privateKey = openssl_get_privatekey(
            file_get_contents($this->config['key_file_path'])
        );
    }

    public function generate(string $id, array $roles, bool $isEmailConfirmed): Tokens
    {
        return new Tokens(
            $this->generateAccess($id, $roles, $isEmailConfirmed),
            $this->generateRefresh($id)
        );
    }

    /**
     * @throws TokenExpiredException
     * @throws InvalidJWTException
     */
    public function decodeRefresh(string $refreshToken): RefreshTokenUserData
    {
        $payload = $this->decodeWithSubValidation($refreshToken, self::REFRESH_SUB);

        return new RefreshTokenUserData($payload['id']);
    }

    /**
     * @throws TokenExpiredException
     * @throws InvalidJWTException
     */
    public function decodeAccess(string $accessToken): AccessTokenUserData
    {
        $payload = $this->decodeWithSubValidation($accessToken, self::ACCESS_SUB);

        return new AccessTokenUserData($payload['id'], $payload['roles'], $payload['email_confirmed']);
    }

    public function generateAccess(string $id, array $roles, bool $isEmailConfirmed): string
    {
        $lifeTime = (new DateTimeImmutable(
            '+' . $this->config['access_lifetime']
        ))->getTimestamp();

        return \Firebase\JWT\JWT::encode(
            [
                'id' => $id,
                'roles' => $roles,
                'email_confirmed' => $isEmailConfirmed,
                'sub' => self::ACCESS_SUB,
                'exp' => $lifeTime,
            ],
            $this->privateKey,
            'RS256'
        );
    }

    public function generateRefresh(string $id): string
    {
        $lifeTime = (new DateTimeImmutable(
            '+' . $this->config['refresh_lifetime']
        ))->getTimestamp();

        return \Firebase\JWT\JWT::encode(
            [
                'id' => $id,
                'exp' => time() + $lifeTime,
                'sub' => self::REFRESH_SUB
            ],
            $this->privateKey,
            'RS256'
        );
    }

    /**
     * TODO: Put into a separate object
     */
    /**
     * @throws TokenExpiredException
     * @throws InvalidJWTException
     */
    private function decodeWithSubValidation(string $token, string $sub): array
    {
        try {
            $payload = (array) \Firebase\JWT\JWT::decode($token, $this->publicKey);

            if (@$payload['sub'] !== $sub) throw new UnexpectedValueException();

            return $payload;
        } catch (ExpiredException) {
            throw new TokenExpiredException();
        }  catch (UnexpectedValueException) {
            throw new InvalidJWTException();
        }
    }
}