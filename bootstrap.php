<?php

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Environment;

require_once __DIR__ . '/vendor/autoload.php';

Environment::initialize(__DIR__);

require_once __DIR__ . '/config/container.php';
require_once __DIR__ . '/config/routes.php';
