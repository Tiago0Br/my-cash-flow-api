<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Infrastructure\Pdo;

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Users\Domain\Entity\Category;
use Tiagolopes\MyCashFlowApi\Users\Domain\Repository\CategoryRepositoryInterface;

readonly class CategoryRepositoryFromPdo implements CategoryRepositoryInterface
{
    public function __construct(private Connection $db)
    {
    }

    public function getAll(): array
    {
        $sql = 'SELECT id, title, type FROM categories';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll();

        return array_map(fn (array $data) => Category::createFromDatabaseReturn($data), $categories);
    }

    public function create(Category $category): void
    {
        $sql = 'INSERT INTO categories (title, type) VALUES (:TITLE, :TYPE)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':TITLE', $category->title);
        $stmt->bindValue(':TYPE', $category->type);
        $stmt->execute();
    }
}
