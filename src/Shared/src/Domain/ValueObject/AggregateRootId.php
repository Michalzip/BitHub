<?php

namespace Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

trait AggregateRootId
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\Column(name:'id', type: "guid", unique: true)]
    #[ORM\CustomIdGenerator(class: "Ramsey\Uuid\Doctrine\UuidGenerator")]
    public $value;

    public function __construct(?string $value = null)
    {

        $this->value = Uuid::fromString($value ?: (string) Uuid::uuid4())->toString();

    }
    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}
