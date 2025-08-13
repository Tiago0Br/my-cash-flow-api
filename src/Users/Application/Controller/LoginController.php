<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Application\Controller;

use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\RequestDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Facade\Container;
use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\LoginDto;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\Login;

class LoginController implements ControllerInterface
{
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
