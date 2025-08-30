<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Service;

use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\UpdateAccountDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\AccountRepositoryInterface;

readonly class UpdateAccount
{
    public function __construct(private AccountRepositoryInterface $accountRepository)
    {
    }

    public function update(UpdateAccountDto $updateAccountDto, int $userId): void
    {
        $account = $this->accountRepository->getByIdAndUser($updateAccountDto->id, $userId);

        $account->update($updateAccountDto);
        $this->accountRepository->update($account);
    }
}
