<?php

namespace App\Model;

use Core\Library\ModelMain;

class UsuarioModel extends ModelMain
{
    protected $table = "usuario";

    public $validationRules = [
        "pessoa_fisica_id"  => [
            "label" => 'Pessoa Fisica',
            "rules" => 'required|min:3|max:60'
        ],
        "login"  => [
            "label" => 'Email',
            "rules" => 'required|min:5|max:150'
        ],
        "tipo"  => [
            "label" => 'Tipo de Usuario',
            "rules" => 'required|int'
        ]
    ];

    /**
     * getUserEmail
     *
     * @param string $login 
     * @return array
     */
    public function getUserEmail($login)
    {
        return $this->db
            ->join("pessoa_fisica", "usuario.pessoa_fisica_id", "INNER")
            ->where("usuario.login", $login)
            ->select("usuario.*, pessoa_fisica.nome")
            ->first();
    }

    /**
     * getById
     *
     * @param int $id
     * @return array|null
     */
    public function getUserId($usuario_id)
    {
        return $this->db
            ->join("pessoa_fisica", "usuario.pessoa_fisica_id", "INNER")
            ->where("usuario.usuario_id", $usuario_id)
            ->select("usuario.*, pessoa_fisica.nome, pessoa_fisica.cpf")
            ->first();
    }
}
