<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Infrastructure\Pdo;

use PDO;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\DbConnection;
use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\User;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\UserRepositoryInterface;

readonly class UserRepositoryFromPdo implements UserRepositoryInterface
{
    public function __construct(private DbConnection $db)
    {
    }

    public function create(User $user): void
    {
        $sql = <<<SQL
            INSERT INTO users (name, email, password)
            VALUES (:NAME, :EMAIL, :PASSWORD)
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('NAME', $user->name);
        $stmt->bindValue('EMAIL', $user->email);
        $stmt->bindValue('PASSWORD', $user->password);
        $stmt->execute();
    }

    public function findUserByEmail(string $email): ?User
    {
        $sql = <<<SQL
            SELECT * FROM users WHERE email = :EMAIL
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('EMAIL', $email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $data) {
            return null;
        }

        return User::createFromDatabaseReturn($data);
    }
}
