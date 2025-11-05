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
                        language: {
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
                            "sSearch":          "Pesquisar:",
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
                        },
                        dom: "<\"flex flex-wrap items-center justify-between mb-4 mt-4 px-6\"fl>rtip",
                        order: [[0, "asc"]],
                        initComplete: function() {
                            // Labels
                            $(".dataTables_filter label").attr("class", "text-sm text-gray-700 font-medium flex items-center whitespace-nowrap");
                            $(".dataTables_length label").attr("class", "text-sm text-gray-700 font-medium flex items-center whitespace-nowrap");
                            
                            // Input search (MAIOR)
                            $(".dataTables_filter input").attr("class", "ml-2 px-4 py-2 bg-white border-2 border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all w-64");
                            
                            // Select
                            $(".dataTables_length select").attr("class", "mx-2 px-3 py-2 bg-white border-2 border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all");
                            
                            // Info e Paginação
                            $(".dataTables_info").attr("class", "dataTables_info text-sm text-gray-600 pt-4 px-6 inline-block");
                            $(".dataTables_paginate").attr("class", "dataTables_paginate pt-4 px-6 text-right");
                            
                            // Mensagem "Nenhum registro"
                            $(".dataTables_empty").attr("class", "dataTables_empty text-center py-8 text-gray-500 text-sm");
                            
                            // Cabeçalhos ordenáveis - adiciona display inline para manter ícones na mesma linha
                            $("#' . $idTable . ' thead th").addClass("cursor-pointer select-none whitespace-nowrap");
                        },
                        drawCallback: function() {
                            // Reaplica classes nos botões de paginação
                            $(".dataTables_paginate .paginate_button").each(function() {
                                var $btn = $(this);
                                var baseClasses = "inline-block mx-1 px-4 py-2 border rounded-lg text-sm font-medium transition-all duration-200";
                                
                                if ($btn.hasClass("current")) {
                                    $btn.attr("class", "paginate_button current " + baseClasses + " bg-blue-600 text-white border-blue-600 hover:bg-blue-700");
                                } else if ($btn.hasClass("disabled")) {
                                    $btn.attr("class", "paginate_button disabled " + baseClasses + " bg-white text-gray-400 border-gray-300 opacity-50 cursor-not-allowed");
                                } else {
                                    $btn.attr("class", "paginate_button " + baseClasses + " bg-white text-gray-700 border-gray-300 hover:bg-gray-50 hover:border-gray-400 cursor-pointer");
                                }
                            });
                            
                            // Mensagem "Nenhum registro"
                            $(".dataTables_empty").attr("class", "dataTables_empty text-center py-8 text-gray-500 text-sm");
                            
                            // Remove TODOS os ícones existentes primeiro
                            $("#' . $idTable . ' thead th i").remove();
                            
                            // Adiciona ícones de ordenação - usando inline para não quebrar linha
                            $("#' . $idTable . ' thead th").each(function() {
                                var $th = $(this);
                                var icon = "";
                                
                                if ($th.hasClass("sorting")) {
                                    icon = "<i class=\"fas fa-sort text-gray-400 text-xs ml-1 inline-block\"></i>";
                                } else if ($th.hasClass("sorting_asc")) {
                                    icon = "<i class=\"fas fa-sort-up text-blue-600 text-xs ml-1 inline-block\"></i>";
                                } else if ($th.hasClass("sorting_desc")) {
                                    icon = "<i class=\"fas fa-sort-down text-blue-600 text-xs ml-1 inline-block\"></i>";
                                }
                                
                                if (icon !== "") {
                                    $th.append(icon);
                                }
                            });
                        }
                    });
                });
            </script>';
    }
}

