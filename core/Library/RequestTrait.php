<?php

// core\library\RequestTrait.php

namespace Core\Library;

trait RequestTrait
{
    static public function getRotaParametros()
    {
        $aParametros = explode("/", ltrim(filter_var(rtrim($_SERVER['REQUEST_URI'], "/"), FILTER_SANITIZE_URL), "/"));
        $outrosPar      = [];

        // outros parametros
        if (count($aParametros) > 4) {
            $outrosPar = array_slice($aParametros, 4);
        }

        return [
            'controller' => isset($aParametros[0]) && !empty($aParametros[0]) ? ucfirst($aParametros[0]) : DEFAULT_CONTROLLER,
            'method'     => isset($aParametros[1]) ? $aParametros[1] : DEFAULT_METODO,
            'action'     => isset($aParametros[2]) ? $aParametros[2] : "",
            'id'         => isset($aParametros[3]) ? $aParametros[3] : 0,
            'outrosPar'  => $outrosPar,
            'get'        => $_GET,
            'post'       => $_POST
        ];
    }
}