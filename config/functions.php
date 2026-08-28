<?php

function getBaseUrl(): string
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $port = $_SERVER['SERVER_PORT'];

    if ($protocol === 'https' && $port != 443) {
        $host .= ':' . $port;
    }

    return $protocol . '://' . $host;
}
