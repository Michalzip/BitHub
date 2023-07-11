<?php

namespace App\Domain\Types;

use Throwable;
use App\Domain\ValueObject\Email;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EmailType extends StringType
{
    private const TYPE = 'email';

    public function getName()
    {
        return self::TYPE;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Email) {

            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Email::class]);
        }

        return $value->toString();
    }


    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof Email) {
            return $value;
        }

        try {
            $email = Email::fromString($value);
        } catch (Throwable) {

            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $email;
    }
}
