<?php

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\App;
use Tiagolopes\MyCashFlowApi\Users\Application\Controller\CreateUserController;

$app = App::getInstance();

$app
    ->post('/users', CreateUserController::class);

$app->run();
