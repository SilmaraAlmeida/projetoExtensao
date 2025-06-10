<?php 
namespace App\Model;

use Core\Library\ModelMain;


class TermoDeUsoAceiteModel extends ModelMain
{
    protected $table = 'telefone';

    public $validationRules = [
        "dataHoraAceite"  => [
            "label" => 'Estabelecimento',
            "rules" => 'required|datetime'
        ],
        "termodeuso_id"  => [
            "label" => 'Termo de Uso',
            "rules" => 'required|int'
        ],
        "usuario_id"  => [
            "label" => 'Usuario',
            "rules" => 'required|int'
        ]
    ];
}