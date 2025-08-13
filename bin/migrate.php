<?php

use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Environment\Environment;

require __DIR__ . '/../vendor/autoload.php';

Environment::initialize(__DIR__ . '/../');

$db = Connection::getInstance();
$db->exec("CREATE TABLE IF NOT EXISTS migrations (id SERIAL PRIMARY KEY, name VARCHAR(255))");

$executedMigrations = $db
    ->query("SELECT name FROM migrations")
    ->fetchAll(PDO::FETCH_COLUMN);

$migrationDir = __DIR__ . '/../migrations';
$files = scandir($migrationDir);

if (! $files) {
    echo 'No migrations found' . PHP_EOL;
    return;
}

foreach ($files as $file) {
    if (str_ends_with(haystack: $file, needle: '.sql') && ! in_array(needle: $file, haystack: $executedMigrations)) {
        $sql     = file_get_contents($migrationDir . '/' . $file);
        $success = $db->exec($sql);

        if ($success === false) {
            echo "Error: $file" . PHP_EOL;
            exit(1);
        }

        $stmt = $db->prepare("INSERT INTO migrations (name) VALUES (:NAME)");
        $stmt->execute(['NAME' => $file]);

        echo "Executed: $file" . PHP_EOL;
    }
}
