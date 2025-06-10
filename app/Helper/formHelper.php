<?php

use Core\Library\Request;
use Core\Library\Session;

function formTitulo($titulo, $btnNovo = false)
{
    $request = new Request();

    if ($btnNovo) {
        $cHtmlBtn = '<a href="' . baseUrl() . $request->getController() . '/form/insert/0" title="Novo" class="btn btn-outline-info text-white">Novo</a>';
    } else {
        $cHtmlBtn = '<a href="' . baseUrl() . $request->getController() . '" title="Voltar" class="btn btn-outline-info text-white">Voltar</a>';
    }

    $cHtml = '  <div class="row bg-primary text-white m-2">
                    <div class="col-10 p-2">
                        <h3>' . $titulo . formSubTitulo($request->getAction()) . '</h3>
                    </div>
                    <div class="col-2 text-end p-2">
                        ' . $cHtmlBtn . '
                    </div>
                </div>';

    var_dump(Session::getDestroy("msgSucess"));
    var_dump(Session::getDestroy("msgError"));

    return $cHtml;
}

/**
 * formSubTitulo
 *
 * @param string $action 
 * @return string
 */
function formSubTitulo($action)
{
    if ($action == "insert") {
        return " - Novo";
    } elseif ($action == "update") {
        return " - Alteração";
    } elseif ($action == "delete") {        
        return " - Exclusão";
    } elseif ($action == "view") {
        return " - Visualização";
    } else {
        return "";
    }
}

/**
 * formButton
 *
 * @return string
 */
function formButton()
{
    $request = new Request();

    $cHtml = '<a href="' . baseUrl() . $request->getController() . '" 
                    title="Voltar" 
                    class="btn btn-secondary">
                        Voltar
                </a>';

    if ($request->getAction() != "view") {
        $cHtml .= '&nbsp;<button type="submit" class="btn btn-primary">Enviar</button>';
    }
    
    return $cHtml;
}
