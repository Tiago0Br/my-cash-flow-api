<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Dto;

readonly class SaveUserDto
{
    private function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {
    }

    public static function fromArray(array $params): self
    {
        return new self(
            name: $params['name'],
            email: $params['email'],
            password: $params['password']
        );
    }
}
