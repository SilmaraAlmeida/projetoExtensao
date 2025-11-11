<?php

namespace App\Model;

use Core\Library\ModelMain;

class VagaCurriculumModel extends ModelMain
{
    protected $table = "vaga_curriculum";
    protected $primaryKey = ["vaga_id", "vaga_curriculum"];

    public $validationRules = [
        "dateCandidatura" => [
            "label" => 'Data da Candidatura',
            "rules" => 'required|date'
        ],
    ];

    /**
     * Verifica se já existe candidatura
     */
    public function jaCandidatou($vagaId, $curriculumId)
    {
        $resultado = $this->db
            ->table($this->table)
            ->where('vagaid', $vagaId)
            ->where('curriculumid', $curriculumId)
            ->first();

        return !empty($resultado);
    }
}
