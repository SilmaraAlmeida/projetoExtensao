<?php

namespace Core\Library;

class Erros
{
    /**
     * controllerNotFound
     *
     * @return void
     */
    public static function controllerNotFound()
    {
        echo "Controller não localizado na estrutura do projeto.";
    }

    /**
     * methodNotFound
     *
     * @return void
     */
    public static function methodNotFound()
    {
        echo "Método não localizado no Controller.";
    }
}