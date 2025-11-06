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
}
