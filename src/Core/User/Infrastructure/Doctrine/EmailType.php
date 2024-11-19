<?php

declare(strict_types=1);

namespace App\Core\User\Infrastructure\Doctrine;

use App\Core\User\Domain\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
    public const TYPE = 'email';

    /**
     * {@inheritDoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        if ($value instanceof Email) {
            return $value;
        }

        if (!is_string($value) || $value === '') {
            return null;
        }

        try {
            return new Email($value);
        } catch (\Throwable $e) {
            throw ConversionException::conversionFailed($value, self::TYPE);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Email) {
            return (string) $value;
        }

        if (is_string($value) && Email::isValid($value)) {
            return $value;
        }

        throw ConversionException::conversionFailed($value, self::TYPE);
    }

    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 300;

        return parent::getSQLDeclaration($column, $platform);
    }


    public function getName(): string
    {
        return self::TYPE;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getMappedDatabaseTypes(AbstractPlatform $platform): array
    {
        return [self::TYPE];
    }
}
