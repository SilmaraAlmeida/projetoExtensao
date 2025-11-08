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

class VagasEmpresa extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    /**
     * vagas - Exibe lista de vagas da empresa
     *
     * @param string $action
     * @param int $id
     * @return void
     */
    public function index($action = null, $id = null)
    {
        $usuarioId = Session::get('userId');

        if (!$usuarioId) {
            return Redirect::page('Login/', ['msgError' => 'Sessão inválida. Faça login novamente.']);
        }

        // Models
        $usuarioModel = new UsuarioModel();
        $estabelecimentoModel = new EstabelecimentoModel();
        $vagaModel = new VagaModel();
        $cargoModel = new CargoModel();

        // Busca usuário
        $usuario = $usuarioModel->db
            ->table('usuario')
            ->where('usuario_id', $usuarioId)
            ->first();

        if (empty($usuario) || empty($usuario['estabelecimento_id'])) {
            return Redirect::page('Sistema/', ['msgError' => 'Usuário não vinculado a uma empresa.']);
        }

        $estabelecimentoId = $usuario['estabelecimento_id'];

        // ========== DELETE =========
        if ($action === 'delete' && $id) {
            $vagaModel->delete(['vaga_id' => $id]);
            return Redirect::page('empresa/vagas', ['msgSucesso' => 'Vaga deletada com sucesso!']);
        }

        // Busca todas as vagas da empresa
        $vagas = $vagaModel->db
            ->table('vaga v')
            ->select('v.*, c.descricao as cargoDescricao, COUNT(vc.vaga_id) as candidatos')
            ->join('cargo c', 'c.cargo_id = v.cargo_id', 'LEFT')
            ->join('vaga_curriculum vc', 'vc.vaga_id = v.vaga_id', 'LEFT')
            ->where('v.estabelecimento_id', $estabelecimentoId)
            ->groupBy('v.vaga_id')
            ->orderBy('v.vaga_id', 'DESC')
            ->findAll();

        // Formata dados com cargo
        $vagasFormatadas = [];
        foreach ($vagas as $vaga) {
            $vagasFormatadas[] = [
                'vaga_id' => $vaga['vaga_id'],
                'cargo_id' => $vaga['cargo_id'],
                'cargo' => ['descricao' => $vaga['cargoDescricao'] ?? ''],
                'descricao' => $vaga['descricao'],
                'sobreaVaga' => $vaga['sobreaVaga'],
                'modalidade' => $vaga['modalidade'],
                'vinculo' => $vaga['vinculo'],
                'dtInicio' => $vaga['dtInicio'],
                'dtFim' => $vaga['dtFim'],
                'estabelecimento_id' => $vaga['estabelecimento_id'],
                'statusVaga' => $vaga['statusVaga'],
                'candidatos' => $vaga['candidatos'] ?? 0
            ];
        }

        $cargoModel = new CargoModel();
        $cargos = $cargoModel->db->table('cargo')->findAll();

        $viewData = [
            'vagas' => $vagasFormatadas,
            'cargos' => $cargos
        ];

        return $this->loadView('sistema/empresa/minhasVagas', $viewData);
    }


    public function form($action = 'insert', $id = '0')
    {
        $vagaModel = new VagaModel();
        $cargoModel = new CargoModel();

        $estabelecimentoId = Session::get('estabelecimento_id');
        $idVaga = (int)$id;
        $vaga = [];

        // ========== BUSCA VAGA SE FOR UPDATE OU DELETE ==========
        if (($action === 'update' || $action === 'delete') && $idVaga > 0) {
            $vaga = $vagaModel->db
                ->table('vaga')
                ->where('vaga_id', $idVaga)
                ->first();

            if (empty($vaga)) {
                return Redirect::page('vagasEmpresa', ['msgError' => 'Vaga não encontrada.']);
            }

            // Busca cargo para delete
            if ($action === 'delete') {
                $cargo = $cargoModel->db
                    ->table('cargo')
                    ->where('cargo_id', $vaga['cargo_id'])
                    ->first();
                $vaga['cargo'] = $cargo ?? [];
            }
        }

        // ========== PROCESSA POST ==========
        $post = $this->request->getPost();

        if (!empty($post)) {
            // Validações básicas
            if (empty($post['cargo_id'])) {
                return Redirect::page("vagasEmpresa/form/{$action}/{$idVaga}", [
                    'msgError' => 'Cargo é obrigatório.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['descricao'])) {
                return Redirect::page("vagasEmpresa/form/{$action}/{$idVaga}", [
                    'msgError' => 'Descrição breve é obrigatória.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['sobreaVaga'])) {
                return Redirect::page("vagasEmpresa/form/{$action}/{$idVaga}", [
                    'msgError' => 'Informações detalhadas são obrigatórias.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['modalidade'])) {
                return Redirect::page("vagasEmpresa/form/{$action}/{$idVaga}", [
                    'msgError' => 'Modalidade é obrigatória.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['vinculo'])) {
                return Redirect::page("vagasEmpresa/form/{$action}/{$idVaga}", [
                    'msgError' => 'Vínculo é obrigatório.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['dtInicio']) || empty($post['dtFim'])) {
                return Redirect::page("vagasEmpresa/form/{$action}/{$idVaga}", [
                    'msgError' => 'Datas de início e fim são obrigatórias.',
                    'inputs' => $post
                ]);
            }

            // Dados da vaga
            $dadosVaga = [
                'cargo_id' => $post['cargo_id'],
                'estabelecimento_id' => $estabelecimentoId,
                'descricao' => trim($post['descricao']),
                'sobreaVaga' => trim($post['sobreaVaga']),
                'modalidade' => $post['modalidade'],
                'vinculo' => $post['vinculo'],
                'dtInicio' => $post['dtInicio'],
                'dtFim' => $post['dtFim'],
                'statusVaga' => $post['statusVaga'] ?? 11
            ];

            // ========== INSERT ==========
            if ($action === 'insert') {
                $vagaId = $vagaModel->insert($dadosVaga);

                if ($vagaId) {
                    Session::destroy('inputs');
                    return Redirect::page('vagasEmpresa', ['msgSucesso' => 'Vaga criada com sucesso!']);
                } else {
                    return Redirect::page("vagasEmpresa/form/{$action}/{$idVaga}", [
                        'msgError' => 'Falha ao criar vaga.',
                        'inputs' => $post
                    ]);
                }
            }

            // ========== UPDATE ==========
            if ($action === 'update' && $idVaga > 0) {
                $dadosVaga['vaga_id'] = $idVaga;
                $vagaModel->update($dadosVaga);

                Session::destroy('inputs');
                return Redirect::page('vagasEmpresa', ['msgSucesso' => 'Vaga atualizada com sucesso!']);
            }

            // ========== DELETE ==========
            if ($action === 'delete' && $idVaga > 0) {
                $vagaModel->delete(['vaga_id' => $idVaga]);

                Session::destroy('inputs');
                return Redirect::page('vagasEmpresa', ['msgSucesso' => 'Vaga deletada com sucesso!']);
            }
        }

        // Busca cargos
        $cargos = $cargoModel->db->table('cargo')->findAll();

        $viewData = [
            'vaga' => $vaga,
            'cargos' => $cargos
        ];

        return $this->loadView('sistema/empresa/formVagas', $viewData);
    }
    /**
     * insert - Cria uma nova vaga
     *
     * @return void
     */
    public function insert()
    {
        $post = $this->request->getPost();
        $vagaModel = new VagaModel();
        $usuarioModel = new UsuarioModel();

        $usuarioId = Session::get('userId');
        $usuario = $usuarioModel->db
            ->table('usuario')
            ->where('usuario_id', $usuarioId)
            ->first();

        $estabelecimentoId = $usuario['estabelecimento_id'] ?? null;

        if (!$estabelecimentoId) {
            return Redirect::page('VagasEmpresa', ['msgError' => 'Usuário não vinculado a uma empresa.']);
        }

        // Dados da vaga
        $dadosVaga = [
            'cargo_id' => $post['cargo_id'] ?? null,
            'estabelecimento_id' => $estabelecimentoId,
            'descricao' => trim($post['descricao'] ?? ''),
            'sobreaVaga' => trim($post['sobreaVaga'] ?? ''),
            'modalidade' => $post['modalidade'] ?? null,
            'vinculo' => $post['vinculo'] ?? null,
            'dtInicio' => $post['dtInicio'] ?? null,
            'dtFim' => $post['dtFim'] ?? null,
            'statusVaga' => $post['statusVaga'] ?? 11
        ];

        $novaVagaId = $vagaModel->insert($dadosVaga);

        if ($novaVagaId) {
            Session::destroy('inputs');
            return Redirect::page('VagasEmpresa', ['msgSucesso' => 'Vaga criada com sucesso!']);
        } else {
            return Redirect::page('VagasEmpresa/form/insert/0', [
                'msgError' => 'Falha ao criar vaga.',
                'inputs' => $post
            ]);
        }
    }
    /**
     * update - Atualiza uma vaga existente
     *
     * @return void
     */
    public function update()
    {
        $post = $this->request->getPost();
        $lError = false;

        $vagaModel = new VagaModel(); // ✅ Adiciona esta linha

        $usuarioModel = new UsuarioModel();
        $usuarioId = Session::get('userId');
        $usuario = $usuarioModel->db
            ->table('usuario')
            ->where('usuario_id', $usuarioId)
            ->first();

        $estabelecimentoId = $usuario['estabelecimento_id'] ?? null;

        if (!$estabelecimentoId) {
            $lError = true;
            Session::set("inputs", $post);
            return Redirect::page('VagasEmpresa', ['msgError' => 'Usuário não vinculado a uma empresa.']);
        }

        $post['estabelecimento_id'] = $estabelecimentoId;

        if (!$lError) {
            if ($vagaModel->update($post)) { // ✅ Usa $vagaModel
                return Redirect::page('VagasEmpresa', ["msgSucesso" => "Vaga atualizada com sucesso."]);
            } else {
                $lError = true;
            }
        }

        if ($lError) {
            Session::set("inputs", $post);
            return Redirect::page('VagasEmpresa/form/update/' . $post['vaga_id']);
        }
    }

    /**
     * delete - Deleta uma vaga
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->request->getPost();

        $vagaModel = new VagaModel(); // ✅ Adiciona esta linha

        $usuarioModel = new UsuarioModel();
        $usuarioId = Session::get('userId');
        $usuario = $usuarioModel->db
            ->table('usuario')
            ->where('usuario_id', $usuarioId)
            ->first();

        $estabelecimentoId = $usuario['estabelecimento_id'] ?? null;

        if (!$estabelecimentoId) {
            return Redirect::page('VagasEmpresa', ['msgError' => 'Usuário não vinculado a uma empresa.']);
        }

        $resultado = $vagaModel->delete(['vaga_id' => $post['vaga_id']]); // ✅ Usa $vagaModel

        if ($resultado) {
            return Redirect::page('VagasEmpresa', ['msgSucesso' => 'Vaga deletada com sucesso.']);
        } else {
            return Redirect::page('VagasEmpresa', ['msgError' => 'Falha ao deletar vaga.']);
        }
    }

/**
 * candidatos - Exibe candidatos de uma vaga
 *
 * @param string $action
 * @param int $id ID da vaga
 * @return void
 */
public function candidatos($action = null, $id = null)
{
    $usuarioId = Session::get('userId');
    
    if (!$usuarioId) {
        return Redirect::page('Login/', ['msgError' => 'Sessão inválida.']);
    }

    // Models
    $usuarioModel = new UsuarioModel();
    $vagaModel = new VagaModel();
    $vagaCurriculumModel = new VagaCurriculumModel();
    $curriculumModel = new CurriculumModel();
    $pessoaFisicaModel = new PessoaFisicaModel();
    $escolaridadeModel = new EscolaridadeModel();

    // Busca usuário e estabelecimento
    $usuario = $usuarioModel->db
        ->table('usuario')
        ->where('usuario_id', $usuarioId)
        ->first();

    $estabelecimentoId = $usuario['estabelecimento_id'] ?? null;

    if (!$estabelecimentoId) {
        return Redirect::page('VagasEmpresa', ['msgError' => 'Usuário não vinculado a uma empresa.']);
    }

    $vagaId = (int)$id;

    if (!$vagaId) {
        return Redirect::page('VagasEmpresa', ['msgError' => 'Vaga inválida.']);
    }

    // Busca vaga com cargo
    $vaga = $vagaModel->db
        ->table('vaga v')
        ->select('v.*, c.descricao as cargoDescricao')
        ->join('cargo c', 'c.cargo_id = v.cargo_id', 'LEFT')
        ->where('v.vaga_id', $vagaId)
        ->where('v.estabelecimento_id', $estabelecimentoId)
        ->first();

    if (empty($vaga)) {
        return Redirect::page('VagasEmpresa', ['msgError' => 'Vaga não encontrada ou sem permissão.']);
    }

    // Busca candidaturas
    $candidaturas = $vagaCurriculumModel->db
        ->table('vaga_curriculum')
        ->where('vaga_id', $vagaId)
        ->orderBy('dateCandidatura', 'DESC')
        ->findAll();

    // Formata dados dos candidatos
    $candidatosFormatados = [];

    foreach ($candidaturas as $candidatura) {
        $curriculumId = $candidatura['curriculum_id'];

        // Busca currículo
        $curriculum = $curriculumModel->db
            ->table('curriculum')
            ->where('curriculum_id', $curriculumId)
            ->first();

        if (empty($curriculum)) {
            continue;
        }

        // Busca pessoa física
        $pessoa = $pessoaFisicaModel->db
            ->table('pessoa_fisica')
            ->where('pessoa_fisica_id', $curriculum['pessoa_fisica_id'])
            ->first();

        // Busca educações
        $educacoes = $curriculumModel->db
            ->table('curriculum_escolaridade ce')
            ->select('ce.*, e.descricao as escolaridadeDescricao')
            ->join('escolaridade e', 'e.escolaridade_id = ce.escolaridade_id', 'LEFT')
            ->where('ce.curriculum_curriculum_id', $curriculumId)
            ->findAll();

        // Busca qualificações
        $qualificacoes = $curriculumModel->db
            ->table('curriculum_qualificacao')
            ->where('curriculum_id', $curriculumId)
            ->findAll();

        // Busca experiências
        $experiencias = $curriculumModel->db
            ->table('curriculum_experiencia')
            ->where('curriculum_id', $curriculumId)
            ->findAll();

        // Monta estrutura
        $candidatosFormatados[] = [
            'dateCandidatura' => $candidatura['dateCandidatura'],
            'pessoa' => $pessoa ?? [],
            'curriculum' => $curriculum,
            'educacoes' => $educacoes,
            'qualificacoes' => $qualificacoes,
            'experiencias' => $experiencias
        ];
    }

    $viewData = [
        'vaga' => $vaga,
        'candidatos' => $candidatosFormatados
    ];

    return $this->loadView('sistema/empresa/candidatos', $viewData);
}

}
