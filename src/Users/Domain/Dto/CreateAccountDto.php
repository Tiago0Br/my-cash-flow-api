<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Dto;

readonly class CreateAccountDto
{
    private function __construct(
        public string $name,
        public string $type
    ) {
    }

    public static function fromArray(array $params): self
    {
        return new self(
            name: $params['name'],
            type: $params['type']
        );
    }
}
