<?php

namespace App\Email\Application;

use App\Email\Application\Dto\EmailConfirmationDto;
use App\Email\Application\Factory\MailTemplateFactory;
use App\Email\Domain\Exception\MailSendFailureException;
use App\Email\Domain\Mailer\MailerInterface;

class EmailService
{
    public function __construct(
        private MailerInterface $mailer,
        private MailTemplateFactory $factory
    ) {}

    /**
     * @throws MailSendFailureException
     */
    public function onUserEmailConfirmationCodeChanged(EmailConfirmationDto $dto): void
    {
        $this->mailer->sendTemplate(
            $dto->email,
            $this->factory->createEmailConfirmationCodeMail($dto)
        );
    }
}