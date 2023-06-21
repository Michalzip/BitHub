<?php

namespace App\Domain\Types;

use Throwable;
use Doctrine\DBAL\Types\StringType;
use App\Domain\ValueObject\FirstName;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class FirstNameType  extends StringType
{
    private const TYPE = 'first_name';

    public function getName()
    {
        return SELF::TYPE;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof FirstName) {

            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', FirstName::class]);
        }

        return $value->toString();
    }

 
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof FirstName) {
            return $value;
        }

        try {
            $firstName = FirstName::fromString($value);
        } catch (Throwable) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $firstName;
    }
}
