<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Application\Controller;

use RuntimeException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tiagolopes\MyCashFlowApi\Core\Domain\Enum\StatusCode;

class SwaggerDocumentationController
{
    public function __invoke(Request $request, Response $response): Response
    {
        $swaggerFile = __DIR__ . '/../../../../public/swagger-ui.php';

        if (!file_exists($swaggerFile)) {
            throw new RuntimeException('Swagger UI template not found');
        }

        ob_start();
        require_once $swaggerFile;
        $content = ob_get_clean();

        $response->getBody()->write($content);

        return $response
            ->withHeader('Content-Type', 'text/html')
            ->withStatus(StatusCode::OK);
    }
}
