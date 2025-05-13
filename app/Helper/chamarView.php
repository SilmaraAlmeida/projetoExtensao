<?php
if (!function_exists('view')) {
    function view($path) {
        require __DIR__ . '/../View/' . $path . '.php';
    }
}
