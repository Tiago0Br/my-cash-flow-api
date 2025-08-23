<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Contracts;

interface ValidationInterface
{
    public function validate(string $field, array $parameters): void;
}
