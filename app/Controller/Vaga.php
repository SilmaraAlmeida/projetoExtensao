<?php
// app\controller\Home.php

namespace App\Controller;

use Core\Library\ControllerMain;

class Vaga extends ControllerMain
{
   public function index()
   {
      $this->loadView("vagas");
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
         $dados = ['busca' => $_GET['busca']];
         $this->loadView("vagas", $dados);
      } else {
         echo "Nenhum termo informado.";
      }

   }
}
