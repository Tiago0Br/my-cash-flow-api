<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableTransactions extends AbstractMigration
{
    public function up(): void
    {
        if (!$this->hasTable('transactions')) {
            $table = $this->table('transactions');
            $table->addColumn('title', 'string', ['limit' => 80, 'null' => false])
                  ->addColumn('description', 'text', ['null' => true])
                  ->addColumn('amount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
                  ->addColumn('type', 'string', ['limit' => 20, 'null' => false])
                  ->addColumn('account_id', 'integer', ['null' => false])
                  ->addColumn('category_id', 'integer', ['null' => false])
                  ->addColumn('transaction_date', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                  ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                  ->addColumn('updated_at', 'timestamp', ['null' => true])
                  ->addForeignKey('account_id', 'accounts', 'id', ['delete' => 'CASCADE'])
                  ->addForeignKey('category_id', 'categories', 'id', ['delete' => 'CASCADE'])
                  ->create();
        }
    }

    public function down(): void
    {
        $this->table('transactions')->drop()->save();
    }
}
