<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\UpdateTransactionDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\UpdateTransaction;

#[OA\Put(
    path: '/transactions/{id}',
    summary: 'Update a transaction',
    security: [['bearerAuth' => []]],
    tags: ['Transactions'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            description: 'ID of the transaction to update',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer', example: 1)
        )
    ]
)]
#[OA\RequestBody(
    description: 'Transaction update payload',
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
    response: 200,
    description: 'Transaction updated successfully',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'message',
                        type: 'string',
                        example: 'Transaction updated successfully'
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
readonly class UpdateTransactionController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $userId = (int) $request->getHeader('USER-ID')[0];
        $dto    = UpdateTransactionDto::fromArray(array_merge(
            $request->getQueryParams(),
            $request->getParsedBody()
        ));

        /** @var UpdateTransaction $updateTransaction */
        $updateTransaction = $this->container->get(UpdateTransaction::class);
        $updateTransaction->update($dto, $userId);

        $response->getBody()->write(json_encode([
            'message' => 'Transaction updated successfully',
        ]));

        return $response->withStatus(StatusCode::OK);
    }
}
