<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Validation;

use Attribute;
use DateTime;
use InvalidArgumentException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ValidationInterface;

#[Attribute(flags: Attribute::TARGET_PROPERTY)]
class Date implements ValidationInterface
{
    public function __construct(
        public string $format = 'Y-m-d',
        public bool $allowPastDates = true,
        public bool $allowFutureDates = false,
    ) {
    }

    public function validate(string $field, array $parameters): void
    {
        if (! isset($parameters[$field])) return;

        $date = DateTime::createFromFormat($this->format, $parameters[$field]);

        if ($date === false) {
            throw new InvalidArgumentException("Field '$field' should be a valid date in '$this->format' format.");
        }

        if (! $this->allowPastDates && $date < new DateTime()) {
            throw new InvalidArgumentException("Field '$field' should not be a past date.");
        }

        if (! $this->allowFutureDates && $date > new DateTime()) {
            throw new InvalidArgumentException("Field '$field' should not be a future date.");
        }
    }
}
