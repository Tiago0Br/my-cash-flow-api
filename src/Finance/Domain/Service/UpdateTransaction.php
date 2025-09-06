<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Service;

use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\UpdateTransactionDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\TransactionRepositoryInterface;

readonly class UpdateTransaction
{
    public function __construct(private TransactionRepositoryInterface $transactionRepository)
    {
    }

    public function update(UpdateTransactionDto $updateTransactionDto, int $userId): void
    {
        $transaction = $this->transactionRepository->getById($updateTransactionDto->id, $userId);
        $transaction->update($updateTransactionDto);

        $this->transactionRepository->update($transaction);
    }
}
