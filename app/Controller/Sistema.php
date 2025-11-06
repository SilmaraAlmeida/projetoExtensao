<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Session;
use Core\Library\Redirect;
use App\Model\UsuarioModel;
use App\Model\CidadeModel;
use App\Model\TelefoneModel;
use App\Model\PessoaFisicaModel;
use App\Model\EstabelecimentoModel;

class Sistema extends ControllerMain
{
    public function index()
    {
        $this->loadView("sistema/homeSistema");
    }

    // METODOS DE PAGINAS PARA USUARIOS PESSOA FISICA

    public function perfil()
    {
        $usuarioId = Session::get('userId');
        $userTipo = Session::get('userNivel');

        // Busca dados do perfil usando o UsuarioModel
        $usuarioModel = new UsuarioModel();
        $dados = $usuarioModel->getDadosPerfil($usuarioId);

        // Se não encontrou dados, redireciona com erro
        if (empty($dados)) {
            Redirect::page('Sistema/', ['error' => 'Erro ao carregar dados do perfil.']);
        }

        // Prepara dados para view
        $viewData = [
            'dados' => $dados,
        ];

        // Carrega a view única de perfil
        $this->loadView("sistema/candidato/candidatoPerfil", $viewData);
    }

    /**
     * atualizarPerfil - Atualizar dados do perfil do usuário
     *
     * @return void
     */
    public function atualizarPerfil()
    {
        $post = $this->request->getPost();

        $userId = Session::get('userId');
        $userNivel = Session::get('userNivel');

        // Instancia models necessários
        $usuarioModel = new UsuarioModel();
        $pessoaFisicaModel = new PessoaFisicaModel();
        $estabelecimentoModel = new EstabelecimentoModel();
        $telefoneModel = new TelefoneModel();

        // Busca dados atuais do usuário
        $dadosAtuais = $usuarioModel->getDadosPerfil($userId);

        if (empty($dadosAtuais)) {
            return Redirect::page('Sistema/perfil', ['msgError' => 'Usuário não encontrado.']);
        }

        if ($userNivel === 'A') {
            // ============================================
            // ATUALIZAÇÃO PARA EMPRESA (TIPO A)
            // ============================================

            $estabelecimentoId = $dadosAtuais['estabelecimento_id'];

            // Validações específicas de empresa
            if (empty($post['nome'])) {
                return Redirect::page('Sistema/perfil', [
                    'msgError' => 'O nome da empresa é obrigatório.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['email']) || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                return Redirect::page('Sistema/perfil', [
                    'msgError' => 'E-mail inválido.',
                    'inputs' => $post
                ]);
            }

            // Dados do estabelecimento
            $dadosEstabelecimento = [
                'estabelecimento_id' => $estabelecimentoId,
                'nome' => trim($post['nome']),
                'email' => trim($post['email']),
                'endereco' => trim($post['endereco'] ?? ''),
                'latitude' => trim($post['latitude'] ?? ''),
                'longitude' => trim($post['longitude'] ?? '')
            ];

            $estabelecimentoModel->update($dadosEstabelecimento);

            // Atualiza telefones
            $resultadoTelefones = $this->atualizarTelefones($telefoneModel, $post['telefones'] ?? [], $estabelecimentoId, 'estabelecimento');

            if ($resultadoTelefones !== true) {
                return Redirect::page('Sistema/perfil', [
                    'msgError' => $resultadoTelefones,
                    'inputs' => $post
                ]);
            }
        } else {
            // ============================================
            // ATUALIZAÇÃO PARA PESSOA FÍSICA (CN/G)
            // ============================================

            $pessoaFisicaId = $dadosAtuais['pessoa_fisica_id'];

            // Validações específicas de pessoa física
            if (empty($post['nome'])) {
                return Redirect::page('Sistema/perfil', [
                    'msgError' => 'O nome é obrigatório.',
                    'inputs' => $post
                ]);
            }

            if (empty($post['cpf'])) {
                return Redirect::page('Sistema/perfil', [
                    'msgError' => 'O CPF é obrigatório.',
                    'inputs' => $post
                ]);
            }

            $cpfLimpo = preg_replace('/\D/', '', $post['cpf']);
            if (strlen($cpfLimpo) !== 11) {
                return Redirect::page('Sistema/perfil', [
                    'msgError' => 'CPF inválido. Deve conter 11 dígitos.',
                    'inputs' => $post
                ]);
            }

            // Dados da pessoa física
            $dadosPessoaFisica = [
                'pessoa_fisica_id' => $pessoaFisicaId,
                'nome' => trim($post['nome']),
                'cpf' => $cpfLimpo
            ];

            $pessoaFisicaModel->update($dadosPessoaFisica);

            // Atualiza telefones
            $resultadoTelefones = $this->atualizarTelefones($telefoneModel, $post['telefones'] ?? [], $userId, 'usuario');

            if ($resultadoTelefones !== true) {
                return Redirect::page('Sistema/perfil', [
                    'msgError' => $resultadoTelefones,
                    'inputs' => $post
                ]);
            }
        }

        Session::destroy('inputs');

        return Redirect::page('Sistema/perfil', ['msgSucesso' => 'Perfil atualizado com sucesso!']);
    }

    /**
     * Método auxiliar para atualizar telefones
     *
     * @param object $telefoneModel Instância do TelefoneModel
     * @param array $telefones
     * @param int $entityId
     * @param string $entityType 'usuario' ou 'estabelecimento'
     * @return bool|string true se sucesso, string com mensagem de erro se falhar
     */
    private function atualizarTelefones($telefoneModel, $telefones, $entityId, $entityType)
    {
        // Remove todos os telefones existentes
        if ($entityType === 'usuario') {
            $telefoneModel->deleteTelefonesPorUsuario($entityId);
        } else {
            $telefoneModel->deleteTelefonesPorEstabelecimento($entityId);
        }

        // Se não tem telefones para inserir, retorna sucesso
        if (empty($telefones) || !is_array($telefones)) {
            return true;
        }

        // Insere os novos telefones
        foreach ($telefones as $telefone) {
            $numero = preg_replace('/\D/', '', $telefone['numero'] ?? '');

            // Ignora telefones vazios
            if (empty($numero)) {
                continue;
            }

            // Validação básica de telefone
            if (strlen($numero) < 10 || strlen($numero) > 11) {
                return "Telefone inválido: " . ($telefone['numero'] ?? 'não informado');
            }

            $dadosTelefone = [
                'numero' => $numero,
                'tipo' => in_array($telefone['tipo'] ?? '', ['m', 'f']) ? $telefone['tipo'] : 'm'
            ];

            // Define a FK correta
            if ($entityType === 'usuario') {
                $dadosTelefone['usuario_id'] = $entityId;
                $dadosTelefone['estabelecimento_id'] = null;
            } else {
                $dadosTelefone['estabelecimento_id'] = $entityId;
                $dadosTelefone['usuario_id'] = null;
            }

            // Insere telefone
            if (!$telefoneModel->insert($dadosTelefone)) {
                return "Falha ao cadastrar telefone: " . $numero;
            }
        }

        return true;
    }


    public function vagasInscritas()
    {
        $this->loadView("sistema/vagasInscritas");
    }

    public function configuracoes()
    {
        $this->loadView("sistema/configuracoes");
    }

    public function curriculo()
    {
        $this->loadView("sistema/curriculo");
    }

    // METODOS DE PAGINAS PARA USUARIOS EMPRESAS/ANUNCIANTES DE VAGAS

    // CRUD CRIACAO DE VAGAS
    public function minhasVagas()
    {
        $this->loadView("sistema/minhasVagas");
    }

    // VISUALIZAR CANDIDATOS COM DETALHE ESCRITOS NAS VAGAS
    public function candidatos()
    {
        $this->loadView("sistema/minhasVagas");
    }
}
