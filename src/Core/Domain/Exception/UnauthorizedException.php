<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Exception;

use DomainException;

class UnauthorizedException extends DomainException
{
    public static function create(?string $message = null): self
    {
        $defaultMessage = 'Unauthorized.';

        return new self($message ?? $defaultMessage);
    }
}
