<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

use App\Model\UsuarioModel;
use App\Model\PessoaFisicaModel;
use App\Model\EstabelecimentoModel;
use App\Model\CidadeModel;
use App\Model\CargoModel;
use App\Model\EscolaridadeModel;
use App\Model\CurriculumModel;
use App\Model\CurriculumEscolaridadeModel;
use App\Model\CurriculumExperienciaModel;
use App\Model\CurriculumQualificacaoModel;
use App\Model\VagaModel;
use App\Model\VagaCurriculumModel;

class Candidato extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return Redirect::page('/sistema');
    }

    public function perfil($action, $id)
    {
        return $this->loadView("sistema/candidato/candidatoPerfil");
    }

    /**
     * candidaturas - Exibe candidaturas do usuário
     *
     * @return void
     */
    public function candidaturas()
    {
        $userId = Session::get('userId');

        if (!$userId) {
            return Redirect::page('Login/', ['msgError' => 'Sessão inválida. Faça login novamente.']);
        }

        // Models
        $usuarioModel = new UsuarioModel();
        $pessoaFisicaModel = new PessoaFisicaModel();
        $vagaCurriculumModel = new VagaCurriculumModel();
        $vagaModel = new VagaModel();
        $cargoModel = new CargoModel();
        $estabelecimentoModel = new EstabelecimentoModel();

        // Busca usuário
        $usuario = $usuarioModel->db
            ->table('usuario')
            ->where('usuario_id', $userId)
            ->first();

        if (empty($usuario) || empty($usuario['pessoa_fisica_id'])) {
            return Redirect::page('Sistema/', ['msgError' => 'Usuário não encontrado.']);
        }

        // Busca currículo
        $curriculum = $pessoaFisicaModel->db
            ->table('curriculum')
            ->where('pessoa_fisica_id', $usuario['pessoa_fisica_id'])
            ->first();

        if (empty($curriculum)) {
            return Redirect::page('candidato/curriculo', ['msgError' => 'Crie seu currículo primeiro.']);
        }

        // Busca candidaturas
        $vagasCandidatadas = $vagaCurriculumModel->db
            ->table('vaga_curriculum')
            ->where('curriculum_id', $curriculum['curriculum_id'])
            ->findAll();

        // Formata dados com JOINs manuais
        $candidaturasFormatadas = [];

        foreach ($vagasCandidatadas as $candidatura) {
            // Busca vaga
            $vaga = $vagaModel->db
                ->table('vaga')
                ->where('vaga_id', $candidatura['vaga_id'])
                ->first();

            if (empty($vaga)) {
                continue; // Pula se vaga não existe
            }

            // Busca cargo
            $cargo = $cargoModel->db
                ->table('cargo')
                ->where('cargo_id', $vaga['cargo_id'])
                ->first();

            // Busca estabelecimento
            $estabelecimento = $estabelecimentoModel->db
                ->table('estabelecimento')
                ->where('estabelecimento_id', $vaga['estabelecimento_id'])
                ->first();

            // Monta estrutura de candidatura
            $candidaturasFormatadas[] = [
                'vaga_id' => $candidatura['vaga_id'],
                'curriculum_id' => $candidatura['curriculum_id'],
                'dateCandidatura' => $candidatura['dateCandidatura'],
                'vaga' => [
                    'vaga_id' => $vaga['vaga_id'],
                    'cargo_id' => $vaga['cargo_id'],
                    'descricao' => $vaga['descricao'],
                    'sobreaVaga' => $vaga['sobreaVaga'],
                    'modalidade' => $vaga['modalidade'],
                    'vinculo' => $vaga['vinculo'],
                    'dtInicio' => $vaga['dtInicio'],
                    'dtFim' => $vaga['dtFim'],
                    'estabelecimento_id' => $vaga['estabelecimento_id'],
                    'statusVaga' => $vaga['statusVaga']
                ],
                'cargo' => $cargo ?? [],
                'estabelecimento' => $estabelecimento ?? []
            ];
        }

        // Ordena por data mais recente
        usort($candidaturasFormatadas, function ($a, $b) {
            return strtotime($b['dateCandidatura']) - strtotime($a['dateCandidatura']);
        });

        $viewData = ['candidaturas' => $candidaturasFormatadas];
        $this->loadView('sistema/candidato/candidatoCandidaturas', $viewData);
    }



    /**
     * curriculo - Exibe página de currículo com todos os dados
     *
     * @return void
     */
    public function curriculo()
    {
        $userId = Session::get('userId');

        // Validação de sessão
        if (!$userId) {
            return Redirect::page('Login/', ['msgError' => 'Sessão inválida. Faça login novamente.']);
        }

        // Instancia models
        $usuarioModel = new UsuarioModel();
        $pessoaFisicaModel = new PessoaFisicaModel();
        $curriculumModel = new CurriculumModel();
        $escolaridadeModel = new EscolaridadeModel();
        $escolaridadeCurriculumModel = new CurriculumEscolaridadeModel();
        $qualificacaoModel = new CurriculumQualificacaoModel();
        $experienciaModel = new CurriculumExperienciaModel();
        $cidadeModel = new CidadeModel();

        // Busca dados do usuário
        $usuario = $usuarioModel->db
            ->table('usuario')
            ->where('usuario_id', $userId)
            ->first();

        if (empty($usuario)) {
            return Redirect::page('Login/', ['msgError' => 'Usuário não encontrado.']);
        }

        // Busca dados da pessoa física
        $pessoaFisica = $pessoaFisicaModel->db
            ->table('pessoa_fisica')
            ->where('pessoa_fisica_id', $usuario['pessoa_fisica_id'])
            ->first();

        if (empty($pessoaFisica)) {
            return Redirect::page('Sistema/', ['msgError' => 'Dados pessoais não encontrados.']);
        }

        // Busca currículo
        $curriculum = $curriculumModel->db
            ->table('curriculum')
            ->where('pessoa_fisica_id', $pessoaFisica['pessoa_fisica_id'])
            ->first();

        // Se não tem currículo, cria um vazio para o usuário começar
        if (empty($curriculum)) {
            $curriculum = [
                'curriculum_id' => null,
                'pessoa_fisica_id' => $pessoaFisica['pessoa_fisica_id'],
                'email' => '',
                'celular' => '',
                'dataNascimento' => '',
                'sexo' => '',
                'cep' => '',
                'logradouro' => '',
                'numero' => '',
                'complemento' => '',
                'bairro' => '',
                'cidade_id' => '',
                'foto' => '',
                'apresentacaoPessoal' => ''
            ];
        }

        // Busca educações se currículo existe
        $educacoes = [];
        if (!empty($curriculum['curriculum_id'])) {
            $educacoes = $escolaridadeCurriculumModel->db
                ->table('curriculum_escolaridade')
                ->where('curriculum_curriculum_id', $curriculum['curriculum_id'])
                ->findAll();
        }

        // Busca qualificações se currículo existe
        $qualificacoes = [];
        if (!empty($curriculum['curriculum_id'])) {
            $qualificacoes = $qualificacaoModel->db
                ->table('curriculum_qualificacao')
                ->where('curriculum_id', $curriculum['curriculum_id'])
                ->findAll();
        }

        // Busca experiências se currículo existe
        $experiencias = [];
        if (!empty($curriculum['curriculum_id'])) {
            $experiencias = $experienciaModel->db
                ->table('curriculum_experiencia')
                ->where('curriculum_id', $curriculum['curriculum_id'])
                ->findAll();
        }

        // Busca todas as cidades
        $cidades = $cidadeModel->db
            ->table('cidade')
            ->findAll();

        // Busca todas as escolaridades
        $escolaridades = $escolaridadeModel->db
            ->table('escolaridade')
            ->findAll();

        // Busca todos os cargos
        $cargoModel = new CargoModel();
        $cargos = $cargoModel->db
            ->table('cargo')
            ->findAll();

        // Prepara dados para a view
        $viewData = [
            'dados' => [
                'pessoa_fisica_id' => $pessoaFisica['pessoa_fisica_id'],
                'curriculum' => $curriculum,
                'cidades' => $cidades,
                'escolaridades' => $escolaridades,
                'cargos' => $cargos,
                'educacoes' => $educacoes,
                'qualificacoes' => $qualificacoes,
                'experiencias' => $experiencias
            ]

        ];

        // Carrega a view
        $this->loadView('sistema/candidato/candidatoCurriculo', $viewData);
    }
    /**
     * salvarCurriculo - Salva ou atualiza currículo com todos os dados
     *
     * @return void
     */
    public function salvarCurriculo()
    {
        $post = $this->request->getPost();

        // Instancia models
        $curriculumModel = new CurriculumModel();
        $escolaridadeCurriculumModel = new CurriculumEscolaridadeModel();
        $qualificacaoModel = new CurriculumQualificacaoModel();
        $experienciaModel = new CurriculumExperienciaModel();

        $curriculumId = $post['curriculum_id'] ?? null;
        $pessoaFisicaId = $post['pessoa_fisica_id'] ?? null;

        // Validações básicas
        if (empty($post['email']) || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            return Redirect::page('candidato/curriculo', [
                'msgError' => 'E-mail inválido.',
                'inputs' => $post
            ]);
        }

        if (empty($post['cidade_id'])) {
            return Redirect::page('candidato/curriculo', [
                'msgError' => 'Cidade é obrigatória.',
                'inputs' => $post
            ]);
        }

        // ========== CURRICULUM PRINCIPAL ==========
        $dadosCurriculum = [
            'pessoa_fisica_id' => $pessoaFisicaId,
            'email' => trim($post['email']),
            'celular' => preg_replace('/\D/', '', $post['celular']),
            'dataNascimento' => $post['dataNascimento'],
            'sexo' => $post['sexo'],
            'cep' => preg_replace('/\D/', '', $post['cep']),
            'logradouro' => trim($post['logradouro']),
            'numero' => trim($post['numero']),
            'complemento' => trim($post['complemento'] ?? ''),
            'bairro' => trim($post['bairro']),
            'cidade_id' => $post['cidade_id'],
            'apresentacaoPessoal' => trim($post['apresentacaoPessoal'] ?? '')
        ];

        // Se é criação, INSERT. Se é atualização, UPDATE
        if (empty($curriculumId)) {
            // ✅ CRIAR (INSERT)
            $curriculumId = $curriculumModel->insert($dadosCurriculum);

            if (!$curriculumId) {
                return Redirect::page('candidato/curriculo', [
                    'msgError' => 'Falha ao criar currículo.',
                    'inputs' => $post
                ]);
            }
        } else {
            // ✅ ATUALIZAR (UPDATE) - SEM VALIDAR RETORNO
            $dadosCurriculum['curriculum_id'] = $curriculumId;
            $curriculumModel->update($dadosCurriculum);
            // Não validamos! (0 linhas = dados iguais, não é erro)
        }

        // ========== EDUCAÇÕES ==========
        // Deleta educações antigas
        $escolaridadeCurriculumModel->db
            ->table('curriculum_escolaridade')
            ->where('curriculum_curriculum_id', $curriculumId)
            ->delete();

        // Insere novas educações
        if (!empty($post['educacoes']) && is_array($post['educacoes'])) {
            foreach ($post['educacoes'] as $educacao) {
                if (empty($educacao['escolaridade_id']) || empty($educacao['instituicao'])) {
                    continue;
                }

                $dadosEducacao = [
                    'curriculum_curriculum_id' => $curriculumId,
                    'escolaridade_id' => $educacao['escolaridade_id'],
                    'descricao' => trim($educacao['descricao'] ?? ''),
                    'instituicao' => trim($educacao['instituicao']),
                    'cidade_id' => $educacao['cidade_id'],
                    'inicioMes' => $educacao['inicioMes'],
                    'inicioAno' => $educacao['inicioAno'],
                    'fimMes' => $educacao['fimMes'],
                    'fimAno' => $educacao['fimAno']
                ];

                // ✅ SEM VALIDAR RETORNO
                $escolaridadeCurriculumModel->insert($dadosEducacao);
            }
        }

        // ========== QUALIFICAÇÕES ==========
        // Deleta qualificações antigas
        $qualificacaoModel->db
            ->table('curriculum_qualificacao')
            ->where('curriculum_id', $curriculumId)
            ->delete();

        // Insere novas qualificações
        if (!empty($post['qualificacoes']) && is_array($post['qualificacoes'])) {
            foreach ($post['qualificacoes'] as $qualificacao) {
                if (empty($qualificacao['descricao']) || empty($qualificacao['estabelecimento'])) {
                    continue;
                }

                $dadosQualificacao = [
                    'curriculum_id' => $curriculumId,
                    'descricao' => trim($qualificacao['descricao']),
                    'estabelecimento' => trim($qualificacao['estabelecimento']),
                    'mes' => $qualificacao['mes'],
                    'ano' => $qualificacao['ano'],
                    'cargaHoraria' => $qualificacao['cargaHoraria']
                ];

                // ✅ SEM VALIDAR RETORNO
                $qualificacaoModel->insert($dadosQualificacao);
            }
        }

        // ========== EXPERIÊNCIAS ==========
        // Deleta experiências antigas
        $experienciaModel->db
            ->table('curriculum_experiencia')
            ->where('curriculum_id', $curriculumId)
            ->delete();

        // Insere novas experiências
        if (!empty($post['experiencias']) && is_array($post['experiencias'])) {
            foreach ($post['experiencias'] as $experiencia) {
                if (empty($experiencia['estabelecimento']) || empty($experiencia['cargoDescricao'])) {
                    continue;
                }

                $dadosExperiencia = [
                    'curriculum_id' => $curriculumId,
                    'estabelecimento' => trim($experiencia['estabelecimento']),
                    'cargoDescricao' => trim($experiencia['cargoDescricao']),
                    'inicioMes' => $experiencia['inicioMes'],
                    'inicioAno' => $experiencia['inicioAno'],
                    'fimMes' => $experiencia['fimMes'] ?? null,
                    'fimAno' => $experiencia['fimAno'] ?? null,
                    'atividadesExercidas' => trim($experiencia['atividadesExercidas'] ?? '')
                ];

                // ✅ SEM VALIDAR RETORNO
                $experienciaModel->insert($dadosExperiencia);
            }
        }

        // ✅ SUCESSO
        Session::destroy('inputs');

        return Redirect::page('candidato/curriculo', ['msgSucesso' => 'Currículo salvo com sucesso!']);
    }
}
