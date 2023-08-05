<?php

namespace App\Domain\Entity\User\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Shared\Domain\ValueObject\AggregateRootId;

#[ORM\Embeddable]
class UserId implements \Stringable
{
    use AggregateRootId;
}
