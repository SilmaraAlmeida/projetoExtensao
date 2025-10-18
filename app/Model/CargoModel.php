<?php

namespace App\Model;

use Core\Library\ModelMain;

class CargoModel extends ModelMain
{
    protected $table = "cargo";
    protected $primaryKey = "cargo_id";

    public $validationRules = [
        "descricao" => [
            "label" => 'Descrição do Cargo',
            "rules" => 'required|min:3|max:50'
        ]
    ];

    /**
     * Buscar cargo pelo ID
     *
     * @param int $id ID do cargo
     * @return array|null
     */
    public function getCargoById(int $id)
    {
        if ($id <= 0) {
            return null;
        }

        return $this->db
            ->table($this->table)
            ->where($this->primaryKey, $id) // usa cargo_id
            ->first();
    }
}
