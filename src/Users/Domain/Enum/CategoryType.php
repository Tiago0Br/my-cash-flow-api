<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Enum;

enum CategoryType: string
{
    case INCOME  = 'income';
    case EXPENSE = 'expense';

    public const array VALUES = [
        self::INCOME->value,
        self::EXPENSE->value,
    ];
}
