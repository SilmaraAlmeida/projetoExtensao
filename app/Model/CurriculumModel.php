<?php
// CurriculumModel.php
namespace App\Model;

use Core\Library\ModelMain;

class CurriculumModel extends ModelMain
{
    protected $table = "curriculum";
    protected $primaryKey = "curriculum_id";

    public $validationRules = [
        "email" => [
            "label" => "E-mail",
            "rules" => "required|email|max:120"
        ],
        "celular" => [
            "label" => "Celular",
            "rules" => "required|min:10|max:11"
        ],
        "dataNascimento" => [
            "label" => "Data de Nascimento",
            "rules" => "required"
        ],
        "sexo" => [
            "label" => "Sexo",
            "rules" => "required|in:M,F"
        ],
        "cep" => [
            "label" => "CEP",
            "rules" => "required|min:8|max:8"
        ],
        "logradouro" => [
            "label" => "Logradouro",
            "rules" => "required|max:60"
        ],
        "numero" => [
            "label" => "Número",
            "rules" => "required|max:10"
        ],
        "bairro" => [
            "label" => "Bairro",
            "rules" => "required|max:50"
        ]
    ];
}
