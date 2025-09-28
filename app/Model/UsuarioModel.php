<?php

namespace App\Model;

use Core\Library\ModelMain;

class UsuarioModel extends ModelMain
{
    protected $table = "usuario";
    protected $primaryKey = "usuario_id";

    public $validationRules = [
        "pessoa_fisica_id" => [
            "label" => 'Pessoa Física',
            "rules" => 'required|int'
        ],
        "login" => [
            "label" => 'Login/Email',
            "rules" => 'required|email|min:5|max:50'
        ],
        "tipo" => [
            "label" => 'Tipo de Usuário',
            "rules" => 'required|in:A,G,CN'
        ]
    ];

    /**
     * getUserLogin
     *
     * @param string $login 
     * @return array
     */
    public function getUserLogin($login)
    {
        return $this->db
            ->table('usuario')
            ->select('usuario.*, pessoa_fisica.nome')
            ->join('pessoa_fisica', 'usuario.pessoa_fisica_id = pessoa_fisica.pessoa_fisica_id', 'INNER')
            ->where('usuario.login', $login)
            ->first();
    }

    /**
     * getUserId
     *
     * @param int $id ID do usuário
     * @return array
     */
    public function getUserId($id)
    {
        return $this->db
            ->table('usuario')
            ->select('usuario.*, pessoa_fisica.nome')
            ->join('pessoa_fisica', 'usuario.pessoa_fisica_id = pessoa_fisica.pessoa_fisica_id', 'INNER')
            ->where('usuario.usuario_id', $id)
            ->first();
    }

    /**
     * getUsuariosSelect
     *
     * @return array
     */
    public function getUsuariosSelect()
    {
        return $this->db
            ->table('pessoa_fisica')
            ->select('pessoa_fisica.pessoa_fisica_id, pessoa_fisica.nome')
            ->orderBy('pessoa_fisica.nome', 'ASC')
            ->findAll();
    }

    /**
     * listaUsuario
     *
     * @param string $orderby Campo para ordenação
     * @param string $direction Direção da ordenação (ASC/DESC)
     * @return array
     */
    public function listaUsuario($orderby = "usuario_id", $direction = "ASC")
    {
        return $this->db
            ->table('usuario')
            ->select('usuario.*, pessoa_fisica.nome')
            ->join('pessoa_fisica', 'usuario.pessoa_fisica_id = pessoa_fisica.pessoa_fisica_id', 'INNER')
            ->orderBy($orderby, $direction)
            ->findAll();
    }
}
