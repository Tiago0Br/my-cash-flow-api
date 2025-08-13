<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Application\Controller;

use RuntimeException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\RequestDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Interfaces\ControllerInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Container;

class SwaggerDocumentationController implements ControllerInterface
{
    public function processRequest(Container $container, RequestDto $request): void
    {
        $swaggerFile = __DIR__ . '/../../../../public/swagger-ui.php';

        if (!file_exists($swaggerFile)) {
            throw new RuntimeException('Swagger UI template not found');
        }

        ob_start();
        require_once $swaggerFile;
        $content = ob_get_clean();

        sendResponse(
            data: $content,
            contentType: 'text/html'
        );
    }
}
