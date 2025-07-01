<?php 

namespace App\Model;

use Core\Library\ModelMain;

class CadastroModel extends ModelMain
{
    protected $table = 'pessoa_fisica';
    protected $primaryKey = 'pessoa_fisica_id';

    public $validationRules = [
        "nome" => [
            "label" => 'Nome',
            "rules" => 'required|min:3'
        ],
        "cpf" => [
            "label" => 'CPF',
            "rules" => 'exact:11'
        ]
    ];

    /**
     * Verificar se email já existe na tabela usuario
     *
     * @param string $email
     * @return bool
     */
    public function verificarEmailExistente($email)
    {
        $resultado = $this->db->table('usuario')->where('login', $email)->first();
        return !empty($resultado);
    }

    /**
     * Verificar se CPF já existe na tabela pessoa_fisica
     *
     * @param string $cpf
     * @return bool
     */
    public function verificarCpfExistente($cpf)
    {
        $resultado = $this->db->table('pessoa_fisica')->where('cpf', $cpf)->first();
        return !empty($resultado);
    }

    /**
     * Inserir pessoa física
     *
     * @param array $dados
     * @return int
     */
    public function inserirPessoaFisica($dados)
    {
        $this->db->table('pessoa_fisica');
        return $this->db->insert($dados);
    }

    /**
     * Inserir usuário
     *
     * @param array $dados
     * @return int
     */
    public function inserirUsuario($dados)
    {
        $this->db->table('usuario');
        return $this->db->insert($dados);
    }

    /**
     * Inserir telefone
     *
     * @param array $dados
     * @return int
     */
    public function inserirTelefone($dados)
    {
        $this->db->table('telefone');
        return $this->db->insert($dados);
    }

    /**
     * Buscar termo de uso ativo
     *
     * @return array
     */
    public function buscarTermoUsoAtivo()
    {
        return $this->db->table('termodeuso')
            ->where('statusRegistro', 1)
            ->where('rascunho', 2)
            ->orderBy('termodeuso_id', 'DESC')
            ->first();
    }

    /**
     * Inserir aceite de termo de uso
     *
     * @param array $dados
     * @return int
     */
    public function inserirAceiteTermoUso($dados)
    {
        $this->db->table('termodeusoaceite');
        return $this->db->insert($dados);
    }

    /**
     * Buscar usuário por email com dados da pessoa física
     *
     * @param string $email
     * @return array
     */
    public function buscarUsuarioPorEmail($email)
    {
        return $this->db->table('usuario')
            ->select('usuario.*, pessoa_fisica.nome, pessoa_fisica.cpf')
            ->join('pessoa_fisica', 'pessoa_fisica.pessoa_fisica_id = usuario.pessoa_fisica_id')
            ->where('usuario.login', $email)
            ->first();
    }

    /**
     * Buscar telefones do usuário
     *
     * @param int $usuarioId
     * @return array
     */
    public function buscarTelefonesUsuario($usuarioId)
    {
        return $this->db->table('telefone')
            ->where('usuario_id', $usuarioId)
            ->findAll();
    }

    /**
     * Buscar pessoa física por ID
     *
     * @param int $pessoaFisicaId
     * @return array
     */
    public function getPessoaFisicaById($pessoaFisicaId)
    {
        return $this->db->table('pessoa_fisica')
            ->where('pessoa_fisica_id', $pessoaFisicaId)
            ->first();
    }

    /**
     * Listar usuários com dados completos
     *
     * @return array
     */
    public function listaUsuariosCompletos()
    {
        return $this->db->table('usuario')
            ->select('usuario.*, pessoa_fisica.nome, pessoa_fisica.cpf')
            ->join('pessoa_fisica', 'pessoa_fisica.pessoa_fisica_id = usuario.pessoa_fisica_id')
            ->orderBy('usuario.usuario_id', 'DESC')
            ->findAll();
    }
}
