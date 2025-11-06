<?php
// CurriculumQualificacaoModel.php
namespace App\Model;

use Core\Library\ModelMain;

class CurriculumQualificacaoModel extends ModelMain
{
    protected $table = "curriculum_qualificacao";
    protected $primaryKey = "curriculum_qualificacao_id";

    public $validationRules = [
        "descricao" => [
            "label" => "Nome do Curso",
            "rules" => "required|max:60"
        ],
        "estabelecimento" => [
            "label" => "Instituição",
            "rules" => "required|max:60"
        ],
        "mes" => [
            "label" => "Mês de Conclusão",
            "rules" => "required|numeric|min:1|max:12"
        ],
        "ano" => [
            "label" => "Ano de Conclusão",
            "rules" => "required|numeric"
        ],
        "cargaHoraria" => [
            "label" => "Carga Horária",
            "rules" => "required|numeric|min:1"
        ]
    ];
}
