<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Validation;

use Attribute;
use InvalidArgumentException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ValidationInterface;

#[Attribute(flags: Attribute::TARGET_PROPERTY)]
class Integer implements ValidationInterface
{
    public function validate(string $field, array $parameters): void
    {
        if (! isset($parameters[$field])) return;

        if (! is_int(value: $parameters[$field])) {
            throw new InvalidArgumentException("Field '$field' should be an integer.");
        }
    }
}
