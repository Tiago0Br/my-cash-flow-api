<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\CreateTransactionDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\CreateTransaction;

#[OA\Post(
    path: '/transactions',
    summary: 'Create a transaction',
    security: [['bearerAuth' => []]],
    tags: ['Transactions']
)]
#[OA\RequestBody(
    description: 'Transaction creation payload',
    required: true,
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                required: ['title', 'amount', 'type', 'transactionDate', 'categoryId', 'accountId'],
                properties: [
                    new OA\Property(
                        property: 'title',
                        type: 'string',
                        example: 'Compra no supermercado'
                    ),
                    new OA\Property(
                        property: 'amount',
                        type: 'float',
                        example: 150.75
                    ),
                    new OA\Property(
                        property: 'type',
                        type: 'string',
                        enum: ['income', 'expense'],
                        example: 'expense'
                    ),
                    new OA\Property(
                        property: 'transactionDate',
                        type: 'string',
                        format: 'date',
                        example: '2024-10-05'
                    ),
                    new OA\Property(
                        property: 'categoryId',
                        type: 'integer',
                        example: 3
                    ),
                    new OA\Property(
                        property: 'accountId',
                        type: 'integer',
                        example: 1
                    ),
                    new OA\Property(
                        property: 'description',
                        type: 'string',
                        example: 'Compra de alimentos no supermercado local'
                    )
                ]
            )
        ],
    )
)]
#[OA\Response(
    response: 201,
    description: 'Transaction created successfully',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'message',
                        type: 'string',
                        example: 'Transaction created successfully'
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
readonly class CreateTransactionController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $createTransactionDto = CreateTransactionDto::fromArray($request->getParsedBody());

        /** @var CreateTransaction $createTransaction */
        $createTransaction = $this->container->get(CreateTransaction::class);
        $createTransaction->create($createTransactionDto);

        $response->getBody()->write(json_encode([
            'message' => 'Transaction created successfully',
        ]));

        return $response->withStatus(StatusCode::CREATED);
    }
}
