<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\{Request, Response};
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
class CreateCategoryController implements ControllerInterface
{
    public function processRequest(Container $container, Request $request, Response $response): void
    {
        $createCategoryDto = CreateCategoryDto::fromArray($request->body);

        /** @var CreateCategory $createCategory */
        $createCategory = $container->get(CreateCategory::class);
        $createCategory->execute($createCategoryDto);

        $response->send([
            'message' => 'Category created successfully'
        ], StatusCode::CREATED);
    }
}
