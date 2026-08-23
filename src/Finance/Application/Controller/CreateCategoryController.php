<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\CreateCategoryDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\CreateCategory;

#[OA\Post(
    path: '/categories',
    summary: 'Create a category for transactions',
    security: [['bearerAuth' => []]],
    tags: ['Categories']
)]
#[OA\RequestBody(
    description: 'Category creation payload',
    required: true,
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                required: ['title', 'type'],
                properties: [
                    new OA\Property(
                        property: 'title',
                        type: 'string',
                        example: 'Alimentação'
                    ),
                    new OA\Property(
                        property: 'type',
                        type: 'string',
                        enum: ['income', 'expense'],
                        example: 'expense'
                    )
                ]
            )
        ],
    )
)]
#[OA\Response(
    response: 201,
    description: 'Category created successfully',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'message',
                        type: 'string',
                        example: 'Category created successfully'
                    )
                ],
            )
        ],
    ),
)]
#[OA\Response(
    response: 400,
    description: 'Bad Request - Validation errors',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'errors',
                        type: 'array',
                        items: new OA\Items(type: 'string'),
                        example: ['The title field is required.', 'The type field must be one of: income, expense.']
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
                        example: 'Unauthorized.'
                    )
                ],
            )
        ],
    ),
)]
#[OA\Response(
    response: 409,
    description: 'Conflict - Category already exists',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'error',
                        type: 'string',
                        example: "Category with title 'Alimentação' already exists for the type 'expense'."
                    )
                ],
            )
        ],
    )
)]
readonly class CreateCategoryController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $createCategoryDto = CreateCategoryDto::fromArray($request->getParsedBody());

        /** @var CreateCategory $createCategory */
        $createCategory = $this->container->get(CreateCategory::class);
        $createCategory->execute($createCategoryDto);

        $response->getBody()->write(json_encode([
            'message' => 'Category created successfully'
        ]));

        return $response->withStatus(StatusCode::CREATED);
    }
}
