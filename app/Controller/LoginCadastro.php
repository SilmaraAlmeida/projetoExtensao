<?php
namespace App\Controller;

use Core\Library\ControllerMain;

class LoginCadastro extends ControllerMain
{
    public function index()
    {
        return view('comuns/loginRegistro/login');
    }
}
