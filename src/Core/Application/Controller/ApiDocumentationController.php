<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Application\Controller;

use OpenApi\Generator;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\{Request, Response};

class ApiDocumentationController implements ControllerInterface
{
    public function processRequest(Container $container, Request $request, Response $response): void
    {
        $openapi = new Generator()->generate([
            __DIR__ . '/../../Domain/OpenApi',
            __DIR__ . '/../../Application/Controller',
            __DIR__ . '/../../../Finance/Application/Controller'
        ]);

        $response->send($openapi->toJson());
    }
}
