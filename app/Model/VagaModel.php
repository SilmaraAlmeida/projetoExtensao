<?php

namespace App\Model;

use Core\Library\ModelMain;

class VagaModel extends ModelMain
{
    protected $table = "vaga";
    protected $primaryKey = "vaga_id";

    public $validationRules = [
        "descricao" => [
            "label" => 'Descrição da Vaga',
            "rules" => 'required|min:5|max:60'
        ],
        "sobreaVaga" => [
            "label" => 'Sobre a Vaga',
            "rules" => 'required|min:10'
        ],
        "modalidade" => [
            "label" => 'Modalidade de Trabalho',
            "rules" => 'required|int|in:1,2'
        ],
        "vinculo" => [
            "label" => 'Tipo de Vínculo',
            "rules" => 'required|int|in:1,2'
        ],
        "dtInicio" => [
            "label" => 'Data de Início',
            "rules" => 'required|date'
        ],
        "dtFim" => [
            "label" => 'Data de Fim',
            "rules" => 'required|date'
        ],
        "estabelecimento_id" => [
            "label" => 'Estabelecimento',
            "rules" => 'required|int'
        ],
        "statusVaga" => [
            "label" => 'Status da Vaga',
            "rules" => 'required|int|in:1,11,91,99'
        ]
    ];

    /**
     * Buscar vaga pelo ID
     *
     * @param int $id ID da vaga
     * @return array|null
     */
    public function getVagaById(int $id)
    {
        if ($id <= 0) {
            return null;
        }

        return $this->db
            ->table($this->table)
            ->where($this->primaryKey, $id) // usa vaga_id
            ->first();
    }
}
