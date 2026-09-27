<?php

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Contracts;

abstract class AbstractValidator
{
    protected bool $required = false;

    public function executeValidation(string $field, array $parameters): void
    {
        if (!$this->required && !isset($parameters[$field])) {
            return;
        }

        $this->validate($field, $parameters);
    }

    protected abstract function validate(string $field, array $parameters): void;
}
