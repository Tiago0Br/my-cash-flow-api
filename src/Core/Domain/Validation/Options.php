<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Validation;

use Attribute;
use InvalidArgumentException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ValidationInterface;

#[Attribute(flags: Attribute::TARGET_PROPERTY)]
class Options implements ValidationInterface
{
    public function __construct(public array $list)
    {
    }

    public function validate(string $field, array $parameters): void
    {
        if (!isset($parameters[$field])) {
            return;
        }

        if (!in_array(needle: $parameters[$field], haystack: $this->list, strict: true)) {
            if (count($this->list) <= 5) {
                $optionsList = implode(", ", $this->list);
                throw new InvalidArgumentException("Field '$field' must be one of the following options: $optionsList.");
            }

            throw new InvalidArgumentException("Field '$field' must be a valid option.");
        }
    }
}
