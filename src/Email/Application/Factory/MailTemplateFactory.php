<?php

namespace App\Email\Application\Factory;

use App\Email\Application\Dto\EmailConfirmationDto;
use App\Email\Domain\Entity\TemplateMail;
use App\Email\Domain\Factory\TemplateMailFactory;

class MailTemplateFactory
{
    public function __construct(
        private TemplateMailFactory $factory
    ) {}

    public function createEmailConfirmationCodeMail(EmailConfirmationDto $dto): TemplateMail
    {
        return $this->factory->create(
            'Email Confirmation',
            $dto->email->get(),
            'email_confirmation',
            ['code' => $dto->code]
        );
    }
}