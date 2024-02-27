<?php

namespace App\Email\Infrastructure\Mailer;

use App\Email\Domain\Entity\TemplateMail;
use App\Email\Domain\Exception\MailSendFailureException;
use App\Email\Domain\Mailer\MailerInterface;
use App\Utils\Domain\ValueObject\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface as SymfonyMailerInterface;

class Mailer implements MailerInterface
{
    public function __construct(
        public SymfonyMailerInterface $mailer
    ) {}

    /**
     * @throws MailSendFailureException
     */
    public function sendTemplate(Email $email, TemplateMail $mail): void
    {
        $mail = (new TemplatedEmail())
            ->from('ubluewolfu@gmail.com')
            ->to($mail->getReceiver())
            ->subject($mail->getSubject())
            ->htmlTemplate($mail->getTemplateName() . '.html.twig')
            ->context($mail->getContext());

        try {
            $this->mailer->send($mail);
        } catch (TransportExceptionInterface $exception) {
            throw new MailSendFailureException($exception);
        }
    }
}