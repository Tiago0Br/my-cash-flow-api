<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\PaginationDto;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\TransactionRepositoryInterface;

#[OA\Get(
    path: '/transactions',
    description: 'Return a list of all transactions',
    summary: 'Get all transactions',
    security: [['bearerAuth' => []]],
    tags: ['Transactions'],
    parameters: [
        new OA\Parameter(
            name: 'limit',
            description: 'Number of items per page',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 20)
        ),
        new OA\Parameter(
            name: 'offset',
            description: 'Number of items to skip before starting to collect the result set',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 0)
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Transactions retrieved successfully',
            content: new OA\JsonContent(
                allOf: [
                    new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: 'transactions',
                                type: 'array',
                                items: new OA\Items(
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
                            )
                        ]
                    )
                ]
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
        )
    ]
)]
readonly class GetAllTransactionsController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $userId        = (int) $request->getHeader('USER-ID')[0];
        $paginationDto = PaginationDto::fromArray($request->getQueryParams());

        /** @var TransactionRepositoryInterface $transactionRepository */
        $transactionRepository = $this->container->get(TransactionRepositoryInterface::class);
        $transactions          = $transactionRepository->getAll(paginationDto: $paginationDto, userId: $userId);

        $response->getBody()->write(json_encode([
            'transactions' => array_map(
                callback: fn ($transaction) => $transaction->jsonSerialize(),
                array: $transactions
            ),
        ]));

        return $response->withStatus(StatusCode::OK);
    }
}
