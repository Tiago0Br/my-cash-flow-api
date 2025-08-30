<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Exception;

use DomainException;

class CategoryAlreadyExists extends DomainException
{
    public static function fromTitleAndType(string $title, string $type): self
    {
        return new self("Category with title '$title' already exists for the type '$type'.");
    }
}
