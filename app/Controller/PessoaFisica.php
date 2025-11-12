<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

use App\Model\PessoaFisicaModel;

class PessoaFisica extends ControllerMain
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->auxiliarConstruct();
        $this->loadHelper(['formHelper', 'tabela']);
        $this->validaNivelAcesso("G");                     // Valida nível de acesso apenas Gestor
    }

    /**
     * index
     * Lista todas as pessoas físicas com informações de vinculação
     *
     * @return void
     */
    public function index()
    {
        // Instancia model
        $pessoaFisicaModel = new PessoaFisicaModel();

        // Busca todas as pessoas físicas com informações de usuário vinculado
        $pessoasFisicas = $pessoaFisicaModel->db
            ->table('pessoa_fisica')
            ->select('pessoa_fisica.pessoa_fisica_id, 
                  pessoa_fisica.nome, 
                  pessoa_fisica.cpf, 
                  pessoa_fisica.visitante_id,
                  usuario.usuario_id,
                  usuario.login,
                  usuario.tipo')
            ->join('usuario', 'pessoa_fisica.pessoa_fisica_id = usuario.pessoa_fisica_id', 'LEFT')
            ->orderBy('pessoa_fisica.pessoa_fisica_id', 'DESC')
            ->findAll();

        // Calcula estatísticas
        $estatisticas = [
            'total' => count($pessoasFisicas),
            'com_usuario' => count(array_filter($pessoasFisicas, fn($p) => !empty($p['usuario_id']))),
            'sem_usuario' => count(array_filter($pessoasFisicas, fn($p) => empty($p['usuario_id']))),
            'com_cpf' => count(array_filter($pessoasFisicas, fn($p) => !empty($p['cpf'])))
        ];

        // Dados para a view
        $dados = [
            'pessoas' => $pessoasFisicas,
            'estatisticas' => $estatisticas
        ];

        return $this->loadView("sistema/listaPessoaFisica", $dados);
    }

    /**
     * form
     * Formulário de criação/edição de pessoa física
     *
     * @param string $action 
     * @param integer $id 
     * @return void
     */
    public function form($action = null, $id = null)
    {
        if ($this->action == "insert") {
            $dados = [
                'pessoa_fisica_id' => '',
                'nome' => '',
                'cpf' => '',
                'visitante_id' => ''
            ];
        } else {
            // Busca pessoa física diretamente
            $pessoaFisicaModel = new PessoaFisicaModel();

            $dados = $pessoaFisicaModel->db
                ->table('pessoa_fisica')
                ->where('pessoa_fisica_id', $id)
                ->first();

            if (!$dados) {
                return Redirect::page('PessoaFisica', [
                    'msgError' => 'Pessoa física não encontrada'
                ]);
            }
        }

        return $this->loadView("sistema/formPessoaFisica", $dados);
    }

    /**
     * insert
     * Cria nova pessoa física com validações
     *
     * @return void
     */
    public function insert()
    {
        $post = $this->request->getPost();
        $lError = false;
        $errors = [];

        // Validação de CPF se preenchido
        if (!empty($post['cpf'])) {
            // Remove formatação
            $cpfLimpo = preg_replace('/\D/', '', $post['cpf']);

            if (!$this->validarCPF($cpfLimpo)) {
                $lError = true;
                $errors['cpf'] = "O <b>CPF</b> informado é inválido.";
            } else {
                // Verifica duplicidade
                $pessoaFisicaModel = new PessoaFisicaModel();

                if ($pessoaFisicaModel->verificaDuplicidadeCPF($cpfLimpo)) {
                    $lError = true;
                    $errors['cpf'] = "O <b>CPF</b> já está cadastrado no sistema.";
                } else {
                    $post['cpf'] = $cpfLimpo;
                }
            }
        } else {
            $post['cpf'] = null;
        }

        // Tratamento de visitante_id vazio
        if (empty($post['visitante_id'])) {
            $post['visitante_id'] = null;
        }

        // Remove campos desnecessários
        unset($post['action']);
        if (isset($post['pessoa_fisica_id']) && empty($post['pessoa_fisica_id'])) {
            unset($post['pessoa_fisica_id']);
        }

        // Inserção
        if (!$lError) {
            if ($this->model->insert($post)) {
                return Redirect::page($this->controller, ["msgSucesso" => "Pessoa física cadastrada com sucesso."]);
            } else {
                $lError = true;
                $errors['geral'] = "Erro ao inserir registro no banco de dados.";
            }
        }

        // Retorno com erros
        if ($lError) {
            Session::set('errors', $errors);
            Session::set("inputs", $post);
            return Redirect::page($this->controller . '/form/insert/0');
        }
    }

    /**
     * validarCPF
     * Valida CPF usando algoritmo oficial
     *
     * @param string $cpf
     * @return bool
     */
    private function validarCPF($cpf)
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/\D/', '', $cpf);

        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        // Validação do primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += $cpf[$i] * (10 - $i);
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;

        if ($cpf[9] != $digito1) {
            return false;
        }

        // Validação do segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += $cpf[$i] * (11 - $i);
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;

        if ($cpf[10] != $digito2) {
            return false;
        }

        return true;
    }


    /**
     * update
     * Atualiza pessoa física com validações
     *
     * @return void
     */
    public function update()
    {
        $post = $this->request->getPost();
        $lError = false;
        $errors = [];

        // Validação de CPF se preenchido
        if (!empty($post['cpf'])) {
            // Remove formatação
            $cpfLimpo = preg_replace('/\D/', '', $post['cpf']);

            if (!$this->validarCPF($cpfLimpo)) {
                $lError = true;
                $errors['cpf'] = "O <b>CPF</b> informado é inválido.";
            } else {
                // Verifica duplicidade (exceto o próprio registro)
                $pessoaFisicaModel = new PessoaFisicaModel();

                $pessoaComCPF = $pessoaFisicaModel->db
                    ->table('pessoa_fisica')
                    ->where('cpf', $cpfLimpo)
                    ->first();

                // Se encontrou outro registro com o mesmo CPF
                if ($pessoaComCPF && $pessoaComCPF['pessoa_fisica_id'] != $post['pessoa_fisica_id']) {
                    $lError = true;
                    $errors['cpf'] = "O <b>CPF</b> já está cadastrado para outra pessoa.";
                } else {
                    $post['cpf'] = $cpfLimpo;
                }
            }
        } else {
            $post['cpf'] = null;
        }

        // Tratamento de visitante_id vazio
        if (empty($post['visitante_id'])) {
            $post['visitante_id'] = null;
        }

        // Remove campos desnecessários
        unset($post['action']);

        // Atualização
        if (!$lError) {
            if ($this->model->update($post)) {
                return Redirect::page($this->controller, ["msgSucesso" => "Pessoa física atualizada com sucesso."]);
            } else {
                $lError = true;
                $errors['geral'] = "Erro ao atualizar registro no banco de dados.";
            }
        }

        // Retorno com erros
        if ($lError) {
            Session::set('errors', $errors);
            Session::set("inputs", $post);
            return Redirect::page($this->controller . '/form/update/' . $post['pessoa_fisica_id']);
        }
    }

    /**
     * delete
     * Exclui pessoa física com verificação de dependências
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->request->getPost();

        // Validação básica
        if (empty($post['pessoa_fisica_id'])) {
            return Redirect::page($this->controller, [
                'msgError' => 'ID da pessoa não informado.'
            ]);
        }

        $pessoaId = $post['pessoa_fisica_id'];
        $pessoaFisicaModel = new PessoaFisicaModel();

        // Verifica se pessoa existe
        $pessoa = $pessoaFisicaModel->db
            ->table('pessoa_fisica')
            ->where('pessoa_fisica_id', $pessoaId)
            ->first();

        if (!$pessoa) {
            return Redirect::page($this->controller, [
                'msgError' => 'Pessoa física não encontrada.'
            ]);
        }

        // Verifica se tem usuário vinculado
        $usuario = $pessoaFisicaModel->db
            ->table('usuario')
            ->where('pessoa_fisica_id', $pessoaId)
            ->first();

        if ($usuario) {
            return Redirect::page($this->controller, [
                'msgError' => 'Não é possível excluir. Esta pessoa possui usuário vinculado (Login: ' . $usuario['login'] . '). Exclua o usuário primeiro.'
            ]);
        }

        // Verifica se tem currículo
        $curriculum = $pessoaFisicaModel->db
            ->table('curriculum')
            ->where('pessoa_fisica_id', $pessoaId)
            ->first();

        if ($curriculum) {
            return Redirect::page($this->controller, [
                'msgError' => 'Não é possível excluir. Esta pessoa possui currículo cadastrado. Exclua o currículo primeiro.'
            ]);
        }

        // Tenta excluir
        $deleted = $pessoaFisicaModel->db
            ->table('pessoa_fisica')
            ->where('pessoa_fisica_id', $pessoaId)
            ->delete();

        if ($deleted > 0) {
            return Redirect::page($this->controller, [
                'msgSucesso' => 'Pessoa física excluída com sucesso.'
            ]);
        } else {
            return Redirect::page($this->controller, [
                'msgError' => 'Erro ao excluir pessoa física.'
            ]);
        }
    }
}
