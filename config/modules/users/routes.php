<?php

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Facade\App;
use Tiagolopes\MyCashFlowApi\Users\Application\Controller as Users;

$app = App::getInstance();

$app
    ->post('/users', Users\CreateUserController::class)
    ->post('/login', Users\LoginController::class);
