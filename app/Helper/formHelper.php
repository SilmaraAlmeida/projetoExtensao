<?php

use Core\Library\Request;

function formTitulo($titulo, $btnNovo = false)
{
    $request = new Request();

    if ($btnNovo) {
        $cHtmlBtn = buttons("new");
    } else {
        $cHtmlBtn = buttons("voltarTitulo");
    }

    $cHtml = '  <div class="row bg-primary text-white m-2">
                    <div class="col-10 p-2">
                        <h3>' . $titulo . formSubTitulo($request->getAction()) . '</h3>
                    </div>
                    <div class="col-2 text-end p-2">
                        ' . $cHtmlBtn . '
                    </div>
                </div>';

    $cHtml .= exibeAlerta();
    
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

/**
 * buttons
 *
 * @param string $acao 
 * @param int $id 
 * @return string
 */
function buttons($acao, $id = 0) 
{
    $request = new Request();
    $button = "";

    if ($acao == "new") {
        $button = '<a href="' . baseUrl()  . $request->getController() . '/form/new/0" class="btn btn-outline-info text-white btn-sm" title="Novo"><i class="fa-solid fa-pen"></i></a>';
    } elseif ($acao == "update") {
        $button = '<a href="' . baseUrl()  . $request->getController() . '/form/update/' . $id . '" class="btn btn-primary btn-sm" title="Alteração"><i class="fa-solid fa-pen-to-square"></i></a>';
    } elseif ($acao == "delete") {
        $button = '<a href="' . baseUrl()  . $request->getController() . '/form/delete/' . $id . '" class="btn btn-primary btn-sm" title="Exclusão"><i class="fa-solid fa-trash-can"></i></i></a>';
    } elseif ($acao == "view") {
        $button = '<a href="' . baseUrl()  . $request->getController() . '/form/view/' . $id . '" class="btn btn-primary btn-sm" title="Visualização"><i class="fa-solid fa-eye"></i></a>';
    } elseif ($acao == "voltarTitulo") {
        $button = '<a href="' . baseUrl()  . $request->getController() . '" class="btn btn-outline-info text-white btn-sm" title="Voltar"><i class="fa-solid fa-rotate-left"></i></a>';
    }

    return $button;    
}


