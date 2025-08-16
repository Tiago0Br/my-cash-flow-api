<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Application\Controller;

use OpenApi\Attributes as OA;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Request;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\AccountRepositoryInterface;

class GetAccountsController implements ControllerInterface
{
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
    public function processRequest(Container $container, Request $request): void
    {
        $user = $request->getLoggedUser();

        /** @var AccountRepositoryInterface $accountRepository */
        $accountRepository = $container->get(AccountRepositoryInterface::class);
        $accounts          = $accountRepository->findAllByUserId($user->id);

        sendResponse([
            'accounts' => array_map(fn($account) => $account->jsonSerialize(), $accounts),
        ]);
    }
}
