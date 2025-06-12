<?php

namespace Core\Library;

class Response
{
    /**
     * json
     *
     * @param array $response 
     * @return void
     */
    public static function json(array $response)
    {
        // Define o código de status HTTP
        http_response_code($response['status']);

        header('Content-Type: application/json; charset=UTF-8');

        echo json_encode(
            $response,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        exit;   // encerra o script
    }
}