<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Dto;

use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Integer;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Validator;

readonly class PaginationDto
{
    private const int LIMIT = 20;
    private const int OFFSET = 0;
    private function __construct(
        #[Integer]
        public int $limit,
        #[Integer]
        public int $offset
    ) {
    }

    public static function fromArray(array $params): self
    {
        Validator::validate(self::class, $params);

        return new self(
            limit: $params['limit'] ?? self::LIMIT,
            offset: $params['offset'] ?? self::OFFSET
        );
    }
}
