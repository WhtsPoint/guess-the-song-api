<?php

namespace App\User\Domain\Helper;

use App\User\Domain\Exception\InvalidJWTException;
use App\User\Domain\Exception\TokenExpiredException;
use App\User\Domain\Representation\AccessTokenUserData;
use App\User\Domain\Representation\RefreshTokenUserData;
use App\User\Domain\ValueObject\Tokens;

interface JWTInterface
{
    public function generate(string $id, array $roles, bool $isEmailConfirmed): Tokens;
    public function generateAccess(string $id, array $roles, bool $isEmailConfirmed): string;
    public function generateRefresh(string $id): string;
    /**
     * @throws InvalidJWTException
     * @throws TokenExpiredException
     */
    public function decodeAccess(string $accessToken): AccessTokenUserData;
    /**
     * @throws InvalidJWTException
     * @throws TokenExpiredException
     */
    public function decodeRefresh(string $refreshToken): RefreshTokenUserData;
}