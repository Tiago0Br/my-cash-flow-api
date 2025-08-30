<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Domain\Service;

use Tiagolopes\MyCashFlowApi\Finance\Domain\Dto\CreateAccountDto;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Entity\Account;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\AccountRepositoryInterface;

readonly class CreateAccount
{
    public function __construct(private AccountRepositoryInterface $accountRepository)
    {
    }

    public function create(CreateAccountDto $createAccountDto, int $userId): Account
    {
        $account = Account::create($createAccountDto, $userId);

        $this->accountRepository->create($account);

        return $account;
    }
}
