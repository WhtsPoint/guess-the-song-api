<?php

namespace App\Email\Domain\Entity;

class TemplateMail
{
    private string $locale = 'en';

    public function __construct(
        private string $subject,
        private string $receiver,
        private string $templateName,
        private array $context
    ) {}

    public function getReceiver(): string
    {
        return $this->receiver;
    }

    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }
}