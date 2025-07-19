<?php

ini_set('intl.default_locale', 'pt_BR');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Maceio');
header('Content-Type: application/json');

require_once __DIR__ . '/../bootstrap.php';
