<?php

use Tiagolopes\MyCashFlowApi\Core\Application\Controller as Core;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Facade\App;

$app = App::getInstance();

$app
    ->get('/', Core\HomeController::class);
