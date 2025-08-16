<?php

declare(strict_types=1);

use Tiagolopes\MyCashFlowApi\Core\Domain\Auth\AuthenticationInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Repository\SessionRepository;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Auth\Authentication;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Repository\Pdo\SessionRepositoryFromPdo;

$container = Container::getInstance();
$db        = Connection::getInstance();

// Repository
$container->add(
    item: SessionRepository::class,
    resolver: function () use ($db) {
        return new SessionRepositoryFromPdo($db);
    }
);


// Auth
$container->add(
    item: AuthenticationInterface::class,
    resolver: function () use ($container) {
        return new Authentication($container->get(SessionRepository::class));
    }
);
