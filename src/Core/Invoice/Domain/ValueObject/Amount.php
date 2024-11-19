<?php

declare(strict_types=1);

namespace App\Core\Invoice\Domain\ValueObject;

use App\Core\Invoice\Domain\Exception\InvalidAmountException;

class Amount
{
    public const MIN_VALUE = 0;
    private int $value;

    public function __construct(int $value)
    {
        if (!self::isValid($value)) {
            throw new InvalidAmountException('Kwota faktury musi być większa od 0');
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(Amount $amount): bool
    {
        return $this->value === $amount->getValue();
    }

    public static function isValid(int $value): bool
    {
        return $value > self::MIN_VALUE;
    }
}
