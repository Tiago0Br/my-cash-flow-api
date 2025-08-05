<?php

if (count($argv) < 2) {
    echo "Error: Migration name is required. Please provide a name for the migration." . PHP_EOL;
    exit(1);
}

$name = $argv[1];

$timestamp = date('YmdHis');
$filename = "{$timestamp}_{$name}.sql";
$path = __DIR__ . '/../migrations/' . $filename;

file_put_contents(filename: $path, data: "-- Migration: $name\n-- Created at: " . date('Y-m-d H:i:s') . "\n\n");

echo "Created: $filename" . PHP_EOL;
