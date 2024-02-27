<?php

namespace App\Email\Domain\Factory;

use App\Email\Domain\Entity\TemplateMail;

class TemplateMailFactory
{
    public function create(
        string $subject,
        string $receiver,
        string $templateName,
        array $context,
        ?string $locale = null
    ): TemplateMail {
        $templateMail = new TemplateMail(
            $subject,
            $receiver,
            $templateName,
            $context
        );

        if ($locale !== null) {
            $templateMail->setLocale($locale);
        }

        return $templateMail;
    }
}