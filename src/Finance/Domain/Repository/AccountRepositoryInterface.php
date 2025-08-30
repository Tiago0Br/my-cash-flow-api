<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Repository;

use Tiagolopes\MyCashFlowApi\Finance\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function create(Account $account): void;

    public function update(Account $account): void;

    public function getByIdAndUser(int $id, int $userId): Account;

    /** @return array<Account> */
    public function findAllByUserId(int $userId): array;

    public function delete(Account $account): void;
}
