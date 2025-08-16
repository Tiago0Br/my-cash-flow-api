<?php

use Tiagolopes\MyCashFlowApi\Core\Application\Controller\ApiDocumentationController;
use Tiagolopes\MyCashFlowApi\Core\Application\Controller\SwaggerDocumentationController;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\App;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\ErrorHandler;

$app = App::getInstance();

/** @var string[] $modules */
$modules = require __DIR__ . '/modules.php';
foreach ($modules as $module) {
    if (file_exists(__DIR__ . "/modules/$module/routes.php")) {
        require_once __DIR__ . "/modules/$module/routes.php";
    }
}

// Load API documentation
$app
    ->get('/docs/json', ApiDocumentationController::class)
    ->get('/docs', SwaggerDocumentationController::class);

try {
    $app->run();
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
