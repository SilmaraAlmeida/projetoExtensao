<?php

namespace App\Model;

use Core\Library\ModelMain;

class PessoaFisicaModel extends ModelMain
{
    protected $table = 'pessoa_fisica';
    protected $primaryKey = "pessoa_fisica_id";

    public $validationRules = [
        "nome"  => [
            "label" => 'Nome',
            "rules" => 'required|min:4|max:150'
        ],
        "cpf"  => [
            "label" => 'CPF',
            "rules" => 'required|max:11|char'
        ]
    ];
    /**
     * Busca um usuário pelo ID
     *
     * @param int $id ID do usuário a ser buscado
     * @return object|null Retorna o registro do usuário ou null se não encontrado
     */
    public function getUserId($id)
    {
        return $this->db
            ->where($this->primaryKey, $id)
            ->first();
    }

    public function verificaDuplicidadeCPF(string $cpf): bool
    {
        $rs = $this->db
            ->table('pessoa_fisica')
            ->where('cpf', $cpf)
            ->first();

        $cpfExiste = !empty($rs);

        return $cpfExiste;
    }
}
