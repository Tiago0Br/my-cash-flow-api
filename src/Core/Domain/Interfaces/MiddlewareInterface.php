<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces;

use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\RequestDto;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;

interface MiddlewareInterface
{
    public function handle(Container $container, RequestDto $request): void;
}
