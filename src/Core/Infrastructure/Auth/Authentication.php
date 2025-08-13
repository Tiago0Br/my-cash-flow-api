<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Auth;

use RuntimeException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Auth\AuthenticationInterface;
use Tiagolopes\MyCashFlowApi\Core\Domain\Entity\Session;
use Tiagolopes\MyCashFlowApi\Core\Domain\Repository\SessionRepository;

readonly class Authentication implements AuthenticationInterface
{
    public function __construct(private SessionRepository $sessionRepository)
    {
    }

    public function generateToken(int $userId): string
    {
        $token = bin2hex(random_bytes(length: 32));

        if (! $token) {
            throw new RuntimeException('Could not generate token.');
        }

        $session = Session::create($token, $userId);

        $this->sessionRepository->store($session);

        return $token;
    }

    public function verifyToken(string $token): void
    {
        // TODO: implement token verification
    }
}
