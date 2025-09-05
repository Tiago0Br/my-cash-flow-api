<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Finance\Infrastructure\Repository\Pdo;

use PDO;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Entity\Transaction;
use Tiagolopes\MyCashFlowApi\Finance\Domain\Repository\TransactionRepositoryInterface;

readonly class TransactionRepositoryFromPdo implements TransactionRepositoryInterface
{
    public function __construct(private Connection $db)
    {
    }

    public function create(Transaction $transaction): void
    {
        $sql = <<<SQL
            INSERT INTO transactions (title, description, amount, type, transaction_date, category_id, account_id)
            VALUES (:TITLE, :DESCRIPTION, :AMOUNT, :TYPE, :TRANSACTION_DATE, :CATEGORY_ID, :ACCOUNT_ID)
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(param: ':TITLE', value:  $transaction->title);
        $stmt->bindValue(param: ':DESCRIPTION', value:  $transaction->description);
        $stmt->bindValue(param: ':AMOUNT', value:  $transaction->amount);
        $stmt->bindValue(param: ':TYPE', value:  $transaction->type);
        $stmt->bindValue(param: ':TRANSACTION_DATE', value:  $transaction->transactionDate);
        $stmt->bindValue(param: ':CATEGORY_ID', value:  $transaction->categoryId, type: PDO::PARAM_INT);
        $stmt->bindValue(param: ':ACCOUNT_ID', value:  $transaction->accountId, type: PDO::PARAM_INT);
        $stmt->execute();
    }
}
