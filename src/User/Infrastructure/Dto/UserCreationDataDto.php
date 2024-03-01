<?php

namespace App\User\Infrastructure\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserCreationDataDto
{
    #[Assert\NotBlank]
    public string $username;
    #[Assert\NotBlank]
    public string $password;
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;
}