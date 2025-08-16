<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Repository;

use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function create(Account $account): void;

    public function update(Account $account): void;

    public function getByIdAndUser(int $id, int $userId): Account;

    /** @return array<Account> */
    public function findAllByUserId(int $userId): array;
}
