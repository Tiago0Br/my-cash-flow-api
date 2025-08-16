<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Entity;

use JsonSerializable;
use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\SaveAccountDto;

class Account implements JsonSerializable
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

    public static function createFromDatabaseReturn(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            type: $data['type'],
            userId: $data['user_id']
        );
    }

    public function update(SaveAccountDto $saveAccountDto): void
    {
        $this->name = $saveAccountDto->name;
        $this->type = $saveAccountDto->type;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}
