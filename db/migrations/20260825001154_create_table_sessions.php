<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSessions extends AbstractMigration
{
    public function up(): void
    {
        if (!$this->hasTable('sessions')) {
            $table = $this->table('sessions', ['id' => false, 'primary_key' => 'id']);
            $table->addColumn('id', 'uuid')
                  ->addColumn('token', 'string', ['limit' => 255, 'null' => false])
                  ->addColumn('user_id', 'integer', ['null' => false])
                  ->addColumn('expires_at', 'timestamp', ['null' => false])
                  ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE'])
                  ->create();
        }
    }

    public function down(): void
    {
        $this->table('sessions')->drop()->save();
    }
}
