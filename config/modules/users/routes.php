<?php

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\App;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Middlewares\CheckToken;
use Tiagolopes\MyCashFlowApi\Users\Application\Controller as Users;

$app = App::getInstance();

$app
    ->post('/users', Users\CreateUserController::class)
    ->post('/login', Users\LoginController::class)
    ->post('/accounts', Users\CreateAccountController::class, [CheckToken::class])
    ->get('/accounts', Users\GetAccountsController::class, [CheckToken::class])
    ->put('/accounts/{id}', Users\UpdateAccountController::class, [CheckToken::class])
    ->delete('/accounts/{id}', Users\DeleteAccountController::class, [CheckToken::class])
    ->get('/categories', Users\GetCategoriesController::class, [CheckToken::class]);
