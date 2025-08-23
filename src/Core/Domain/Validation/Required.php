<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Validation;

use Attribute;
use InvalidArgumentException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ValidationInterface;

#[Attribute(flags: Attribute::TARGET_PROPERTY)]
class Required implements ValidationInterface
{
    public function validate(string $field, array $parameters): void
    {
        if (! isset($parameters[$field])) {
            throw new InvalidArgumentException("Field '$field' is required.");
        }
    }
}
