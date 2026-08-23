<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\DeleteAccount;

#[OA\Delete(
    path: '/accounts/{id}',
    summary: 'Delete an existing account',
    security: [['bearerAuth' => []]],
    tags: ['Accounts']
)]
#[OA\Parameter(
    name: 'id',
    description: 'Account ID to delete',
    in: 'path',
    required: true,
    schema: new OA\Schema(type: 'integer', example: 1)
)]
#[OA\Response(
    response: 200,
    description: 'Account deleted successfully',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'message',
                        type: 'string',
                        example: 'Account deleted successfully',
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
readonly class DeleteAccountController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $accountId = (int) $args['id'];
        $userId    = (int) $request->getHeader('USER-ID')[0];

        /** @var DeleteAccount $deleteAccount */
        $deleteAccount = $this->container->get(DeleteAccount::class);
        $deleteAccount->delete(accountId: $accountId, userId: $userId);

        $response->getBody()->write(json_encode([
            'message' => 'Account deleted successfully',
        ]));

        return $response->withStatus(StatusCode::OK);
    }
}
