<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Application\Controller;

use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;

class HomeController
{
    #[OA\Get(
        path: '/',
        summary: 'Check if the API is running',
        tags: ['Health Check'],
    )]
    #[OA\Response(
        response: 200,
        description: 'API running!',
        content: new OA\JsonContent(
            allOf: [
                new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            example: 'API running!',
                        )
                    ],
                )
            ],
        ),
    )]
    public function __invoke(Request $request, Response $response): Response
    {
        $response->getBody()->write(json_encode([
            'message' => 'API running!',
        ]));

        return $response->withStatus(StatusCode::OK);
    }
}
