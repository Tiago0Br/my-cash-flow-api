<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Service;

use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\CreateTransactionDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Entity\Transaction;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\TransactionRepositoryInterface;

readonly class CreateTransaction
{
    public function __construct(private TransactionRepositoryInterface $transactionRepository)
    {
    }

    public function create(CreateTransactionDto $createTransactionDto): Transaction
    {
        $transaction = Transaction::createFromDto($createTransactionDto);

        $this->transactionRepository->create($transaction);

        return $transaction;
    }
}
