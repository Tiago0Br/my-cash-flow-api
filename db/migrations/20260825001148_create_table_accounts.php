<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableAccounts extends AbstractMigration
{
    public function up(): void
    {
        if (!$this->hasTable('accounts')) {
            $table = $this->table('accounts');
            $table->addColumn('name', 'string', ['limit' => 80, 'null' => false])
                  ->addColumn('type', 'string', ['limit' => 80, 'null' => false])
                  ->addColumn('user_id', 'integer', ['null' => false])
                  ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                  ->addColumn('updated_at', 'timestamp', ['null' => true])
                  ->addForeignKey('user_id', 'users', 'id')
                  ->create();
        }
    }

    public function down(): void
    {
        $this->table('accounts')->drop()->save();
    }
}
