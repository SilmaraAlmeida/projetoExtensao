<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

use App\Model\UsuarioModel;
use App\Model\PessoaFisicaModel;
use App\Model\EstabelecimentoModel;
use App\Model\CargoModel;
use App\Model\VagaModel;
use App\Model\CurriculumModel;
use App\Model\VagaCurriculumModel;
use App\Model\EscolaridadeModel;

class Empresa extends ControllerMain
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

    /**
     * vagas - Exibe lista de vagas da empresa
     *
     * @param string $action
     * @param int $id
     * @return void
     */
    public function vagas($action = null, $id = null)
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

    /**
     * formVagas - Exibe formulário para criar/editar/deletar vaga
     *
     * @param string $action (insert, update, delete)
     * @param int $id ID da vaga (0 para insert)
     * @return void
     */
    public function formVagas($action = 'insert', $id = '0')
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
                return Redirect::page('empresa/vagas', ['msgError' => 'Vaga não encontrada.']);
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
                return Redirect::page("empresa/vagas/form/{$action}/{$idVaga}", [
                    'msgError' => 'Cargo é obrigatório.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['descricao'])) {
                return Redirect::page("empresa/vagas/form/{$action}/{$idVaga}", [
                    'msgError' => 'Descrição breve é obrigatória.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['sobreaVaga'])) {
                return Redirect::page("empresa/vagas/form/{$action}/{$idVaga}", [
                    'msgError' => 'Informações detalhadas são obrigatórias.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['modalidade'])) {
                return Redirect::page("empresa/vagas/form/{$action}/{$idVaga}", [
                    'msgError' => 'Modalidade é obrigatória.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['vinculo'])) {
                return Redirect::page("empresa/vagas/form/{$action}/{$idVaga}", [
                    'msgError' => 'Vínculo é obrigatório.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['dtInicio']) || empty($post['dtFim'])) {
                return Redirect::page("empresa/vagas/form/{$action}/{$idVaga}", [
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
                    return Redirect::page('empresa/vagas', ['msgSucesso' => 'Vaga criada com sucesso!']);
                } else {
                    return Redirect::page("empresa/vagas/form/{$action}/{$idVaga}", [
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
                return Redirect::page('empresa/vagas', ['msgSucesso' => 'Vaga atualizada com sucesso!']);
            }

            // ========== DELETE ==========
            if ($action === 'delete' && $idVaga > 0) {
                $vagaModel->delete(['vaga_id' => $idVaga]);

                Session::destroy('inputs');
                return Redirect::page('empresa/vagas', ['msgSucesso' => 'Vaga deletada com sucesso!']);
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
     * salvarVaga - Salva ou atualiza uma vaga (INSERT/UPDATE)
     *
     * @return void
     */
    public function salvarVaga()
    {
        $post = $this->request->getPost();

        $vagaModel = new VagaModel();

        // Pega estabelecimento_id da session (será adicionado ao usuário)
        $usuarioId = Session::get('userId');

        // Para pegar o estabelecimento_id, você precisa buscar do usuário
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->db
            ->table('usuario')
            ->where('usuario_id', $usuarioId)
            ->first();

        $estabelecimentoId = $usuario['estabelecimento_id'] ?? null;

        if (!$estabelecimentoId) {
            return Redirect::page('empresa/vagas', ['msgError' => 'Usuário não vinculado a uma empresa.']);
        }

        // ID da vaga (vazio para insert, preenchido para update)
        $vagaId = $post['vaga_id'] ?? null;

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

        // ========== INSERT ==========
        if (empty($vagaId) || $vagaId == 0) {
            $novaVagaId = $vagaModel->insert($dadosVaga);

            if ($novaVagaId) {
                Session::destroy('inputs');
                return Redirect::page('empresa/vagas', ['msgSucesso' => 'Vaga criada com sucesso!']);
            } else {
                return Redirect::page('empresa/vagas/form/insert/0', [
                    'msgError' => 'Falha ao criar vaga.',
                    'inputs' => $post
                ]);
            }
        }

        // ========== UPDATE ==========
        else {
            $dadosVaga['vaga_id'] = $vagaId;

            $resultado = $vagaModel->update($dadosVaga);

            if ($resultado) {
                Session::destroy('inputs');
                return Redirect::page('empresa/vagas', ['msgSucesso' => 'Vaga atualizada com sucesso!']);
            } else {
                return Redirect::page("empresa/vagas/form/update/{$vagaId}", [
                    'msgError' => 'Falha ao atualizar vaga.',
                    'inputs' => $post
                ]);
            }
        }
    }
}
