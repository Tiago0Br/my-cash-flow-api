<?php

use Slim\App;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\ErrorHandler;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http\Middlewares\JsonResponse;

/** @var App $app */

$app->addBodyParsingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(displayErrorDetails: true, logErrors: true, logErrorDetails: true);
$errorMiddleware->setDefaultErrorHandler(new ErrorHandler(
    callableResolver: $app->getCallableResolver(),
    responseFactory: $app->getResponseFactory()
));

$app->add(JsonResponse::class);
