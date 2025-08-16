<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Service;

use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\CreateAccountDto;
use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\Account;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\AccountRepositoryInterface;

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
