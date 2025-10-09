<?php 
namespace App\Model;

use Core\Library\ModelMain;


class TermoDeUsoModel extends ModelMain
{
    protected $table = 'termodeuso';

    public $validationRules = [
        "textoTermo"  => [
            "label" => 'Texto do Termo de Uso',
            "rules" => 'required|longtext'
        ],
        "statusRegistro"  => [
            "label" => 'Status do Registro',
            "rules" => 'required|int'
        ],
        "rascunho"  => [
            "label" => 'Termo de Uso Rascunho',
            "rules" => 'required|int'
        ],
        "usuario_id"  => [
            "label" => 'Usuario',
            "rules" => 'required|int'
        ]
    ];
    public function getTermoVigente()
    {
        return $this->db
                    ->where('statusRegistro', 1)
                    ->where('rascunho', 2)
                    ->orderBy('termodeuso_id', 'DESC')
                    ->first();
    }
}