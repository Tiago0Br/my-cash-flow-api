<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Application\Controller;

use OpenApi\Generator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;

class ApiDocumentationController
{
    public function __invoke(Request $request, Response $response): Response
    {
        $openapi = new Generator()->generate([
            __DIR__ . '/../../Domain/OpenApi',
            __DIR__ . '/../../Application/Controller',
            __DIR__ . '/../../../Finance/Application/Controller'
        ]);

        $response->getBody()->write($openapi->toJson());

        return $response->withStatus(StatusCode::OK);
    }
}
