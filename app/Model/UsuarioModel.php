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

    /**
     * verificaDependencias
     * 
     * @param int $usuario_id
     * @return array
     */
    public function verificaDependencias($usuario_id)
    {
        $dependencias = [];

        // Verifica telefones
        $telefones = $this->db->table('telefone')->where('usuario_id', $usuario_id)->findAll();
        if (!empty($telefones)) {
            $dependencias[] = count($telefones) . " telefone(s) cadastrado(s)";
        }

        // Verifica termos de uso
        $termos = $this->db->table('termodeuso')->where('usuario_id', $usuario_id)->findAll();
        if (!empty($termos)) {
            $dependencias[] = count($termos) . " termo(s) de uso criado(s)";
        }

        // Verifica aceites de termos
        $aceites = $this->db->table('termodeusoaceite')->where('usuario_id', $usuario_id)->findAll();
        if (!empty($aceites)) {
            $dependencias[] = count($aceites) . " aceite(s) de termo(s)";
        }

        // Verifica recuperação de senha
        $recuperacoes = $this->db->table('usuariorecuperasenha')->where('usuario_id', $usuario_id)->findAll();
        if (!empty($recuperacoes)) {
            $dependencias[] = count($recuperacoes) . " solicitação(ões) de recuperação de senha";
        }

        return $dependencias;
    }

    /**
     * deletarComDependencias
     * 
     * @param int $usuario_id
     * @return array
     */
    public function deletarComDependencias($usuario_id)
    {
        $dependencias = $this->verificaDependencias($usuario_id);

        if (!empty($dependencias)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Não é possível excluir este usuário. Existem registros vinculados: ' . implode(', ', $dependencias)
            ];
        }

        // Se não há dependências, pode deletar
        if ($this->delete(['usuario_id' => $usuario_id])) {
            return [
                'sucesso' => true,
                'mensagem' => 'Usuário excluído com sucesso.'
            ];
        } else {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir usuário.'
            ];
        }
    }
}
