<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Dto;

use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Integer;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Required;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Validator;

readonly class GetTransactionByIdDto
{
    private function __construct(
        #[Required, Integer]
        public int $id
    ) {
    }

    public static function fromArray(array $params): self
    {
        Validator::validate(self::class, $params);

        return new self(
            id: (int) $params['id']
        );
    }
}
