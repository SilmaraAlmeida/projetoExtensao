<?php 
namespace App\Model;

use Core\Library\ModelMain;


class TelefoneModel extends ModelMain
{
    protected $table = 'telefone';

    public $validationRules = [
        "estabelecimento_id"  => [
            "label" => 'Estabelecimento',
            "rules" => 'required|int'
        ],
        "usuario_id"  => [
            "label" => 'Usuario',
            "rules" => 'required|int'
        ],
        "numero"  => [
            "label" => 'Numero de Telefone',
            "rules" => 'required|max:11|char'
        ],
        "tipo"  => [
            "label" => 'Genero',
            "rules" => 'required|min:1|max:1'
        ]
    ];
}