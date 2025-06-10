<?php

use Core\Library\Session;

if (! function_exists('setValor')) {

    /**
     * setValor
     *
     * @param string $campo 
     * @param mixed $default 
     * @return mixed
     */
    function setValor($campo, $default = "")
    {
        if (isset($_POST[$campo])) {
            return $_POST[$campo];
        } else {
            return $default;
        }
    }

}

if (! function_exists('setMsgFilderError')) {
    /**
     * setMsgFilderError
     *
     * @param string $campo 
     * @return string
     */
    function setMsgFilderError($campo)
    {
        $cRet   = '';

        if (isset($_POST['formErrors'][$campo])) {
            $cRet .= '<div class="mt-2 text-danger">';
                $cRet .= $_POST['formErrors'][$campo];
            $cRet .= '</div>';
        }

        return $cRet;
    }
}

if (! function_exists('exibeAlerta')) {
    /**
     * exibeAlerta
     *
     * @return string
     */
    function exibeAlerta()
    {
        $msgSucesso = Session::getDestroy('msgSucesso');
        $msgError   = Session::getDestroy('msgError');
        $msgAlerta  = Session::getDestroy('msgAlerta');
        $mensagem   = '';
        $classAlert = '';

        if ($msgSucesso != "") {
            $mensagem   = $msgSucesso;
            $classAlert = 'success';
        } elseif ($msgError != "") {
            $mensagem   = $msgError;
            $classAlert = 'danger';
        } elseif ($msgAlerta != "") {
            $mensagem   = $msgAlerta;
            $classAlert = 'warning';
        }

        if ($mensagem == "") {
            return "";
        } else {
            return  '<div class="m-2 alert alert-' . $classAlert . ' alert-dismissible fade show" role="alert">
                        ' . $mensagem . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
    }
}