<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http;

readonly class Route
{
    private function __construct(
        public string $controller,
        public array $params,
        public array $middlewares
    ) {
    }

    public static function create(string $controller, ?array $params, ?array $middlewares): self
    {
        return new self(
            controller: $controller,
            params: $params ?? [],
            middlewares: $middlewares ?? []
        );
    }
}
