<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Service;

use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\SaveUserDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Entity\User;
use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\EmailAlreadyRegistered;
use Tiagolopes\MyCashFlowApi\Core\Domain\Repository\UserRepositoryInterface;

readonly class CreateUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function create(SaveUserDto $saveUserDto): User
    {
        $userAlreadyExists = $this->userRepository->findByEmail($saveUserDto->email);
        if ($userAlreadyExists) {
            throw EmailAlreadyRegistered::fromEmail($saveUserDto->email);
        }

        $user = User::create($saveUserDto);
        $this->userRepository->create($user);

        return $user;
    }
}
