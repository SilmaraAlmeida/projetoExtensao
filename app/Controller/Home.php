<?php
// app\controller\Home.php

namespace App\Controller;

use Core\Library\ControllerMain;

class Home extends ControllerMain
{
    public function index()
    {
        $this->loadView("home");
    }

    public function sobre($action = null)
    {
        echo "Página sobre nós. AÇÃO: {$action}";
    }

    public function detalhes($action = null, $id = null, ...$params)
    {
        echo "Detalhes: <br />";
        echo "<br />Ação: " . $action;
        echo "<br />ID: " . $id;
        echo "<br />PARÂMETROS: " . implode(", ", $params);
    }
    public function busca()
    {
        echo "<pre>";
        var_dump($_GET); // para depuração
        echo "</pre>";

        if (!empty($_GET['busca'])) {
            echo "Você pesquisou: " . htmlspecialchars($_GET['busca']);
        } else {
            echo "Nenhum termo informado.";
        }
    }
}
