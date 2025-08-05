<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Entity;

use Tiagolopes\MyCashFlowApi\Users\Domain\Dto\SaveUserDto;

class User
{
    private const string DEFAULT_PASSWORD_ALGO = PASSWORD_ARGON2ID;

    private function __construct(
        private(set) ?int $id = null,
        private(set) string $name,
        private(set) string $email,
        private(set) string $password
    ) {
    }

    public static function create(SaveUserDto $saveUserDto): self
    {
        return new self(
            id: null,
            name: $saveUserDto->name,
            email: $saveUserDto->email,
            password: password_hash($saveUserDto->password, self::DEFAULT_PASSWORD_ALGO)
        );
    }

    public static function createFromDatabaseReturn(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
            password: $data['password']
        );
    }

    public function update(SaveUserDto $saveUserDto): void
    {
        $this->name     = $saveUserDto->name;
        $this->email    = $saveUserDto->email;
        $this->password = password_hash($saveUserDto->password, self::DEFAULT_PASSWORD_ALGO);
    }

    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
        ];
    }
}
