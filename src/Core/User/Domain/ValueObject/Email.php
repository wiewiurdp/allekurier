<?php

declare(strict_types=1);

namespace App\Core\User\Domain\ValueObject;

use App\Core\User\Domain\Exception\InvalidEmailException;

class Email
{
    private string $value;

    public function __construct(string $value)
    {
        if (!self::isValid($value)) {
            throw new InvalidEmailException('Nieprawidłowy adres e-mail');
        }
        $this->value = mb_strtolower(trim($value));
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Email $email): bool
    {
        return $this->value === (string)$email;
    }

    public static function isValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
