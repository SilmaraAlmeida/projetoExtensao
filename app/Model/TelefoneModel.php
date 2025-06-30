<?php

namespace App\Model;

use Core\Library\ModelMain;


class TelefoneModel extends ModelMain
{
    protected $table = 'telefone';
    protected $primaryKey = "telefone_id";
    public $validationRules = [
        "numero"  => [
            "label" => 'Numero de Telefone',
            "rules" => 'required|min:10|max:11'
        ],
        "tipo"  => [
            "label" => 'Genero',
            "rules" => 'required|min:1|max:1'
        ]
    ];
    public function getUserById($usuarioId)
    {
        return $this->db->where("usuario_id", $usuarioId)->findAll();
    }
    
    /**
     * getTelefoneById - busca telefone específico pelo ID
     *
     * @param int $telefoneId
     * @return array
     */
    public function getTelefoneById($telefoneId)
    {
        return $this->db->where("telefone_id", $telefoneId)->first();
    }

    /**
     * listaTelefone - com joins para mostrar nomes
     *
     * @return array
     */
    public function listaTelefone()
    {
        return $this->db
            ->table('telefone')
            ->select('telefone.*, estabelecimento.nome as estabelecimento_nome, pessoa_fisica.nome as usuario_nome')
            ->join('estabelecimento', 'telefone.estabelecimento_id = estabelecimento.estabelecimento_id', 'LEFT')
            ->join('usuario', 'telefone.usuario_id = usuario.usuario_id', 'LEFT')
            ->join('pessoa_fisica', 'usuario.pessoa_fisica_id = pessoa_fisica.pessoa_fisica_id', 'LEFT')
            ->orderBy('telefone_id', 'ASC')
            ->findAll();
    }
}
