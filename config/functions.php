<?php

function sendResponse(
    array|string|null $data = null,
    int $code = 200,
    string $contentType = 'application/json'
): void {
    header('Content-Type: ' . $contentType);
    http_response_code($code);

    if ($data !== null) {
        echo is_array($data) ? json_encode($data) : $data;
    }
}

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
