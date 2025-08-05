<?php

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces;

use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\RequestDto;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Container;

interface ControllerInterface
{
    public function processRequest(Container $container, RequestDto $request): void;
}
