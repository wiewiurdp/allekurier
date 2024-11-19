<?php

declare(strict_types=1);

namespace App\Core\Invoice\Infrastructure\Doctrine;

use App\Core\Invoice\Domain\ValueObject\Amount;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\IntegerType;

class AmountType extends IntegerType
{
    public const TYPE = 'amount';

    /**
     * {@inheritDoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Amount
    {
        if ($value instanceof Amount) {
            return $value;
        }

        if (!is_numeric($value)) {
            return null;
        }

        try {
            return new Amount((int) $value);
        } catch (\Throwable $e) {
            throw ConversionException::conversionFailed($value, self::TYPE);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Amount) {
            return $value->getValue();
        }

        if (is_int($value) && Amount::isValid($value)) {
            return $value;
        }

        throw ConversionException::conversionFailed($value, self::TYPE);
    }

    public function getName(): string
    {
        return self::TYPE;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getMappedDatabaseTypes(AbstractPlatform $platform): array
    {
        return [self::TYPE];
    }
}
