<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Enum;

final class StatusCode
{
    public const int OK = 200;
    public const int CREATED = 201;
    public const int BAD_REQUEST = 400;
    public const int UNAUTHORIZED = 401;
    public const int FORBIDDEN = 403;
    public const int NOT_FOUND = 404;
    public const int CONFLICT = 409;
    public const int INTERNAL_SERVER_ERROR = 500;
}
