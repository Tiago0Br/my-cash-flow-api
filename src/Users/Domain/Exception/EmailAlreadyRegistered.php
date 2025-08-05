<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Exception;

use DomainException;

class EmailAlreadyRegistered extends DomainException
{
    public static function fromEmail(string $email): self
    {
        return new self("Email '$email' already registered");
    }
}
