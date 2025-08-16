<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Exception;

use DomainException;

class UserNotFound extends DomainException
{
    public static function byId(int $id): self
    {
        return new self("User with id '$id' not found");
    }
}
