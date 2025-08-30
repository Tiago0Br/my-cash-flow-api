<?php

declare(strict_types=1);

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\App;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Middlewares\CheckToken;
use Tiagolopes\MyCashFlowApi\Finance\Application\Controller as Finance;

$app = App::getInstance();

$app
    ->post('/accounts', Finance\CreateAccountController::class, [CheckToken::class])
    ->get('/accounts', Finance\GetAccountsController::class, [CheckToken::class])
    ->put('/accounts/{id}', Finance\UpdateAccountController::class, [CheckToken::class])
    ->delete('/accounts/{id}', Finance\DeleteAccountController::class, [CheckToken::class])
    ->get('/categories', Finance\GetCategoriesController::class, [CheckToken::class])
    ->post('/categories', Finance\CreateCategoryController::class, [CheckToken::class]);
