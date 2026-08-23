<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\GetTransactionByIdDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\TransactionRepositoryInterface;

#[OA\Get(
    path: '/transactions/{id}',
    description: 'Return a single transaction by its ID',
    summary: 'Get transaction by ID',
    security: [['bearerAuth' => []]],
    tags: ['Transactions'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            description: 'The ID of the transaction to retrieve',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer')
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Transaction retrieved successfully',
            content: new OA\JsonContent(
                allOf: [
                    new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: 'transaction',
                                description: 'The transaction details',
                                properties: [
                                    new OA\Property(property: 'id', type: 'string', example: '1'),
                                    new OA\Property(property: 'title', type: 'string', example: 'Compra no supermercado'),
                                    new OA\Property(property: 'description', type: 'string', example: 'Compras da semana', nullable: true),
                                    new OA\Property(property: 'amount', type: 'number', format: 'float', example: 150.50),
                                    new OA\Property(property: 'type', type: 'string', enum: ['income', 'expense'], example: 'expense'),
                                    new OA\Property(property: 'transaction_date', type: 'string', format: 'date', example: '2025-01-05'),
                                    new OA\Property(property: 'category_id', type: 'integer', example: 1),
                                    new OA\Property(property: 'account_id', type: 'integer', example: 1, nullable: true)
                                ],
                                type: 'object',
                            )
                        ],
                    )
                ],
            )
        ),
        new OA\Response(
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
        ),
        new OA\Response(
            response: 404,
            description: 'Transaction not found',
            content: new OA\JsonContent(
                allOf: [
                    new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: 'error',
                                type: 'string',
                                example: 'Transaction not found.'
                            )
                        ],
                    )
                ],
            ),
        ),
    ]
)]
readonly class GetTransactionByIdController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $userId = (int) $request->getHeader('USER-ID')[0];
        $dto    = GetTransactionByIdDto::fromArray($args);

        /** @var TransactionRepositoryInterface $transactionRepository */
        $transactionRepository = $this->container->get(TransactionRepositoryInterface::class);
        $transaction           = $transactionRepository->getById($dto->id, $userId);

        $response->getBody()->write(json_encode([
            'transaction' => $transaction->jsonSerialize(),
        ]));

        return $response->withStatus(StatusCode::OK);
    }
}
