<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Service;

use Tiagolopes\MyCashFlowApi\Core\Domain\Auth\AuthenticationInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Dto\UserWithTokenDto;
use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\InvalidCredentials;
use Tiagolopes\MyCashFlowApi\Core\Domain\Repository\UserRepositoryInterface;

readonly class Login
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private AuthenticationInterface $authentication
    ) {
    }

    public function execute(string $email, string $password): UserWithTokenDto
    {
        $user = $this->userRepository->findByEmail($email);
        if (! $user || ! password_verify($password, $user->password)) {
            throw InvalidCredentials::create();
        }

        $token = $this->authentication->generateToken($user->id);
        return UserWithTokenDto::create($user, $token);
    }
}
