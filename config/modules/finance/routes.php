<?php

declare(strict_types=1);

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\App;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Middlewares\CheckToken;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\RouteGroup;
use Tiagolopes\MyCashFlowApi\Finance\Application\Controller as Finance;

$app = App::getInstance();

$app->group('/accounts', [CheckToken::class], function (RouteGroup $app) {
    $app
        ->post('/', Finance\CreateAccountController::class)
        ->get('/', Finance\GetAccountsController::class)
        ->put('/{id}', Finance\UpdateAccountController::class)
        ->delete('/{id}', Finance\DeleteAccountController::class);
});
$app->group('/categories', [CheckToken::class], function (RouteGroup $app) {
    $app
        ->get('/', Finance\GetCategoriesController::class)
        ->post('/', Finance\CreateCategoryController::class);
});
