<?php

use Slim\App;
use Tiagolopes\MyCashFlowApi\Core\Application\Controller\ApiDocumentationController;
use Tiagolopes\MyCashFlowApi\Core\Application\Controller\SwaggerDocumentationController;

/** @var App $app */

/** @var string[] $modules */
$modules = require __DIR__ . '/modules.php';
foreach ($modules as $module) {
    if (file_exists(__DIR__ . "/modules/$module/routes.php")) {
        require_once __DIR__ . "/modules/$module/routes.php";
    }
}

// Load API documentation
$app->get('/docs/json', ApiDocumentationController::class);
$app->get('/docs', SwaggerDocumentationController::class);
