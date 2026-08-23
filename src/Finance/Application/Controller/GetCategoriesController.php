<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
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
readonly class GetCategoriesController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        /** @var CategoryRepositoryInterface $categoryRepository */
        $categoryRepository = $this->container->get(CategoryRepositoryInterface::class);
        $categories         = $categoryRepository->getAll();

        $response->getBody()->write(json_encode([
            'categories' => array_map(fn ($category) => $category->jsonSerialize(), $categories),
        ]));

        return $response->withStatus(StatusCode::OK);
    }
}
