<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Entity;

use JsonSerializable;
use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\CreateAccountDto;
use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\UpdateAccountDto;

class Account implements JsonSerializable
{
    private function __construct(
        public readonly ?int $id,
        private(set) string $name,
        private(set) string $type,
        public readonly int $userId
    ) {
    }

    public static function create(CreateAccountDto $createAccountDto, int $userId): self
    {
        return new self(
            id: null,
            name: $createAccountDto->name,
            type: $createAccountDto->type,
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

    public function update(UpdateAccountDto $updateAccountDto): void
    {
        $this->name = $updateAccountDto->name;
        $this->type = $updateAccountDto->type;
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
