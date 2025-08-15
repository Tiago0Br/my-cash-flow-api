<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Application\Controller;

use OpenApi\Generator;
use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\RequestDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Facade\Container;

class ApiDocumentationController implements ControllerInterface
{
    public function processRequest(Container $container, RequestDto $request): void
    {
        $openapi = new Generator()->generate([
            __DIR__ . '/../../Domain/OpenApi',
            __DIR__ . '/../../Application/Controller',
            __DIR__ . '/../../../Users/Application/Controller'
        ]);

        sendResponse(
            $openapi->toJson(),
        );
    }
}
