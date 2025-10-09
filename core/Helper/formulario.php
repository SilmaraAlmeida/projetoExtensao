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
     * Exibe mensagem de alerta similar ao Bootstrap, mas usando TailwindCSS.
     *
     * @return string
     */
    function exibeAlerta()
    {
        // Pega a mensagem da sessão e destrói
        $msgSucesso = Core\Library\Session::getDestroy('msgSucesso');
        $msgError   = Core\Library\Session::getDestroy('msgError');
        $msgAlerta  = Core\Library\Session::getDestroy('msgAlerta');

        $mensagem   = '';
        $classAlert = '';

        // Define cores e estilos Tailwind
        if ($msgSucesso != "") {
            $mensagem   = $msgSucesso;
            $classAlert = 'bg-green-100 border border-green-400 text-green-700';
        } elseif ($msgError != "") {
            $mensagem   = $msgError;
            $classAlert = 'bg-red-100 border border-red-400 text-red-700';
        } elseif ($msgAlerta != "") {
            $mensagem   = $msgAlerta;
            $classAlert = 'bg-yellow-100 border border-yellow-400 text-yellow-700';
        }

        // Se não houver mensagem, retorna vazio
        if ($mensagem == "") return "";

        // Retorna HTML do alerta
        return '
        <div class="m-2 p-4 rounded ' . $classAlert . ' flex justify-between items-center" role="alert">
            <span>' . $mensagem . '</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-xl font-bold leading-none">&times;</button>
        </div>';
    }
}


if (! function_exists('datatables')) {
    /**
     * datatables
     *
     * @param string $idTable 
     * @return string
     */
    function datatables($idTable)
    {
        return '
            <script src="' . baseUrl() . 'assets/DataTables/datatables.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#' . $idTable . '").DataTable({
                        language:   {
                                        "sEmptyTable":      "Nenhum registro encontrado",
                                        "sInfo":            "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                                        "sInfoEmpty":       "Mostrando 0 até 0 de 0 registros",
                                        "sInfoFiltered":    "(Filtrados de _MAX_ registros)",
                                        "sInfoPostFix":     "",
                                        "sInfoThousands":   ".",
                                        "sLengthMenu":      "_MENU_ resultados por página",
                                        "sLoadingRecords":  "Carregando...",
                                        "sProcessing":      "Processando...",
                                        "sZeroRecords":     "Nenhum registro encontrado",
                                        "sSearch":          "Pesquisar",
                                        "oPaginate": {
                                            "sNext":        "Próximo",
                                            "sPrevious":    "Anterior",
                                            "sFirst":       "Primeiro",
                                            "sLast":        "Último"
                                        },
                                        "oAria": {
                                            "sSortAscending":   ": Ordenar colunas de forma ascendente",
                                            "sSortDescending":  ": Ordenar colunas de forma descendente"
                                        }
                                    }
                    });
                });
            </script>';
    }
}
