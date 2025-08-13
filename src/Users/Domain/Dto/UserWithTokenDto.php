<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Dto;

use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\User;

readonly class UserWithTokenDto
{
    private function __construct(
        public User $user,
        public string $token
    ) {
    }

    public static function create(User $user, string $token): self
    {
        return new self(
            user: $user,
            token: $token
        );
    }
}
