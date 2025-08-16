<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Application\Controller;

use OpenApi\Attributes as OA;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Request;
use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\SaveAccountDto;
use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\Account;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\AccountRepositoryInterface;

class CreateAccountController implements ControllerInterface
{
    #[OA\Post(
        path: '/accounts',
        summary: 'Create a new account',
        security: [['bearerAuth' => []]],
        tags: ['Accounts']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(
                    required: ['name', 'type'],
                    properties: [
                        new OA\Property(
                            property: 'name',
                            description: 'Name of the account',
                            type: 'string',
                            example: 'Conta Corrente'
                        ),
                        new OA\Property(
                            property: 'type',
                            description: 'Type of the account (e.g., checking, savings, investment)',
                            type: 'string',
                            example: 'checking'
                        )
                    ]
                )
            ],
        ),
    )]
    #[OA\Response(
        response: 201,
        description: 'Account created successfully',
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Account created successfully',
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
    #[OA\Response(
        response: 400,
        description: 'Validation error',
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: 'error',
                            type: 'string',
                            example: 'Required field missing or invalid data',
                        )
                    ],
                )
            ],
        ),
    )]
    public function processRequest(Container $container, Request $request): void
    {
        $saveAccountDto = SaveAccountDto::fromArray($request->body);
        $user           = $request->getLoggedUser();
        $account        = Account::create($saveAccountDto, $user->id);

        /** @var AccountRepositoryInterface $accountRepository */
        $accountRepository = $container->get(AccountRepositoryInterface::class);
        $accountRepository->create($account);

        sendResponse([
            'message' => 'Account created successfully',
        ], StatusCode::CREATED);
    }
}
