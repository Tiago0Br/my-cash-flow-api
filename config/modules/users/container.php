<?php

declare(strict_types=1);

use Tiagolopes\MyCashFlowApi\Core\Domain\Auth\AuthenticationInterface;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\AccountRepositoryInterface;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\UserRepositoryInterface;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\CreateAccount;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\CreateUser;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\DeleteAccount;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\Login;
use Tiagolopes\MyCashFlowApi\Users\Domain\Service\UpdateAccount;
use Tiagolopes\MyCashFlowApi\Users\Infrastructure\Pdo\AccountRepositoryFromPdo;
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

$container->add(
    item: Login::class,
    resolver: function () use ($container) {
        return new Login(
            userRepository: $container->get(UserRepositoryInterface::class),
            authentication: $container->get(AuthenticationInterface::class)
        );
    }
);

$container->add(
    item: CreateAccount::class,
    resolver: function () use ($container) {
        return new CreateAccount(
            accountRepository: $container->get(AccountRepositoryInterface::class)
        );
    }
);

$container->add(
    item: UpdateAccount::class,
    resolver: function () use ($container) {
        return new UpdateAccount(
            accountRepository: $container->get(AccountRepositoryInterface::class)
        );
    }
);

$container->add(
    item: DeleteAccount::class,
    resolver: function () use ($container) {
        return new DeleteAccount(
            accountRepository: $container->get(AccountRepositoryInterface::class)
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

$container->add(
    item: AccountRepositoryInterface::class,
    resolver: function () use ($db) {
        return new AccountRepositoryFromPdo($db);
    }
);
