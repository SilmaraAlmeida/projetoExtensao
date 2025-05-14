<?php

use Core\Library\Ambiente;
use Core\Library\Routes;

require_once ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
require_once ".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "Constants.php";
require_once ".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "Routes.php";

$ambiente = new Ambiente();
$routes = new Routes();

$ambiente->load();

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$route = Routes::getControllerMethod($requestUri);

if ($route) {
    $controllerName = 'App\\Controller\\' . $route['controller'];
    $methodName = $route['method'];

    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            $controller->$methodName();
        } else {
            echo "Método $methodName não encontrado no controller $controllerName.";
        }
    } else {
        echo "Controller $controllerName não encontrado.";
    }
} else {
    echo "Rota não encontrada!";
}


?>