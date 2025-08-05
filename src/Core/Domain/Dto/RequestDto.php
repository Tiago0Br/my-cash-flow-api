<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Dto;

readonly class RequestDto
{
    private function __construct(
        public array $headers,
        public array $params,
        public array $query,
        public array $body
    ) {
    }

    public static function create(array $headers, array $params, array $query, array $body): self
    {
        return new self(
            headers: $headers,
            params: $params,
            query: $query,
            body: $body
        );
    }
}
