<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Middlewares;

use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Tiagolopes\MyCashFlowApi\Core\Domain\Auth\AuthenticationInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\UnauthorizedException;

readonly class CheckToken
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $token = $this->extractTokenFromRequest($request);

        /** @var AuthenticationInterface $authentication */
        $authentication = $this->container->get(AuthenticationInterface::class);
        $userId         = $authentication->verifyToken($token);

        $response = $handler->handle($request);

        return $response
            ->withAddedHeader('USER-ID', $userId);
    }

    private function extractTokenFromRequest(Request $request): string
    {
        $authHeader = $request->getHeader('Authorization')[0]
            ?? $request->getHeader('authorization')[0]
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
