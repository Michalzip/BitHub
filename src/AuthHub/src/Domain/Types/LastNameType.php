<?php

namespace App\Domain\Types;

use App\Domain\ValueObject\LastName;
use Throwable;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class LastNameType extends StringType
{

    private const TYPE = 'last_name';
    
    public function getName()
    {
        return SELF::TYPE;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof LastName) {

            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', LastName::class]);
        }

        return $value->toString();
    }

 
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof LastName) {
            return $value;
        }

        try {
            $lastName = LastName::fromString($value);
        } catch (Throwable) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $lastName;
    }
}
