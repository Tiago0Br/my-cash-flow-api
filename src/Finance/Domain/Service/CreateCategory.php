<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Service;

use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\CreateCategoryDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Entity\Category;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Exception\CategoryAlreadyExists;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\CategoryRepositoryInterface;

readonly class CreateCategory
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function execute(CreateCategoryDto $createCategoryDto): void
    {
        $categoryAlreadyExists = $this->categoryRepository->findByTitleAndType(
            $createCategoryDto->title,
            $createCategoryDto->type
        );

        if ($categoryAlreadyExists instanceof Category) {
            throw CategoryAlreadyExists::fromTitleAndType(
                $createCategoryDto->title,
                $createCategoryDto->type
            );
        }

        $category = Category::create($createCategoryDto);

        $this->categoryRepository->create($category);
    }
}
