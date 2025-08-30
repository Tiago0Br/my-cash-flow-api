<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Repository;

use Tiagolopes\MyCashFlowApi\Finance\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    /** @return Category[] */
    public function getAll(): array;

    public function create(Category $category): void;

    public function findByTitleAndType(string $title, string $type): ?Category;
}
