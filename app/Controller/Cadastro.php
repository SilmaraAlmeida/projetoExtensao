<?php

namespace App\Controller;

use Core\Library\ControllerMain;

class Cadastro extends ControllerMain
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
        return $this->loadView("/login/cadastro");
    }

    public function form($action, $id)
    {
        return $this->loadView("admin/formUf");
    }
}