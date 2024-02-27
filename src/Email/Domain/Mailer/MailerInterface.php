<?php

namespace App\Email\Domain\Mailer;

use App\Email\Domain\Entity\TemplateMail;
use App\Email\Domain\Exception\MailSendFailureException;
use App\Utils\Domain\ValueObject\Email;

interface MailerInterface
{
    /**
     * @throws MailSendFailureException
     */
    public function sendTemplate(Email $email, TemplateMail $mail);
}