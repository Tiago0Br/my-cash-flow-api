<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InsertCategories extends AbstractMigration
{
    public function up(): void
    {
        $count = $this->fetchRow('SELECT COUNT(*) as total FROM categories');
        if ((int)$count['total'] === 0) {
            $categories = [
                ['title' => 'Alimentação', 'type' => 'expense'],
                ['title' => 'Transporte', 'type' => 'expense'],
                ['title' => 'Moradia', 'type' => 'expense'],
                ['title' => 'Educação', 'type' => 'expense'],
                ['title' => 'Lazer', 'type' => 'expense'],
                ['title' => 'Vestuário', 'type' => 'expense'],
                ['title' => 'Outros', 'type' => 'expense'],
                ['title' => 'Salário', 'type' => 'income'],
                ['title' => 'Investimentos', 'type' => 'income'],
                ['title' => 'Freelance', 'type' => 'income'],
                ['title' => 'Outros', 'type' => 'income']
            ];
            $this->table('categories')->insert($categories)->saveData();
        }
    }

    public function down(): void
    {
        $this->execute("DELETE FROM categories");
    }
}
