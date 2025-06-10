<?php 
namespace App\Model;

use Core\Library\ModelMain;


class TermoDeUsoModelModel extends ModelMain
{
    protected $table = 'telefone';

    public $validationRules = [
        "textoLongo"  => [
            "label" => 'Estabelecimento',
            "rules" => 'required|longtext'
        ],
        "statusRegistro"  => [
            "label" => 'Status do Registro',
            "rules" => 'required|int'
        ],
        "rascunho"  => [
            "label" => 'Termo de Uso Rascunho',
            "rules" => 'required|int'
        ]
    ];
}