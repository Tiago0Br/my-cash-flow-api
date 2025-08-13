<?php

use Tiagolopes\MyCashFlowApi\Core\Application\Controller\ApiDocumentationController;
use Tiagolopes\MyCashFlowApi\Core\Application\Controller\HomeController;
use Tiagolopes\MyCashFlowApi\Core\Application\Controller\SwaggerDocumentationController;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Facade\App;
use Tiagolopes\MyCashFlowApi\Users\Application\Controller\CreateUserController;
use Tiagolopes\MyCashFlowApi\Users\Application\Controller\LoginController;

$app = App::getInstance();

$app
    ->get('/', HomeController::class)
    ->post('/users', CreateUserController::class)
    ->post('/login', LoginController::class)
    ->get('/docs/json', ApiDocumentationController::class)
    ->get('/docs', SwaggerDocumentationController::class);

$app->run();
