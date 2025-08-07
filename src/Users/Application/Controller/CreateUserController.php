<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Application\Controller;

use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\RequestDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Container;
use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\SaveUserDto;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\CreateUser;

class CreateUserController implements ControllerInterface
{
    public function processRequest(Container $container, RequestDto $request): void
    {
        $createUserDto = SaveUserDto::fromArray($request->body);

        /** @var CreateUser $createUser */
        $createUser = $container->get(CreateUser::class);
        $createUser->create($createUserDto);

        sendResponse([
            'message' => 'User created successfully',
        ], 201);
    }
}
