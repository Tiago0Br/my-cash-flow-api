<?php

require_once __DIR__ . '/vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Environment\Environment;

Environment::initialize(__DIR__);

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

require_once __DIR__ . '/config/container.php';
require_once __DIR__ . '/config/middlewares.php';
require_once __DIR__ . '/config/routes.php';

$app->run();
