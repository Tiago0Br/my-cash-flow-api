<?php

declare(strict_types=1);

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DependecyInjection\Container;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\AccountRepositoryInterface;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\CategoryRepositoryInterface;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\CreateAccount;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\CreateCategory;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\DeleteAccount;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\UpdateAccount;
use Tiagolopes\MyCashFlowApi\Finance\Infrastructure\Repository\Pdo\AccountRepositoryFromPdo;
use Tiagolopes\MyCashFlowApi\Finance\Infrastructure\Repository\Pdo\CategoryRepositoryFromPdo;

$container = Container::getInstance();
$db        = Connection::getInstance();

// Services
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

$container->add(
    item: CreateCategory::class,
    resolver: function () use ($container) {
        return new CreateCategory(
            categoryRepository: $container->get(CategoryRepositoryInterface::class)
        );
    }
);

// Repository
$container->add(
    item: AccountRepositoryInterface::class,
    resolver: function () use ($db) {
        return new AccountRepositoryFromPdo($db);
    }
);

$container->add(
    item: CategoryRepositoryInterface::class,
    resolver: function () use ($db) {
        return new CategoryRepositoryFromPdo($db);
    }
);
