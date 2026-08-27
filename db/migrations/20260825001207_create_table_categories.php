<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableCategories extends AbstractMigration
{
    public function up(): void
    {
        if (!$this->hasTable('categories')) {
            $table = $this->table('categories');
            $table->addColumn('title', 'string', ['limit' => 80, 'null' => false])
                  ->addColumn('type', 'string', ['limit' => 20, 'null' => false])
                  ->create();
        }
    }

    public function down(): void
    {
        $this->table('categories')->drop()->save();
    }
}
