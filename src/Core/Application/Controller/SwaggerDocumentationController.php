<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Application\Controller;

use RuntimeException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\{Request, Response};

class SwaggerDocumentationController implements ControllerInterface
{
    public function processRequest(Container $container, Request $request, Response $response): void
    {
        $swaggerFile = __DIR__ . '/../../../../public/swagger-ui.php';

        if (!file_exists($swaggerFile)) {
            throw new RuntimeException('Swagger UI template not found');
        }

        ob_start();
        require_once $swaggerFile;
        $content = ob_get_clean();

        $response->send(
            data: $content,
            contentType: 'text/html'
        );
    }
}
