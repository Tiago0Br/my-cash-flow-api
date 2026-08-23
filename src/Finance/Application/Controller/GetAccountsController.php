<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\AccountRepositoryInterface;

#[OA\Get(
    path: '/accounts',
    summary: 'Get all accounts for the authenticated user',
    security: [['bearerAuth' => []]],
    tags: ['Accounts']
)]
#[OA\Response(
    response: 200,
    description: 'List of user accounts retrieved successfully',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'accounts',
                        description: 'Array of user accounts',
                        type: 'array',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'name', type: 'string', example: 'Conta Corrente'),
                                new OA\Property(property: 'type', type: 'string', example: 'checking'),
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
readonly class GetAccountsController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $userId = (int) $request->getHeader('USER-ID')[0];

        /** @var AccountRepositoryInterface $accountRepository */
        $accountRepository = $this->container->get(AccountRepositoryInterface::class);
        $accounts          = $accountRepository->findAllByUserId($userId);

        $response->getBody()->write(json_encode([
            'accounts' => array_map(fn($account) => $account->jsonSerialize(), $accounts),
        ]));

        return $response->withStatus(StatusCode::OK);
    }
}
