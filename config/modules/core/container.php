<?php

declare(strict_types=1);

use DI\Container;
use Tiagolopes\MyCashFlowApi\Core\Domain\Auth\AuthenticationInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Repository\SessionRepository;
use Tiagolopes\MyCashFlowApi\Core\Domain\Repository\UserRepositoryInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Service\CreateUser;
use Tiagolopes\MyCashFlowApi\Core\Domain\Service\Login;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Auth\Authentication;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Repository\Pdo\SessionRepositoryFromPdo;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Repository\Pdo\UserRepositoryFromPdo;

/** @var Container $container */

$db = Connection::getInstance();

// Services
$container->set(
    name: CreateUser::class,
    value: function () use ($container) {
        return new CreateUser(
            userRepository: $container->get(UserRepositoryInterface::class)
        );
    }
);

$container->set(
    name: Login::class,
    value: function () use ($container) {
        return new Login(
            userRepository: $container->get(UserRepositoryInterface::class),
            authentication: $container->get(AuthenticationInterface::class)
        );
    }
);

// Repository
$container->set(
    name: SessionRepository::class,
    value: function () use ($db) {
        return new SessionRepositoryFromPdo($db);
    }
);

$container->set(
    name: UserRepositoryInterface::class,
    value: function () use ($db) {
        return new UserRepositoryFromPdo($db);
    }
);

// Auth
$container->set(
    name: AuthenticationInterface::class,
    value: function () use ($container) {
        return new Authentication($container->get(SessionRepository::class));
    }
);
