<?php

namespace App\Controller;

use Core\Library\ControllerMain;

class Sistema extends ControllerMain
{
    public function index()
    {
        $this->loadView("sistema/homeSistema");
    }

}