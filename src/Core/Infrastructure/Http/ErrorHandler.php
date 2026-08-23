<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http;

use DomainException;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;
use Throwable;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\NotFoundException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\UnauthorizedException;

class ErrorHandler extends SlimErrorHandler
{
    protected function respond(): ResponseInterface
    {
        $exception = $this->exception;
        $response = $this->responseFactory->createResponse();

        $statusCode = 500;
        $code = 'INTERNAL_SERVER_ERROR';
        $message = 'Ocorreu um erro interno no servidor.';

        if ($exception instanceof InvalidArgumentException) {
            $statusCode = 400;
            $code = 'VALIDATION_ERROR';
            $message = $exception->getMessage();
        } elseif ($exception instanceof HttpNotFoundException || $exception instanceof NotFoundException) {
            $statusCode = 404;
            $code = 'NOT_FOUND';
            $message = 'Recurso não encontrado.';
        } else if ($exception instanceof UnauthorizedException) {
            $statusCode = 401;
            $code = 'UNAUTHORIZED';
            $message = 'Acesso não autorizado.';
        } else {
            if (getenv('ENVIRONMENT') === 'development') {
                $message = $exception->getMessage();
            }
        }

        $response->getBody()->write(json_encode([
            'code' => $code,
            'error' => $message
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }

    private function getStatusCodeByError(Throwable $error): int
    {
        if ($error instanceof NotFoundException) return StatusCode::NOT_FOUND;
        if ($error instanceof UnauthorizedException) return StatusCode::UNAUTHORIZED;
        if ($error instanceof DomainException) return StatusCode::CONFLICT;
        if ($error instanceof InvalidArgumentException) return StatusCode::BAD_REQUEST;

        return StatusCode::INTERNAL_SERVER_ERROR;
    }
}
