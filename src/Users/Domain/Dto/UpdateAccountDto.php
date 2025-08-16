<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Dto;

readonly class UpdateAccountDto
{
    private function __construct(
        public int $id,
        public string $name,
        public string $type
    ) {
    }

    public static function fromArray(array $params): self
    {
        return new self(
            id: (int) $params['id'],
            name: $params['name'],
            type: $params['type']
        );
    }
}
