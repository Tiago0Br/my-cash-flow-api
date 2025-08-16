<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Service;

use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\AccountRepositoryInterface;

readonly class DeleteAccount
{
    public function __construct(private AccountRepositoryInterface $accountRepository)
    {
    }

    public function delete(int $accountId, int $userId): void
    {
        $account = $this->accountRepository->getByIdAndUser($accountId, $userId);
        $this->accountRepository->delete($account);
    }
}
