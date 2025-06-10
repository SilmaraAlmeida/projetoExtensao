<?php 
namespace App\Model;

use Core\Library\ModelMain;


class PessoaFisicaModel extends ModelMain
{
    protected $table = 'pessoa_fisica';

    public $validationRules = [
        "nome"  => [
            "label" => 'Nome',
            "rules" => 'required|min:4|max:150'
        ],
        "cpf"  => [
            "label" => 'CPF',
            "rules" => 'required|max:11|char'
        ],
        "visitante_id"  => [
            "label" => 'Visitante',
            "rules" => 'required|int'
        ]
    ];
}