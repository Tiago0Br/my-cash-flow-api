<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Entity;

use JsonSerializable;

class Category implements JsonSerializable
{
    private function __construct(
        private(set) ?int $id = null,
        private(set) string $title,
        private(set) string $type,
    ) {
    }

    public static function createFromDatabaseReturn(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            type: $data['type'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
        ];
    }
}
