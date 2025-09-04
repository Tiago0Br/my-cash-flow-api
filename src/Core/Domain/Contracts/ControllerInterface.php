<?php

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Contracts;

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Request;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Response;

interface ControllerInterface
{
    public function processRequest(Container $container, Request $request, Response $response): void;
}
