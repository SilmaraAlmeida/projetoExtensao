<?php
// CurriculumExperienciaModel.php
namespace App\Model;

use Core\Library\ModelMain;

class CurriculumExperienciaModel extends ModelMain
{
    protected $table = "curriculum_experiencia";
    protected $primaryKey = "curriculum_experiencia_id";

    public $validationRules = [
        "estabelecimento" => [
            "label" => "Empresa",
            "rules" => "required|max:60"
        ],
        "cargoDescricao" => [
            "label" => "Cargo",
            "rules" => "required|max:50"
        ],
        "inicioMes" => [
            "label" => "Mês de Início",
            "rules" => "required|numeric|min:1|max:12"
        ],
        "inicioAno" => [
            "label" => "Ano de Início",
            "rules" => "required|numeric"
        ]
    ];
}
