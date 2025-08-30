<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Request;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\CategoryRepositoryInterface;

#[OA\Get(
    path: '/categories',
    summary: 'Get all categories for transactions',
    security: [['bearerAuth' => []]],
    tags: ['Categories']
)]
#[OA\Response(
    response: 200,
    description: 'List of categories retrieved successfully',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'categories',
                        description: 'Array of categories',
                        type: 'array',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'title', type: 'string', example: 'Alimentação'),
                                new OA\Property(property: 'type', type: 'string', example: 'expense'),
                            ],
                            type: 'object'
                        )
                    )
                ],
            )
        ],
    ),
)]
#[OA\Response(
    response: 401,
    description: 'Unauthorized - Missing or invalid token',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'error',
                        type: 'string',
                        example: 'Unauthorized.',
                    )
                ],
            )
        ],
    ),
)]
class GetCategoriesController implements ControllerInterface
{
    public function processRequest(Container $container, Request $request): void
    {
        /** @var CategoryRepositoryInterface $categoryRepository */
        $categoryRepository = $container->get(CategoryRepositoryInterface::class);
        $categories         = $categoryRepository->getAll();

        sendResponse([
            'categories' => array_map(fn ($category) => $category->jsonSerialize(), $categories),
        ]);
    }
}
