<?php

declare(strict_types=1);

use Tiagolopes\MyCashFlowApi\Core\Domain\Auth\AuthenticationInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Repository\SessionRepository;
use Tiagolopes\MyCashFlowApi\Core\Domain\Repository\UserRepositoryInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Service\CreateUser;
use Tiagolopes\MyCashFlowApi\Core\Domain\Service\Login;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Auth\Authentication;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Repository\Pdo\SessionRepositoryFromPdo;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Repository\Pdo\UserRepositoryFromPdo;

$container = Container::getInstance();
$db        = Connection::getInstance();

// Services
$container->add(
    item: CreateUser::class,
    resolver: function () use ($container) {
        return new CreateUser(
            userRepository: $container->get(UserRepositoryInterface::class)
        );
    }
);

$container->add(
    item: Login::class,
    resolver: function () use ($container) {
        return new Login(
            userRepository: $container->get(UserRepositoryInterface::class),
            authentication: $container->get(AuthenticationInterface::class)
        );
    }
);

// Repository
$container->add(
    item: SessionRepository::class,
    resolver: function () use ($db) {
        return new SessionRepositoryFromPdo($db);
    }
);

$container->add(
    item: UserRepositoryInterface::class,
    resolver: function () use ($db) {
        return new UserRepositoryFromPdo($db);
    }
);

// Auth
$container->add(
    item: AuthenticationInterface::class,
    resolver: function () use ($container) {
        return new Authentication($container->get(SessionRepository::class));
    }
);
