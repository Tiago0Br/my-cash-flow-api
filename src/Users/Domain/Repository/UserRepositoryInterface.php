<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Repository;

use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function create(User $user): void;

    public function findByEmail(string $email): ?User;

    public function getById(int $id): User;
}
