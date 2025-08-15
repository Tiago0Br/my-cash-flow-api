<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Log;

use DateTime;

class Logger
{
    public static function log(string $filename, string $message): void
    {
        $dir = __DIR__ . '/../../../../logs';
        if (! file_exists($dir)) {
            mkdir(directory: $dir, recursive: true);
        }

        $logFile = $dir . '/' . $filename;
        if (! file_exists($logFile)) {
            touch($logFile);
            chmod(filename: $logFile, permissions: 0666);
        }

        $date = new DateTime()->format('Y-m-d H:i:s');

        $logMessage = "[$date] $message" . PHP_EOL;

        file_put_contents(filename: $logFile, data: $logMessage, flags: FILE_APPEND);
    }
}
