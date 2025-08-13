<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Auth;

interface AuthenticationInterface
{
    public function generateToken(int $userId): string;

    public function verifyToken(string $token): void;
}
