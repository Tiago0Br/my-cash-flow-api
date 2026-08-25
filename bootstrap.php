<?php

require_once __DIR__ . '/vendor/autoload.php';

use DI\Container;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

require_once __DIR__ . '/config/container.php';
require_once __DIR__ . '/config/middlewares.php';
require_once __DIR__ . '/config/routes.php';

$app->run();
