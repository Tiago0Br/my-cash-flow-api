<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database;

use Pdo\Pgsql;

final class Connection extends Pgsql
{
    private static ?self $instance = null;
    private function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $name = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASSWORD'];

        $dsn = "pgsql:host=$host;port=$port;dbname=$name;user=$user;password=$pass";

        parent::__construct($dsn);
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }
}
