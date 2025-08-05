<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure;

use Exception;

class Container
{
    private static ?self $instance = null;
    private array $items           = [];

    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function add(string $item, callable $resolver): void
    {
        $this->items[$item] = $resolver;
    }

    public function get(string $item): mixed
    {
        if (isset($this->items[$item])) {
            return $this->items[$item]($this);
        }

        throw new Exception("Dependency not found: $item");
    }
}
