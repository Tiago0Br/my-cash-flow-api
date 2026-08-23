<?php

use Slim\App;
use Tiagolopes\MyCashFlowApi\Core\Application\Controller as Core;

/** @var App $app */

$app->get('', new Core\HomeController());
$app->post('/users', new Core\CreateUserController($app->getContainer()));
$app->post('/login', new Core\LoginController($app->getContainer()));
