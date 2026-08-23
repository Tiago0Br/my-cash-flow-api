<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\SaveUserDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Core\Domain\Service\CreateUser;

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
readonly class CreateUserController
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $createUserDto = SaveUserDto::fromArray($request->getParsedBody());

        /** @var CreateUser $createUser */
        $createUser = $this->container->get(CreateUser::class);
        $createUser->create($createUserDto);

        $response->getBody()->write(json_encode([
            'message' => 'User created successfully',
        ], StatusCode::CREATED));

        return $response->withStatus(StatusCode::CREATED);
    }
}
