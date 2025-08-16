<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http;

use DomainException;
use InvalidArgumentException;
use Throwable;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;
use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\NotFoundException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\UnauthorizedException;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Log\Logger;

class ErrorHandler
{
    public static function handle(Throwable $error): void
    {
        $statusCode = self::getStatusCodeByError($error);

        if ($statusCode === StatusCode::INTERNAL_SERVER_ERROR) {
            if ($_ENV['APP_ENV'] !== 'production') {
                sprintf('Error: %s', $error->getMessage());
            } else {
                Logger::log(
                    filename: 'internal-errors.log',
                    message: $error->getMessage()
                );
            }
        }

        sendResponse(
            data: [
                'error' => $statusCode !== StatusCode::INTERNAL_SERVER_ERROR
                    ? $error->getMessage()
                    : 'Internal server error.',
            ],
            code: $statusCode
        );
    }

    private static function getStatusCodeByError(Throwable $error): int
    {
        if ($error instanceof NotFoundException) return StatusCode::NOT_FOUND;
        if ($error instanceof UnauthorizedException) return StatusCode::UNAUTHORIZED;
        if ($error instanceof DomainException) return StatusCode::CONFLICT;
        if ($error instanceof InvalidArgumentException) return StatusCode::BAD_REQUEST;

        return StatusCode::INTERNAL_SERVER_ERROR;
    }
}
