<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Repository;

use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\PaginationDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Entity\Transaction;

interface TransactionRepositoryInterface
{
    public function create(Transaction $transaction): void;

    public function update(Transaction $transaction): void;

    public function getById(int $transactionId, int $userId): Transaction;

    /** @return Transaction[] */
    public function getAll(PaginationDto $paginationDto, int $userId): array;
}
