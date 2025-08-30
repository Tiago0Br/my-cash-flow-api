<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Exception;

use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\NotFoundException;

class AccountNotFound extends NotFoundException
{
    public static function byId(int $id): self
    {
        return new self("Account with id '$id' not found");
    }
}
