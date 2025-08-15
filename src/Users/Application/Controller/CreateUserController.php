<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Application\Controller;

use OpenApi\Attributes as OA;
use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\RequestDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\SaveUserDto;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\CreateUser;

class CreateUserController implements ControllerInterface
{
    #[OA\Post(
        path: '/users',
        summary: 'Create a new user',
        tags: ['Users'],
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(
                    required: ['name', 'email', 'password'],
                    properties: [
                        new OA\Property(
                            property: 'name',
                            description: 'Full name of the user',
                            type: 'string',
                            example: 'João Silva'
                        ),
                        new OA\Property(
                            property: 'email',
                            description: 'Email address of the user',
                            type: 'string',
                            format: 'email',
                            example: 'joao@example.com'
                        ),
                        new OA\Property(
                            property: 'password',
                            description: 'Password for the user account',
                            type: 'string',
                            minLength: 8,
                            example: 'mypassword123'
                        )
                    ]
                )
            ],
        ),
    )]
    #[OA\Response(
        response: 201,
        description: 'User created successfully',
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'User created successfully',
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
                            example: 'Email \'user@example.com\' already registered',
                        )
                    ],
                )
            ],
        ),
    )]
    public function processRequest(Container $container, RequestDto $request): void
    {
        $createUserDto = SaveUserDto::fromArray($request->body);

        /** @var CreateUser $createUser */
        $createUser = $container->get(CreateUser::class);
        $createUser->create($createUserDto);

        sendResponse([
            'message' => 'User created successfully',
        ], StatusCode::CREATED);
    }
}
