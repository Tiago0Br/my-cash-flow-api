<?php

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Facade\Container;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\UserRepositoryInterface;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\CreateUser;
use Tiagolopes\MyCashFlowApi\Users\Infrastructure\Pdo\UserRepositoryFromPdo;

$container = Container::getInstance();
$db        = Connection::getInstance();

// Service
$container->add(
    item: CreateUser::class,
    resolver: function () use ($container) {
        return new CreateUser(
            userRepository: $container->get(UserRepositoryInterface::class)
        );
    }
);

// Repository
$container->add(
    item: UserRepositoryInterface::class,
    resolver: function () use ($db) {
        return new UserRepositoryFromPdo($db);
    }
);
