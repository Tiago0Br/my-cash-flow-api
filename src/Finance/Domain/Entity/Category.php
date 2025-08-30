<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Entity;

use JsonSerializable;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\CreateCategoryDto;

class Category implements JsonSerializable
{
    private function __construct(
        private(set) ?int $id = null,
        private(set) string $title,
        private(set) string $type,
    ) {
    }

    public static function create(CreateCategoryDto $createCategoryDto): self
    {
        return new self(
            id: null,
            title: $createCategoryDto->title,
            type: $createCategoryDto->type
        );
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
