<?php

declare(strict_types=1);

use DI\Container;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\AccountRepositoryInterface;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\CategoryRepositoryInterface;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\TransactionRepositoryInterface;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\CreateAccount;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\CreateCategory;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\CreateTransaction;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\DeleteAccount;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\UpdateAccount;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Service\UpdateTransaction;
use Tiagolopes\MyCashFlowApi\Finance\Infrastructure\Repository\Pdo\AccountRepositoryFromPdo;
use Tiagolopes\MyCashFlowApi\Finance\Infrastructure\Repository\Pdo\CategoryRepositoryFromPdo;
use Tiagolopes\MyCashFlowApi\Finance\Infrastructure\Repository\Pdo\TransactionRepositoryFromPdo;

/** @var Container $container */

$db = Connection::getInstance();

// Services
$container->set(
    name: CreateAccount::class,
    value: function () use ($container) {
        return new CreateAccount(
            accountRepository: $container->get(AccountRepositoryInterface::class)
        );
    }
);

$container->set(
    name: UpdateAccount::class,
    value: function () use ($container) {
        return new UpdateAccount(
            accountRepository: $container->get(AccountRepositoryInterface::class)
        );
    }
);

$container->set(
    name: DeleteAccount::class,
    value: function () use ($container) {
        return new DeleteAccount(
            accountRepository: $container->get(AccountRepositoryInterface::class)
        );
    }
);

$container->set(
    name: CreateCategory::class,
    value: function () use ($container) {
        return new CreateCategory(
            categoryRepository: $container->get(CategoryRepositoryInterface::class)
        );
    }
);

$container->set(
    name: CreateTransaction::class,
    value: function () use ($container) {
        return new CreateTransaction(
            transactionRepository: $container->get(TransactionRepositoryInterface::class)
        );
    }
);

$container->set(
    name: UpdateTransaction::class,
    value: function () use ($container) {
        return new UpdateTransaction(
            transactionRepository: $container->get(TransactionRepositoryInterface::class)
        );
    }
);

// Repository
$container->set(
    name: AccountRepositoryInterface::class,
    value: function () use ($db) {
        return new AccountRepositoryFromPdo($db);
    }
);

$container->set(
    name: CategoryRepositoryInterface::class,
    value: function () use ($db) {
        return new CategoryRepositoryFromPdo($db);
    }
);

$container->set(
    name: TransactionRepositoryInterface::class,
    value: function () use ($db) {
        return new TransactionRepositoryFromPdo($db);
    }
);
