<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\OpenApi;

use OpenApi\Attributes as OA;

#[OA\OpenApi(
    openapi: "3.0.0"
)]
#[OA\Info(
    version: "1.0.0",
    description: "A REST API for managing my cash flow.",
    title: "My CashFlow API",
    contact: new OA\Contact(
        name: "Tiago Lopes",
        email: "tiagoltavares2002@gmail.com"
    )
)]
#[OA\Server(
    url: "/",
    description: "API Server"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    description: "JWT Authentication",
    bearerFormat: "JWT",
    scheme: "bearer"
)]
class OpenApiDefinition
{
}
