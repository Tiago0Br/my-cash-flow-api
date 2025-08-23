<?php

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Contracts;

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Request;

interface ControllerInterface
{
    public function processRequest(Container $container, Request $request): void;
}
