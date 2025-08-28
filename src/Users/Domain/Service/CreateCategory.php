<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Service;

use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\CreateCategoryDto;
use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\Category;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\CategoryRepositoryInterface;

readonly class CreateCategory
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function execute(CreateCategoryDto $createCategoryDto): void
    {
        $category = Category::create($createCategoryDto);

        $this->categoryRepository->create($category);
    }
}
