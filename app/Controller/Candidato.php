<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;

class Candidato extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return Redirect::page('/sistema');
    }

    public function candidaturas($action, $id)
    {
        return $this->loadView("sistema/candidato/candidatoPerfil");
    }

    public function perfil($action, $id)
    {
        return $this->loadView("sistema/candidato/candidatoPerfil");
    }

    public function curriculo($action, $id)
    {
        return $this->loadView("sistema/candidato/candidatoPerfil");
    }

}