<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Infrastructure\Pdo;

use PDO;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\Account;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\AccountRepositoryInterface;

readonly class AccountRepositoryFromPdo implements AccountRepositoryInterface
{
    public function __construct(private Connection $db)
    {
    }

    public function create(Account $account): void
    {
        $sql = <<<SQL
            INSERT INTO accounts (name, type, user_id) VALUES (:NAME, :TYPE, :USER_ID)
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(param: 'NAME', value: $account->name);
        $stmt->bindValue(param: 'TYPE', value: $account->type);
        $stmt->bindValue(param: 'USER_ID', value: $account->userId, type: PDO::PARAM_INT);
        $stmt->execute();
    }

    public function findAllByUserId(int $userId): array
    {
        $sql = <<<SQL
            SELECT * FROM accounts WHERE user_id = :USER_ID
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(param: 'USER_ID', value: $userId, type: PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn (array $account) => Account::createFromDatabaseReturn($account), $data);
    }
}
