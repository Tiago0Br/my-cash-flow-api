<?php

declare(strict_types=1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Middlewares\CheckToken;
use Tiagolopes\MyCashFlowApi\Finance\Application\Controller as Finance;

/** @var App $app */

$app->group('/accounts', function (RouteCollectorProxy $group) use ($app) {
    $group->post('', new Finance\CreateAccountController($app->getContainer()));
    $group->get('', new Finance\GetAccountsController($app->getContainer()));
    $group->put('/{id}', new Finance\UpdateAccountController($app->getContainer()));
    $group->delete('/{id}', new Finance\DeleteAccountController($app->getContainer()));
})->add(new CheckToken($app->getContainer()));

$app->group('/categories', function (RouteCollectorProxy $group) use ($app) {
    $group->get('', new Finance\GetCategoriesController($app->getContainer()));
    $group->post('', new Finance\CreateCategoryController($app->getContainer()));
})->add(new CheckToken($app->getContainer()));

$app->group('/transactions', function (RouteCollectorProxy $group) use ($app) {
    $group->get('', new Finance\GetAllTransactionsController($app->getContainer()));
    $group->post('', new Finance\CreateTransactionController($app->getContainer()));
    $group->get('/{id}', new Finance\GetTransactionByIdController($app->getContainer()));
    $group->put('/{id}', new Finance\UpdateTransactionController($app->getContainer()));
})->add(new CheckToken($app->getContainer()));
