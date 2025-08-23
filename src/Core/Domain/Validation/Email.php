<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Validation;

use Attribute;
use InvalidArgumentException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ValidationInterface;

#[Attribute(flags: Attribute::TARGET_PROPERTY)]
class Email implements ValidationInterface
{
    public function validate(string $field, array $parameters): void
    {
        if (! isset($parameters[$field])) return;

        if (! filter_var($parameters[$field], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Field '$field' should be a valid email.");
        }
    }
}
