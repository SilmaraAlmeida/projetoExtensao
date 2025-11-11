<?php

/**
 * UsuarioRecuperaSenhaModel
 * 
 * Model para gerenciar tokens de recuperação de senha
 */

namespace App\Model;

use Core\Library\ModelMain;

class UsuarioRecuperaSenhaModel extends ModelMain
{
    protected $table = "usuariorecuperasenha";
    protected $primaryKey = "id";

    public $validationRules = [
        "usuario_id" => [
            "label" => 'ID do Usuário',
            "rules" => 'required|integer'
        ],
        "chave" => [
            "label" => 'Chave de Recuperação',
            "rules" => 'required|min_length[40]|max_length[255]'
        ],
        "created_at" => [
            "label" => 'Data de Criação',
            "rules" => 'required|valid_date'
        ]
    ];

    /**
     * getRecuperaSenhaChave - Recuperar os dados do token especificado
     *
     * @param string $chave 
     * @return array|null
     */
    public function getRecuperaSenhaChave($chave)
    {
        return $this->db->table($this->table)
            ->where([
                "statusRegistro" => 1,
                "chave" => $chave
            ])
            ->first();
    }

    /**
     * desativaChave - Desativa token específico após uso
     *
     * @param int $id 
     * @return bool
     */
    public function desativaChave($id)
    {
        $rs = $this->db->table($this->table)
            ->where(["id" => $id])
            ->update([
                "statusRegistro" => 2,
                "updated_at" => date("Y-m-d H:i:s")
            ]);

        return $rs > 0;
    }

    /**
     * desativaChaveAntigas - Desativa todas as chaves antigas de um usuário
     *
     * @param int $usuario_id 
     * @return bool
     */
    public function desativaChaveAntigas($usuario_id)
    {
        $rs = $this->db->table($this->table)
            ->where([
                "usuario_id" => $usuario_id,
                "statusRegistro" => 1
            ])
            ->update([
                "statusRegistro" => 2,
                "updated_at" => date("Y-m-d H:i:s")
            ]);

        return $rs > 0;
    }

    /**
     * limpaTokensExpirados - Remove tokens com mais de 24 horas
     *
     * @return bool
     */
    public function limpaTokensExpirados()
    {
        $dataLimite = date('Y-m-d H:i:s', strtotime('-24 hours'));

        $rs = $this->db->table($this->table)
            ->where("created_at <", $dataLimite)
            ->where("statusRegistro", 1)
            ->update([
                "statusRegistro" => 3,
                "updated_at" => date("Y-m-d H:i:s")
            ]);

        return $rs > 0;
    }

    /**
     * validaToken - Verifica se token é válido e não expirou
     *
     * @param string $chave 
     * @return array|null
     */
    public function validaToken($chave)
    {
        $dataLimite = date('Y-m-d H:i:s', strtotime('-24 hours'));

        return $this->db->table($this->table)
            ->where([
                "chave" => $chave,
                "statusRegistro" => 1
            ])
            ->where("created_at >=", $dataLimite)
            ->first();
    }
}
