<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Validation;

use Attribute;
use InvalidArgumentException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\AbstractValidator;

#[Attribute(flags: Attribute::TARGET_PROPERTY)]
class Required extends AbstractValidator
{
    protected bool $required = true;

    public function validate(string $field, array $parameters): void
    {
        if (!isset($parameters[$field])) {
            throw new InvalidArgumentException("Field '$field' is required.");
        }
    }
}
