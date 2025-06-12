<?php

// Controller Padrão
defined('DEFAULT_CONTROLLER') || define("DEFAULT_CONTROLLER", 'Home');

// Método padrão
defined('DEFAULT_METODO') || define("DEFAULT_METODO", 'index');

// Controller autorizados a executar sem login
defined('CONTROLLER_AUTH') || define('CONTROLLER_AUTH', [
    "Home",
    "Login"
]);

// Definir o time_zone_default
defined("DEFAULT_TIME_ZONE") || define("DEFAULT_TIME_ZONE", "America/Sao_Paulo");

// Tamanho máximo para upload de arquivos (5 mega bytes)
defined('FILE_MAXSIZE') || define('FILE_MAXSIZE', 5);

// Arquivos aceitos em Uploads
defined('FILE_ALLOWEDTYPES') || define('FILE_ALLOWEDTYPES', [
    'image/jpg', 
    'image/jpeg', 
    'image/png', 
    'image/gif', 
    'image/bmp',
    'image/webp',
    'image/svg+xml',
    'application/pdf',
    'application/msword',                                                           // DOC (Word 97-2003)
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',      // DOCX 
    'application/vnd.ms-excel',                                                     // XLS (Excel 97-2003)
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',            // XLSX (Excel 2007+)
    'application/vnd.ms-powerpoint',                                                // PPT (PowerPoint 97-2003)
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',    // PPTX 
    'text/plain',                                                                   // TXT
    'text/csv',
    'application/zip',
    'application/x-rar-compressed',
    'audio/mpeg',
    'audio/wav',
    'audio/ogg',
    'audio/aac',
    'video/mp4',
    'video/webm',
    'video/ogg',
    'video/x-msvideo',
    'application/json',
    'application/xml'
]);
