<?php

namespace App\Core\Invoice\Domain\Notification;

use App\Core\User\Domain\ValueObject\Email;

interface NotificationInterface
{
    public function sendEmail(Email $recipient, string $subject, string $message): void;
}
