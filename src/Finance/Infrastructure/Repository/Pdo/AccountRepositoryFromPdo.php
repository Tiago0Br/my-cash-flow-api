<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Infrastructure\Repository\Pdo;

use PDO;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Entity\Account;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Exception\AccountNotFound;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\AccountRepositoryInterface;

readonly class AccountRepositoryFromPdo implements AccountRepositoryInterface
{
    public function __construct(private Connection $db)
    {
    }

    public function create(Account $account): void
    {
        $sql = <<<SQL
            INSERT INTO accounts (name, type, user_id, created_at) VALUES (:NAME, :TYPE, :USER_ID, :CREATED_AT)
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(param: 'NAME', value: $account->name);
        $stmt->bindValue(param: 'TYPE', value: $account->type);
        $stmt->bindValue(param: 'USER_ID', value: $account->userId, type: PDO::PARAM_INT);
        $stmt->bindValue(param: 'CREATED_AT', value: date('Y-m-d H:i:s'));
        $stmt->execute();
    }

    public function update(Account $account): void
    {
        $sql = <<<SQL
            UPDATE accounts
            SET name = :NAME,
                type = :TYPE,
                updated_at = :UPDATED_AT
            WHERE id = :ID
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(param: 'NAME', value: $account->name);
        $stmt->bindValue(param: 'TYPE', value: $account->type);
        $stmt->bindValue(param: 'UPDATED_AT', value: date('Y-m-d H:i:s'));
        $stmt->bindValue(param: 'ID', value: $account->id, type: PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getByIdAndUser(int $id, int $userId): Account
    {
        $sql = <<<SQL
            SELECT * FROM accounts WHERE id = :ID AND user_id = :USER_ID
            LIMIT 1
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(param: 'ID', value: $id, type: PDO::PARAM_INT);
        $stmt->bindValue(param: 'USER_ID', value: $userId, type: PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! is_array($data) || empty($data)) {
            throw AccountNotFound::byId($id);
        }

        return Account::createFromDatabaseReturn($data);
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

    public function delete(Account $account): void
    {
        $sql = <<<SQL
            DELETE FROM accounts WHERE id = :ID AND user_id = :USER_ID
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(param: 'ID', value: $account->id, type: PDO::PARAM_INT);
        $stmt->bindValue(param: 'USER_ID', value: $account->userId, type: PDO::PARAM_INT);
        $stmt->execute();
    }
}
