<?php

namespace App\Domain\Types;

use Throwable;
use Doctrine\DBAL\Types\StringType;
use App\Domain\ValueObject\HashedPassword;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;

;

class HashedPasswordType extends StringType
{
    private const TYPE = 'hashed_password';

    public function getName()
    {
        return self::TYPE;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof HashedPassword) {

            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', HashedPassword::class]);
        }

        return $value->toString();
    }


    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof HashedPassword) {
            return $value;
        }

        try {
            $hashedPassword = HashedPassword::fromString($value);
        } catch (Throwable) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $hashedPassword;
    }
}
