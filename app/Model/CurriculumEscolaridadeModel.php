<?php
// CurriculumEscolaridadeModel.php
namespace App\Model;

use Core\Library\ModelMain;

class CurriculumEscolaridadeModel extends ModelMain
{
    protected $table = "curriculum_escolaridade";
    protected $primaryKey = "curriculum_escolaridade_id";

    public $validationRules = [
        "descricao" => [
            "label" => "Descrição",
            "rules" => "required|max:60"
        ],
        "instituicao" => [
            "label" => "Instituição",
            "rules" => "required|max:60"
        ],
        "inicioMes" => [
            "label" => "Mês de Início",
            "rules" => "required|numeric|min:1|max:12"
        ],
        "inicioAno" => [
            "label" => "Ano de Início",
            "rules" => "required|numeric"
        ],
        "fimMes" => [
            "label" => "Mês de Conclusão",
            "rules" => "required|numeric|min:1|max:12"
        ],
        "fimAno" => [
            "label" => "Ano de Conclusão",
            "rules" => "required|numeric"
        ]
    ];
}
