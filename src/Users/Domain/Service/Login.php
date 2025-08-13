<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Service;

use Tiagolopes\MyCashFlowApi\Core\Domain\Auth\AuthenticationInterface;
use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\UserWithTokenDto;
use Tiagolopes\MyCashFlowApi\Users\Domain\Exception\InvalidCredentials;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\UserRepositoryInterface;

readonly class Login
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private AuthenticationInterface $authentication
    ) {
    }

    public function execute(string $email, string $password): UserWithTokenDto
    {
        $user = $this->userRepository->findUserByEmail($email);
        if (! $user || ! password_verify($password, $user->password)) {
            throw InvalidCredentials::create();
        }

        $token = $this->authentication->generateToken($user->id);
        return UserWithTokenDto::create($user, $token);
    }
}
