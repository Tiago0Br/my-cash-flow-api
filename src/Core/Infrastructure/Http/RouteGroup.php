<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http;

use RuntimeException;

class RouteGroup
{
    private string $prefix;
    private array $middlewares;
    private App $app;

    public function __construct(App $app, string $prefix = '', array $middlewares = [])
    {
        $this->app = $app;
        $this->prefix = rtrim($prefix, '/');
        $this->middlewares = $middlewares;
    }

    public function get(string $uri, string $controller, array $middlewares = []): self
    {
        $this->registerRoute('get', $uri, $controller, $middlewares);

        return $this;
    }

    public function post(string $uri, string $controller, array $middlewares = []): self
    {
        $this->registerRoute('post', $uri, $controller, $middlewares);

        return $this;
    }

    public function put(string $uri, string $controller, array $middlewares = []): self
    {
        $this->registerRoute('put', $uri, $controller, $middlewares);

        return $this;
    }

    public function delete(string $uri, string $controller, array $middlewares = []): self
    {
        $this->registerRoute('delete', $uri, $controller, $middlewares);

        return $this;
    }

    private function registerRoute(string $method, string $uri, string $controller, array $middlewares = []): void
    {
        $fullUri = $this->prefix . rtrim($uri, '/');
        $allMiddlewares = array_merge($this->middlewares, $middlewares);

        if (! method_exists($this->app, $method)) {
            throw new RuntimeException("HTTP method $method is not supported.");
        }

        $this->app->$method($fullUri, $controller, $allMiddlewares);
    }

    public function group(string $prefix, array $middlewares, callable $callback): self
    {
        $nestedGroup = new self(
            app: $this->app,
            prefix: $this->prefix . '/' . ltrim($prefix, '/'),
            middlewares: array_merge($this->middlewares, $middlewares)
        );

        $callback($nestedGroup);

        return $this;
    }
}
