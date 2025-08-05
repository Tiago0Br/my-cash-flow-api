<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure;

use RuntimeException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\RequestDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\NotFoundException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\MiddlewareInterface;

class App
{
    private static ?self $instance = null;
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    private function addMethod(
        string $httpMethod,
        string $uri,
        string $controller,
        array $middlewares = []
    ): void {
        $this->routes[$httpMethod][$uri] = [
            'controller'  => $controller,
            'middlewares' => $middlewares,
        ];
    }

    public function get(string $uri, string $controller, array $middlewares = []): self
    {
        $this->addMethod(httpMethod: 'GET', uri: $uri, controller: $controller, middlewares: $middlewares);

        return $this;
    }

    public function post(string $uri, string $controller, array $middlewares = []): self
    {
        $this->addMethod(httpMethod: 'POST', uri: $uri, controller: $controller, middlewares: $middlewares);

        return $this;
    }

    public function put(string $uri, string $controller, array $middlewares = []): self
    {
        $this->addMethod(httpMethod: 'PUT', uri: $uri, controller: $controller, middlewares: $middlewares);

        return $this;
    }

    public function delete(string $uri, string $controller, array $middlewares = []): self
    {
        $this->addMethod(httpMethod: 'DELETE', uri: $uri, controller: $controller, middlewares: $middlewares);

        return $this;
    }

    public function run(): void
    {
        $httpMethod = $_POST['method'] ?? $_SERVER['REQUEST_METHOD'];
        $uri        = $_SERVER['PATH_INFO'] ?? '/';

        $route = $this->searchRoute(httpMethod: $httpMethod, uri: $uri);
        if (! $route) {
            throw NotFoundException::create();
        }

        $routeInfo        = $route['info'];
        $routeParams      = $route['params'];
        $controllerClass  = $routeInfo['controller'];
        $middlewaresArray = $routeInfo['middlewares'];

        $middlewares   = $this->getMiddlewares(middlewares: $middlewaresArray);
        $controller    = $this->getController(controllerClass: $controllerClass);
        $requestParams = $this->getRequest(routeParams: $routeParams);
        $container     = Container::getInstance();

        foreach ($middlewares as $middleware) {
            $middleware->handle($container, $requestParams);
        }

        $controller->processRequest($container, $requestParams);
    }

    private function searchRoute(string $httpMethod, string $uri): ?array
    {
        $matchedRoute = null;
        $routeParams  = [];

        foreach ($this->routes[$httpMethod] ?? [] as $routePattern => $routeInfo) {
            $params = $this->matchRoute($uri, $routePattern);
            if ($params !== null) {
                $matchedRoute = $routeInfo;
                $routeParams  = $params;
                break;
            }
        }

        return $matchedRoute
            ? [
                'info'   => $matchedRoute,
                'params' => $routeParams,
            ]
            : null;
    }

    private function getController(string $controllerClass): ControllerInterface
    {
        if (! class_exists($controllerClass)) {
            throw new RuntimeException("Controller '$controllerClass' not found");
        }

        $controller = new $controllerClass;
        if (! $controller instanceof ControllerInterface) {
            throw new RuntimeException("Controller '$controllerClass' must implement ControllerInterface");
        }

        return $controller;
    }

    /** @return MiddlewareInterface[] */
    private function getMiddlewares(array $middlewares): array
    {
        return array_map(function (string $middlewareClass) {
            if (! class_exists($middlewareClass)) {
                throw new RuntimeException("Middleware '$middlewareClass' not found");
            }

            $middleware = new $middlewareClass;
            if (! $middleware instanceof MiddlewareInterface) {
                throw new RuntimeException("Middleware '$middlewareClass' must implement MiddlewareInterface");
            }

            return $middleware;
        }, $middlewares);
    }

    private function getRequest(array $routeParams = []): RequestDto
    {
        return RequestDto::create(
            headers: getallheaders() ?: [],
            params: $routeParams,
            query: $_GET,
            body: json_decode(
                json: file_get_contents('php://input') ?: '{}',
                associative: true,
                flags: JSON_THROW_ON_ERROR
            )
        );
    }

    private function matchRoute(string $requestUri, string $routePattern): ?array
    {
        $pattern = preg_replace(pattern: '/\{([^}]+)}/', replacement: '(?P<$1>[^/]+)', subject: $routePattern);
        $pattern = "@^" . $pattern . "$@D";

        $params = [];
        if (preg_match(pattern: $pattern, subject: $requestUri, matches: $matches)) {
            foreach ($matches as $key => $value) {
                if (is_string($key)) {
                    $params[$key] = $value;
                }
            }
            return $params;
        }

        return null;
    }
}
