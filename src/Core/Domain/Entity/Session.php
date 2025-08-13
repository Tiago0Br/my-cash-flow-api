<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Entity;

use Ramsey\Uuid\Uuid;

readonly class Session
{
    private function __construct(
        public string $id,
        public string $token,
        public int $userId,
        public string $expiresAt
    ) {
    }

    public static function create(string $token, int $userId): self
    {
        return new self(
            id: Uuid::uuid4()->toString(),
            token: $token,
            userId: $userId,
            expiresAt: date(format: 'Y-m-d H:i:s', timestamp: time() + $_ENV['TOKEN_EXPIRATION_TIME'])
        );
    }
}
