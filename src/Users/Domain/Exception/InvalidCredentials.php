<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Exception;

use DomainException;

class InvalidCredentials extends DomainException
{
    public static function create(): self
    {
        return new self('User not found or incorrect password');
    }
}
