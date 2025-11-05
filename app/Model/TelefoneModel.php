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
            "label" => 'Tipo do telefone',
            "rules" => 'required|min:1|max:1'
        ]
    ];

    /**
     * getTelefonesPorUsuario - Busca telefones de um usuário
     *
     * @param int $usuarioId
     * @return array
     */
    public function getTelefonesPorUsuario($usuarioId)
    {
        return $this->db
            ->table($this->table)
            ->where('usuario_id', $usuarioId)
            ->findAll();
    }

    /**
     * getTelefonesPorEstabelecimento - Busca telefones de um estabelecimento
     *
     * @param int $estabelecimentoId
     * @return array
     */
    public function getTelefonesPorEstabelecimento($estabelecimentoId)
    {
        return $this->db
            ->table($this->table)
            ->where('estabelecimento_id', $estabelecimentoId)
            ->findAll();
    }

    /**
     * deleteTelefonesPorUsuario - Remove todos os telefones de um usuário
     *
     * @param int $usuarioId
     * @return int Número de registros deletados
     */
    public function deleteTelefonesPorUsuario($usuarioId)
    {
        return $this->db
            ->table($this->table)
            ->where('usuario_id', $usuarioId)
            ->delete();
    }

    /**
     * deleteTelefonesPorEstabelecimento - Remove todos os telefones de um estabelecimento
     *
     * @param int $estabelecimentoId
     * @return int Número de registros deletados
     */
    public function deleteTelefonesPorEstabelecimento($estabelecimentoId)
    {
        return $this->db
            ->table($this->table)
            ->where('estabelecimento_id', $estabelecimentoId)
            ->delete();
    }
}
