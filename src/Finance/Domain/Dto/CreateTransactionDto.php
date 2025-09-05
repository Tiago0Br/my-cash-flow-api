<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Dto;

use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Date;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Integer;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Number;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Options;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Required;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Text;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Validator;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Enum\TransactionType;

readonly class CreateTransactionDto
{
    private function __construct(
        #[Required, Text]
        public string $title,
        #[Required, Number]
        public float $amount,
        #[Required, Options(TransactionType::VALUES)]
        public string $type,
        #[Required, Date(allowFutureDates: true)]
        public string $transactionDate,
        #[Required, Integer]
        public int $categoryId,
        #[Required, Integer]
        public int $accountId,
        #[Text]
        public ?string $description
    ) {
    }

    public static function fromArray(array $params): self
    {
        Validator::validate(self::class, $params);

        return new self(
            title: $params['title'],
            amount: (float) $params['amount'],
            type: $params['type'],
            transactionDate: $params['transactionDate'],
            categoryId: (int) $params['categoryId'],
            accountId: (int) $params['accountId'],
            description: $params['description'] ?? null
        );
    }
}
