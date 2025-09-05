<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Validation;

use Attribute;
use InvalidArgumentException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ValidationInterface;

#[Attribute(flags: Attribute::TARGET_PROPERTY)]
class Integer implements ValidationInterface
{
    public function __construct(
        public $allowNegative = false,
        public ?int $min = null,
        public ?int $max = null,
    ) {
    }

    public function validate(string $field, array $parameters): void
    {
        if (! isset($parameters[$field])) return;

        if (! is_int(value: $parameters[$field])) {
            throw new InvalidArgumentException("Field '$field' should be an integer.");
        }

        if (! $this->allowNegative && $parameters[$field] < 0) {
            throw new InvalidArgumentException("Field '$field' should not be negative.");
        }

        if ($this->min !== null && $parameters[$field] < $this->min) {
            throw new InvalidArgumentException("Field '$field' should be at least $this->min.");
        }

        if ($this->max !== null && $parameters[$field] > $this->max) {
            throw new InvalidArgumentException("Field '$field' should be at most $this->max.");
        }
    }
}
