<?php

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Exception;

use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\NotFoundException;

class TransactionNotFound extends NotFoundException
{
    public static function fromId(int $id): self
    {
        return new self("Transaction with ID $id not found.");
    }
}
