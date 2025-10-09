<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class TermoDeUsoAceite extends ControllerMain
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->auxiliarConstruct();
        $this->loadHelper(['formHelper', 'tabela']);
        $this->validaNivelAcesso("CN");                     // Todos os usuários podem aceitar termos
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return $this->loadView("sistema/listaTermoDeUsoAceite", $this->model->listaTermoDeUsoAceite());
    }
}
