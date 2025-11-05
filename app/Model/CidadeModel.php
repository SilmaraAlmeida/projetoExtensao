<?php

namespace App\Model;

use Core\Library\ModelMain;

class CidadeModel extends ModelMain
{
    
    protected $table = "cidade";
    protected $primaryKey = "cidade_id";

    public $validationRules = [
        "cidade" => [
            "label" => 'Cidade',
            "rules" => 'required|min:3|max:50'
        ],
        "cidade" => [
            "label" => 'Cidade',
            "rules" => 'required|min:3|max:50'
        ]
    ];
}
