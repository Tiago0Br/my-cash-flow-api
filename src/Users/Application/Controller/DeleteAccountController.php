<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Application\Controller;

use OpenApi\Attributes as OA;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Request;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\DeleteAccount;

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
class DeleteAccountController implements ControllerInterface
{
    public function processRequest(Container $container, Request $request): void
    {
        $accountId = (int) $request->params['id'];
        $user      = $request->getLoggedUser();

        /** @var DeleteAccount $deleteAccount */
        $deleteAccount = $container->get(DeleteAccount::class);
        $deleteAccount->delete(accountId: $accountId, userId: $user->id);

        sendResponse([
            'message' => 'Account deleted successfully',
        ]);
    }
}
