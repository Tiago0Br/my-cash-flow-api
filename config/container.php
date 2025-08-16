<?php

/** @var string[] $modules */
$modules = require_once __DIR__ . '/modules.php';

foreach ($modules as $module) {
    if (file_exists(__DIR__ . "/modules/$module/container.php")) {
        require_once __DIR__ . "/modules/$module/container.php";
    }
}
