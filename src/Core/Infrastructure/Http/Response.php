<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http;

use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;

class Response
{
    public function send(
        array|string|null $data = null,
        int $code = StatusCode::OK,
        string $contentType = 'application/json'
    ): void {
        sendResponse($data, $code, $contentType);
    }
}
