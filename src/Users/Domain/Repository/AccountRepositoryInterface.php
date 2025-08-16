<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Repository;

use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function create(Account $account): void;

    /** @return array<Account> */
    public function findAllByUserId(int $userId): array;
}
