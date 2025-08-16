<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Http;

use Tiagolopes\MyCashFlowApi\Core\Domain\Exception\UnauthorizedException;
use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\User;

class Request
{
    private ?User $user;
    private function __construct(
        public readonly array $headers,
        public readonly array $params,
        public readonly array $query,
        public readonly array $body
    ) {
        $this->user = null;
    }

    public static function create(array $headers, array $params, array $query, array $body): self
    {
        return new self(
            headers: $headers,
            params: $params,
            query: $query,
            body: $body
        );
    }

    public function setLoggedUser(User $user): void
    {
        $this->user = $user;
    }

    public function getLoggedUser(): User
    {
        if ($this->user instanceof User) {
            return $this->user;
        }

        throw UnauthorizedException::create();
    }
}
