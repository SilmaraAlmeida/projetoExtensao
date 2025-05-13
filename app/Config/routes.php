<?php 
    namespace Core\Library;

    class Routes
    {
        public static function getRoutes() {
            return [
                '/' => ['controller' => 'Home', 'method' => 'index'],
                '/form_login' => ['controller' => 'LoginCadastro', 'method' => 'index'],
                '/cadastrar' => ['controller' => 'LoginCadastro', 'method' => 'registrar'],
                '/login' => ['controller' => 'LoginCadastro', 'method' => 'login']
            ];
        }

        public static function getControllerMethod($uri) {
            $routes = self::getRoutes();

            if (array_key_exists($uri, $routes)) {
                return $routes[$uri];
            }

            return null;
        }
    }
?>