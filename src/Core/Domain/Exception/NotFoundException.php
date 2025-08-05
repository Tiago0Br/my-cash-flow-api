<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Exception;

use DomainException;

class NotFoundException extends DomainException
{
    public static function create(): self
    {
        return new self('Resource not found.');
    }
}
