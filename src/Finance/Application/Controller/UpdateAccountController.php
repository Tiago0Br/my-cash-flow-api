<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\UpdateAccountDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\UpdateAccount;

#[OA\Put(
    path: '/accounts/{id}',
    summary: 'Update an existing account',
    security: [['bearerAuth' => []]],
    tags: ['Accounts']
)]
#[OA\Parameter(
    name: 'id',
    description: 'Account ID to update',
    in: 'path',
    required: true,
    schema: new OA\Schema(type: 'integer', example: 1)
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
                        description: 'Updated name of the account',
                        type: 'string',
                        example: 'Conta Poupança Atualizada'
                    ),
                    new OA\Property(
                        property: 'type',
                        description: 'Updated type of the account (e.g., checking, savings, investment)',
                        type: 'string',
                        example: 'savings'
                    )
                ]
            )
        ],
    ),
)]
#[OA\Response(
    response: 200,
    description: 'Account updated successfully',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'message',
                        type: 'string',
                        example: 'Account updated successfully',
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
    response: 404,
    description: 'Account not found or not owned by user',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'error',
                        type: 'string',
                        example: 'Account with id \'1\' not found',
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
readonly class UpdateAccountController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $userId           = (int) $request->getHeader('USER-ID')[0];
        $updateAccountDto = UpdateAccountDto::fromArray(array_merge(
            $request->getParsedBody(),
            $args
        ));

        /** @var UpdateAccount $updateAccount */
        $updateAccount = $this->container->get(UpdateAccount::class);
        $updateAccount->update(updateAccountDto: $updateAccountDto, userId: $userId);

        $response->getBody()->write(json_encode([
            'message' => 'Account updated successfully',
        ]));

        return $response->withStatus(StatusCode::OK);
    }
}
