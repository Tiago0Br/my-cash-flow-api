<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableUsers extends AbstractMigration
{
    public function up(): void
    {
        if (!$this->hasTable('users')) {
            $table = $this->table('users');
            $table->addColumn('name', 'string', ['limit' => 255, 'null' => false])
                  ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
                  ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
                  ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                  ->addColumn('updated_at', 'timestamp', ['null' => true])
                  ->create();
        }
    }

    public function down(): void
    {
        $this->table('users')->drop()->save();
    }
}
