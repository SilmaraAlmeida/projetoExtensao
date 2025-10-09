<?php 
namespace App\Model;

use Core\Library\ModelMain;
use Core\Library\Validator;

class TermoDeUsoAceiteModel extends ModelMain
{
    protected $table = 'termodeusoaceite';

    public $validationRules = [
        "dataHoraAceite"  => [
            "label" => 'Data de Aceite do Termo de uso',
            "rules" => 'required|datetime'
        ],
        "termodeuso_id"  => [
            "label" => 'Termo de Uso',
            "rules" => 'required|int'
        ],
        "usuario_id"  => [
            "label" => 'Usuario',
            "rules" => 'required|int'
        ]
    ];

    /**
     * insert - Override para tabela sem AUTO_INCREMENT
     *
     * @param array $dados
     * @return bool
     */
    public function insert($dados)
    {
        if (Validator::make($dados, $this->validationRules)) {
            return false;
        }
        
        try {
            $this->db->table($this->table);
            $this->db->insert($dados);
            
            // Tabela sem AUTO_INCREMENT - se não lançou exception = sucesso
            return true;
            
        } catch (\Exception $e) {
            return false;
        }
    }
}