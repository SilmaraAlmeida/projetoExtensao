<?php

use Core\Library\Request;

/**
 * formTitulo
 *
 * @param string $titulo 
 * @param bool $btnNovo 
 * @return string
 */
function formTitulo($titulo, $btnNovo = false)
{
    $request = new Request();

    if ($btnNovo) {
        $cHtmlBtn = buttons("new");
    } else {
        $cHtmlBtn = buttons("voltarTitulo");
    }

    $cHtml = '  <div class="flex items-center justify-between bg-white mx-2 my-4 px-6 py-4 rounded-lg shadow-sm">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-800">' . $titulo . '<span class="">' . formSubTitulo($request->getAction()) . '</span></h3>
                    </div>
                    <div class="flex-shrink-0 ml-4">
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
                    class="inline-flex items-center px-6 py-2.5 bg-white border-2 border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>';

    if ($request->getAction() != "view") {

        // Define texto e ícone baseado na ação
        $btnText = 'Enviar';
        $btnIcon = 'fa-check';

        if ($request->getAction() == "insert") {
            $btnText = 'Cadastrar';
            $btnIcon = 'fa-plus';
        } elseif ($request->getAction() == "update") {
            $btnText = 'Atualizar';
            $btnIcon = 'fa-save';
        } elseif ($request->getAction() == "delete") {
            $btnText = 'Excluir';
            $btnIcon = 'fa-trash';
        }

        // Define cor do botão baseado na ação
        $btnColorClass = 'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800';

        if ($request->getAction() == "delete") {
            $btnColorClass = 'bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800';
        }

        $cHtml .= ' <button type="submit" 
                        class="inline-flex items-center px-6 py-2.5 ' . $btnColorClass . ' text-white text-sm font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl ml-3">
                        <i class="fas ' . $btnIcon . ' mr-2"></i>
                        ' . $btnText . '
                    </button>';
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
        $button = '<a href="' . baseUrl() . $request->getController() . '/form/insert/0" 
                      class="inline-flex items-center justify-center w-9 h-9 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200" 
                      title="Novo">
                      <i class="fas fa-plus text-sm"></i>
                   </a>';
    } elseif ($acao == "update") {
        $button = '<a href="' . baseUrl() . $request->getController() . '/form/update/' . $id . '" 
                      class="inline-flex items-center justify-center w-9 h-9 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200" 
                      title="Editar">
                      <i class="fas fa-edit text-sm"></i>
                   </a>';
    } elseif ($acao == "delete") {
        $button = '<a href="' . baseUrl() . $request->getController() . '/form/delete/' . $id . '" 
                      class="inline-flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200" 
                      title="Excluir">
                      <i class="fas fa-trash text-sm"></i>
                   </a>';
    } elseif ($acao == "view") {
        $button = '<a href="' . baseUrl() . $request->getController() . '/form/view/' . $id . '" 
                      class="inline-flex items-center justify-center w-9 h-9 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200" 
                      title="Visualizar">
                      <i class="fas fa-eye text-sm"></i>
                   </a>';
    } elseif ($acao == "voltarTitulo") {
        $button = '<a href="' . baseUrl() . $request->getController() . '" 
                      class="inline-flex items-center justify-center w-9 h-9 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200" 
                      title="Voltar">
                      <i class="fas fa-arrow-left text-sm"></i>
                   </a>';
    }

    return $button;
}
