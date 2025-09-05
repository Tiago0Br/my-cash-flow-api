<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Entity;

use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\CreateTransactionDto;

class Transaction
{
    private function __construct(
        public readonly ?string $id,
        private(set) string $title,
        private(set) ?string $description,
        private(set) float $amount,
        private(set) string $type,
        private(set) string $transactionDate,
        private(set) int $categoryId,
        private(set) ?int $accountId,
    ) {
    }

    public static function createFromDto(CreateTransactionDto $createTransactionDto): self
    {
        return new self(
            id: null,
            title: $createTransactionDto->title,
            description: $createTransactionDto->description,
            amount: $createTransactionDto->amount,
            type: $createTransactionDto->type,
            transactionDate: $createTransactionDto->transactionDate,
            categoryId: $createTransactionDto->categoryId,
            accountId: $createTransactionDto->accountId,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'description'      => $this->description,
            'amount'           => $this->amount,
            'type'             => $this->type,
            'transaction_date' => $this->transactionDate,
            'category_id'      => $this->categoryId,
            'account_id'       => $this->accountId,
        ];
    }
}
