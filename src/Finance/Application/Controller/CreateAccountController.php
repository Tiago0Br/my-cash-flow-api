<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\CreateAccountDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\CreateAccount;

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
readonly class CreateAccountController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $createAccountDto = CreateAccountDto::fromArray($request->getParsedBody());
        $userId           = (int) $request->getHeader('USER-ID')[0];

        /** @var CreateAccount $createAccount */
        $createAccount = $this->container->get(CreateAccount::class);
        $createAccount->create(createAccountDto: $createAccountDto, userId: $userId);

        $response->getBody()->write(json_encode([
            'message' => 'Account created successfully',
        ]));

        return $response->withStatus(StatusCode::CREATED);
    }
}
