<?php

function sendResponse(int $code = 200, ?array $data = null): void
{
    http_response_code($code);
    if ($data !== null) {
        echo json_encode($data);
    }
}
