<?php

namespace App\Model;

use Core\Library\ModelMain;

class UsuarioModel extends ModelMain
{
    protected $table = "usuario";
    protected $primaryKey = "usuario_id";

    public $validationRules = [
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
        // Busca o usuário base pelo login
        $usuario = $this->db
            ->table('usuario')
            ->where('usuario.login', $login)
            ->first();

        if (!$usuario) {
            return [];
        }

        // Se for empresa (A)
        if ($usuario['tipo'] === 'A') {
            $dados = $this->db
                ->table('usuario')
                ->select('usuario.*, estabelecimento.nome as nome')
                ->join('estabelecimento', 'usuario.estabelecimento_id = estabelecimento.estabelecimento_id', 'LEFT')
                ->where('usuario.login', $login)
                ->first();
        }
        // Se for gestor ou contribuinte normativo
        else {
            $dados = $this->db
                ->table('usuario')
                ->select('usuario.*, pessoa_fisica.nome as nome')
                ->join('pessoa_fisica', 'usuario.pessoa_fisica_id = pessoa_fisica.pessoa_fisica_id', 'LEFT')
                ->where('usuario.login', $login)
                ->first();
        }

        return $dados ?? [];
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

    public function verificaDuplicidadeEmail(string $email): bool
    {
        $rs = $this->db
            ->table('usuario')
            ->where('login', $email)
            ->first();

        $emailExiste = !empty($rs);

        return $emailExiste;
    }

    /**
     * getDadosPerfil
     *
     * @param int $usuarioId ID do usuário logado
     * @return array Dados completos para exibição/edição do perfil
     */
    public function getDadosPerfil($usuarioId)
    {
        // Busca o tipo de usuário primeiro
        $usuario = $this->db
            ->table('usuario')
            ->select('tipo')
            ->where('usuario_id', $usuarioId)
            ->first();

        if (!$usuario) {
            return [];
        }

        // Se for Empresa (Anunciante)
        if ($usuario['tipo'] === 'A') {
            $dados = $this->db
                ->table('usuario')
                ->select('usuario.usuario_id, usuario.login, usuario.tipo, 
                      estabelecimento.estabelecimento_id, estabelecimento.nome, 
                      estabelecimento.endereco, estabelecimento.latitude, 
                      estabelecimento.longitude, estabelecimento.email')
                ->join('estabelecimento', 'usuario.estabelecimento_id = estabelecimento.estabelecimento_id', 'INNER')
                ->where('usuario.usuario_id', $usuarioId)
                ->first();

            // Busca telefones do estabelecimento
            if ($dados) {
                $dados['telefones'] = $this->db
                    ->table('telefone')
                    ->where('estabelecimento_id', $dados['estabelecimento_id'])
                    ->findAll();
            }
        }
        // Se for Pessoa Física (CN ou G)
        else {
            $dados = $this->db
                ->table('usuario')
                ->select('usuario.usuario_id, usuario.login, usuario.tipo,
                    pessoa_fisica.pessoa_fisica_id, pessoa_fisica.nome, pessoa_fisica.cpf,
                    curriculum.curriculum_id, curriculum.logradouro, curriculum.numero, 
                    curriculum.complemento, curriculum.bairro, curriculum.cep, 
                    curriculum.celular, curriculum.dataNascimento, curriculum.sexo, 
                    curriculum.foto, curriculum.email, curriculum.apresentacaoPessoal,
                    cidade.cidade_id, cidade.cidade, cidade.uf')
                ->join('pessoa_fisica', 'usuario.pessoa_fisica_id = pessoa_fisica.pessoa_fisica_id', 'INNER')
                ->join('curriculum', 'pessoa_fisica.pessoa_fisica_id = curriculum.pessoa_fisica_id', 'LEFT')
                ->join('cidade', 'curriculum.cidade_id = cidade.cidade_id', 'LEFT')
                ->where('usuario.usuario_id', $usuarioId)
                ->first();

            // Busca telefones do usuário
            if ($dados) {
                $dados['telefones'] = $this->db
                    ->table('telefone')
                    ->where('usuario_id', $usuarioId)
                    ->findAll();
            }
        }

        return $dados ?? [];
    }
    /**
     * deletarComDependencias
     * Exclui usuário e TODOS os dados relacionados em cascata
     *
     * @param int $usuarioId
     * @return array ['sucesso' => bool, 'mensagem' => string]
     */
    public function deletarComDependencias($usuarioId)
    {
        // Busca usuário
        $usuario = $this->db
            ->table('usuario')
            ->where('usuario_id', $usuarioId)
            ->first();

        if (!$usuario) {
            return [
                'sucesso' => false,
                'mensagem' => 'Usuário não encontrado.'
            ];
        }

        // ============================================
        // GESTOR: Verifica se é o último gestor
        // ============================================
        if ($usuario['tipo'] === 'G') {
            $gestores = $this->db
                ->table('usuario')
                ->where('tipo', 'G')
                ->findAll();

            if (count($gestores) <= 1) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Não é possível excluir o único gestor do sistema.'
                ];
            }
        }

        // ============================================
        // Contador de registros excluídos
        // ============================================
        $totalExcluidos = 0;
        $detalhes = [];

        // ============================================
        // 1. EXCLUI DADOS DE CANDIDATO (se for CN)
        // ============================================
        if ($usuario['tipo'] === 'CN' && !empty($usuario['pessoa_fisica_id'])) {

            // Busca currículo
            $curriculum = $this->db
                ->table('curriculum')
                ->where('pessoa_fisica_id', $usuario['pessoa_fisica_id'])
                ->first();

            if ($curriculum) {
                $curriculumId = $curriculum['curriculum_id'];

                // 1.1. Exclui candidaturas (vaga_curriculum)
                $deletedCandidaturas = $this->db
                    ->table('vaga_curriculum')
                    ->where('curriculum_id', $curriculumId)
                    ->delete();

                if ($deletedCandidaturas > 0) {
                    $detalhes[] = "$deletedCandidaturas candidatura(s)";
                    $totalExcluidos += $deletedCandidaturas;
                }

                // 1.2. Exclui qualificações
                $deletedQualificacoes = $this->db
                    ->table('curriculum_qualificacao')
                    ->where('curriculum_id', $curriculumId)
                    ->delete();

                if ($deletedQualificacoes > 0) {
                    $detalhes[] = "$deletedQualificacoes qualificação(ões)";
                    $totalExcluidos += $deletedQualificacoes;
                }

                // 1.3. Exclui experiências
                $deletedExperiencias = $this->db
                    ->table('curriculum_experiencia')
                    ->where('curriculum_id', $curriculumId)
                    ->delete();

                if ($deletedExperiencias > 0) {
                    $detalhes[] = "$deletedExperiencias experiência(s)";
                    $totalExcluidos += $deletedExperiencias;
                }

                // 1.4. Exclui escolaridade
                $deletedEscolaridades = $this->db
                    ->table('curriculum_escolaridade')
                    ->where('curriculum_curriculum_id', $curriculumId)
                    ->delete();

                if ($deletedEscolaridades > 0) {
                    $detalhes[] = "$deletedEscolaridades escolaridade(s)";
                    $totalExcluidos += $deletedEscolaridades;
                }

                // 1.5. Exclui currículo principal
                $deletedCurriculum = $this->db
                    ->table('curriculum')
                    ->where('curriculum_id', $curriculumId)
                    ->delete();

                if ($deletedCurriculum > 0) {
                    $detalhes[] = "1 currículo";
                    $totalExcluidos += $deletedCurriculum;
                }
            }
        }

        // ============================================
        // 2. EXCLUI DADOS DE ANUNCIANTE (se for A)
        // ============================================
        if ($usuario['tipo'] === 'A' && !empty($usuario['estabelecimento_id'])) {

            // 2.1. Busca vagas do estabelecimento
            $vagas = $this->db
                ->table('vaga')
                ->where('estabelecimento_id', $usuario['estabelecimento_id'])
                ->findAll();

            foreach ($vagas as $vaga) {
                // 2.1.1. Exclui candidaturas da vaga
                $deletedCandidaturasVaga = $this->db
                    ->table('vaga_curriculum')
                    ->where('vaga_id', $vaga['vaga_id'])
                    ->delete();

                if ($deletedCandidaturasVaga > 0) {
                    $totalExcluidos += $deletedCandidaturasVaga;
                }

                // 2.1.2. Exclui a vaga
                $deletedVaga = $this->db
                    ->table('vaga')
                    ->where('vaga_id', $vaga['vaga_id'])
                    ->delete();

                if ($deletedVaga > 0) {
                    $totalExcluidos += $deletedVaga;
                }
            }

            if (count($vagas) > 0) {
                $detalhes[] = count($vagas) . " vaga(s) e suas candidaturas";
            }

            // 2.2. Exclui telefones do estabelecimento
            $deletedTelefones = $this->db
                ->table('telefone')
                ->where('estabelecimento_id', $usuario['estabelecimento_id'])
                ->delete();

            if ($deletedTelefones > 0) {
                $detalhes[] = "$deletedTelefones telefone(s)";
                $totalExcluidos += $deletedTelefones;
            }

            // 2.3. Exclui categorias do estabelecimento
            $deletedCategorias = $this->db
                ->table('categoria_estabelecimento')
                ->where('estabelecimento_id', $usuario['estabelecimento_id'])
                ->delete();

            if ($deletedCategorias > 0) {
                $detalhes[] = "$deletedCategorias categoria(s)";
                $totalExcluidos += $deletedCategorias;
            }

            // 2.4. Exclui cliques de telefone
            $deletedCliquesTelefone = $this->db
                ->table('clique_telefone')
                ->where('estabelecimento_id', $usuario['estabelecimento_id'])
                ->delete();

            if ($deletedCliquesTelefone > 0) {
                $totalExcluidos += $deletedCliquesTelefone;
            }

            // 2.5. Exclui cliques de celular
            $deletedCliquesCelular = $this->db
                ->table('clique_celular')
                ->where('estabelecimento_id', $usuario['estabelecimento_id'])
                ->delete();

            if ($deletedCliquesCelular > 0) {
                $totalExcluidos += $deletedCliquesCelular;
            }
        }

        // ============================================
        // 3. EXCLUI TELEFONES DO USUÁRIO
        // ============================================
        $deletedTelefonesUsuario = $this->db
            ->table('telefone')
            ->where('usuario_id', $usuarioId)
            ->delete();

        if ($deletedTelefonesUsuario > 0) {
            $detalhes[] = "$deletedTelefonesUsuario telefone(s) do usuário";
            $totalExcluidos += $deletedTelefonesUsuario;
        }

        // ============================================
        // 4. EXCLUI ACEITES DE TERMOS DE USO
        // ============================================
        $deletedTermos = $this->db
            ->table('termodeusoaceite')
            ->where('usuario_id', $usuarioId)
            ->delete();

        if ($deletedTermos > 0) {
            $detalhes[] = "$deletedTermos aceite(s) de termos";
            $totalExcluidos += $deletedTermos;
        }

        // ============================================
        // 5. EXCLUI O USUÁRIO
        // ============================================
        $deletedUsuario = $this->db
            ->table('usuario')
            ->where('usuario_id', $usuarioId)
            ->delete();

        if ($deletedUsuario > 0) {
            $totalExcluidos++;

            $mensagemDetalhes = count($detalhes) > 0
                ? ' Também foram excluídos: ' . implode(', ', $detalhes) . '.'
                : '';

            return [
                'sucesso' => true,
                'mensagem' => 'Usuário excluído com sucesso!' . $mensagemDetalhes
            ];
        } else {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir o usuário após limpar dependências.'
            ];
        }
    }
}
