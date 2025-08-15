<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Application\Controller;

use OpenApi\Attributes as OA;
use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\RequestDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Facade\Container;
use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\LoginDto;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\Login;

class LoginController implements ControllerInterface
{
    #[OA\Post(
        path: '/login',
        summary: 'Authenticate user and get access token',
        tags: ['Authentication'],
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(
                    required: ['email', 'password'],
                    properties: [
                        new OA\Property(
                            property: 'email',
                            description: 'Email address of the user',
                            type: 'string',
                            format: 'email',
                            example: 'joao@example.com'
                        ),
                        new OA\Property(
                            property: 'password',
                            description: 'Password for authentication',
                            type: 'string',
                            example: 'mypassword123'
                        )
                    ]
                )
            ],
        ),
    )]
    #[OA\Response(
        response: 200,
        description: 'User authenticated successfully',
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: 'user',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'name', type: 'string', example: 'João Silva'),
                                new OA\Property(property: 'email', type: 'string', example: 'joao@example.com'),
                            ],
                            type: 'object'
                        ),
                        new OA\Property(
                            property: 'token',
                            description: 'Access token for API authentication',
                            type: 'string',
                            example: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...'
                        )
                    ],
                )
            ],
        ),
    )]
    #[OA\Response(
        response: 401,
        description: 'Invalid credentials',
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: 'error',
                            type: 'string',
                            example: 'User not found or incorrect password',
                        )
                    ],
                )
            ],
        ),
    )]
    public function processRequest(Container $container, RequestDto $request): void
    {
        $loginDto = LoginDto::fromArray($request->body);

        /** @var Login $login */
        $login  = $container->get(Login::class);
        $result = $login->execute($loginDto->email, $loginDto->password);

        sendResponse([
            'user'  => $result->user->jsonSerialize(),
            'token' => $result->token,
        ]);
    }
}
