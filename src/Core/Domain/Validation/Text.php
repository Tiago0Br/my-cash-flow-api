<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Validation;

use Attribute;
use InvalidArgumentException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ValidationInterface;

#[Attribute(flags: Attribute::TARGET_PROPERTY)]
class Text implements ValidationInterface
{
    public function __construct(public bool $allowEmpty = false)
    {
    }

    public function validate(string $field, array $parameters): void
    {
        if (! isset($parameters[$field])) return;

        if (! is_string(value: $parameters[$field])) {
            throw new InvalidArgumentException("Field '$field' should be a not empty text.");
        }

        if (! $this->allowEmpty && trim(string: $parameters[$field]) === '') {
            throw new InvalidArgumentException("Field '$field' should be a not empty text.");
        }
    }
}
