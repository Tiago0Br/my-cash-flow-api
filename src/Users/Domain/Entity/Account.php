<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Entity;

use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\SaveAccountDto;

class Account
{
    private function __construct(
        public readonly ?int $id,
        private(set) string $name,
        private(set) string $type,
        public readonly int $userId
    ) {
    }

    public static function create(SaveAccountDto $saveAccountDto, int $userId): self
    {
        return new self(
            id: null,
            name: $saveAccountDto->name,
            type: $saveAccountDto->type,
            userId: $userId
        );
    }

    public function update(SaveAccountDto $saveAccountDto): void
    {
        $this->name = $saveAccountDto->name;
        $this->type = $saveAccountDto->type;
    }
}
