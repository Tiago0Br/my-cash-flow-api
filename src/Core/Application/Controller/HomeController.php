<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Application\Controller;

use OpenApi\Attributes as OA;
use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\RequestDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Container;

class HomeController implements ControllerInterface
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
    public function processRequest(Container $container, RequestDto $request): void
    {
        sendResponse([
            'message' => 'API running!',
        ]);
    }
}
