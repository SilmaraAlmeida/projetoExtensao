<?php

/**
 * serve_image
 *
 * @param string $baseDir 
 * @param string $filePath 
 * @return void
 */
function serve_image(string $baseDir, string $filePath): void
{
    $baseDir = realpath($baseDir);
    $fullPath = realpath($baseDir . DIRECTORY_SEPARATOR . $filePath);

    if (!$fullPath || !str_starts_with($fullPath, $baseDir) || !file_exists($fullPath)) {
        http_response_code(404);
        echo "Imagem não encontrada.";
        return;
    }
    
    $mime = mime_content_type($fullPath);
    header("Content-Type: $mime");
    readfile($fullPath);
    exit;
}

//require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "helper" . DIRECTORY_SEPARATOR . "utilits.php";

//serve_image('..' . DIRECTORY_SEPARATOR . 'uploads', $_GET['file'] ?? '');
serve_image(__DIR__ .  DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads', $_GET['file'] ?? '');