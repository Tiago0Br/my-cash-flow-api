<?php

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Middlewares;

use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class JsonResponse
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        $endpoint = $request->getUri()->getPath();
        return $endpoint !== '/docs'
            ? $response->withAddedHeader('Content-Type', 'application/json')
            : $response;
    }
}
