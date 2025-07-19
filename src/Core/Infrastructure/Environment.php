<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure;

use RuntimeException;

class Environment
{
    public static function initialize(string $path, string $filename = '.env'): void
    {
        $envFile = realpath(path: $path . DIRECTORY_SEPARATOR . $filename);

        if (! $envFile || ! file_exists($envFile)) {
            throw new RuntimeException('Could not load .env file');
        }

        if ($file = fopen(filename: $envFile, mode: 'r')) {
            while (($line = fgets($file)) !== false) {
                [$key, $value] = preg_split(pattern: '/(\s?)=(\s?)/', subject: trim($line));
                $value         = preg_replace(pattern: '/(\s?)"/', replacement: '', subject: $value);
                $_ENV[$key]    = $value;
            }
        }
    }
}
