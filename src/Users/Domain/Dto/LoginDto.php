<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Dto;

readonly class LoginDto
{
    private function __construct(
        public string $email,
        public string $password
    ) {
    }

    public static function fromArray(array $params): self
    {
        return new self(
            email: $params['email'],
            password: $params['password']
        );
    }
}
