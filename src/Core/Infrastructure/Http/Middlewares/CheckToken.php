<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Middlewares;

use Tiagolopes\MyCashFlowApi\Core\Domain\Auth\AuthenticationInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\UnauthorizedException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\MiddlewareInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Request;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\UserRepositoryInterface;

class CheckToken implements MiddlewareInterface
{
    public function handle(Container $container, Request $request): void
    {
        $token = $this->extractTokenFromRequest($request);

        /** @var AuthenticationInterface $authentication */
        $authentication = $container->get(AuthenticationInterface::class);
        $userId         = $authentication->verifyToken($token);

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $container->get(UserRepositoryInterface::class);
        $user           = $userRepository->getById($userId);

        $request->setLoggedUser($user);
    }

    private function extractTokenFromRequest(Request $request): string
    {
        $authHeader = $request->headers['Authorization']
            ?? $request->headers['authorization']
            ?? null;

        if (! is_string($authHeader) || trim($authHeader) === '') {
            throw UnauthorizedException::create();
        }

        $token = preg_replace(pattern: '/^Bearer\s+/i', replacement: '', subject: trim($authHeader));

        if (empty($token)) {
            throw UnauthorizedException::create();
        }

        return $token;
    }
}
