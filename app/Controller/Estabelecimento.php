<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

use App\Model\EstabelecimentoModel;

class Estabelecimento extends ControllerMain
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->auxiliarConstruct();
        $this->loadHelper(['formHelper', 'tabela']);
        $this->validaNivelAcesso("G");
    }

    /**
     * index
     */
    public function index()
    {
        $estabelecimentoModel = new EstabelecimentoModel();

        $estabelecimentos = $estabelecimentoModel->db
            ->table('estabelecimento')
            ->select('estabelecimento.estabelecimento_id, 
                      estabelecimento.nome, 
                      estabelecimento.email,
                      estabelecimento.endereco,
                      estabelecimento.latitude,
                      estabelecimento.longitude,
                      usuario.usuario_id,
                      usuario.login,
                      usuario.tipo')
            ->join('usuario', 'estabelecimento.estabelecimento_id = usuario.estabelecimento_id', 'LEFT')
            ->orderBy('estabelecimento.estabelecimento_id', 'DESC')
            ->findAll();

        $estatisticas = [
            'total' => count($estabelecimentos),
            'com_usuario' => count(array_filter($estabelecimentos, fn($e) => !empty($e['usuario_id']))),
            'sem_usuario' => count(array_filter($estabelecimentos, fn($e) => empty($e['usuario_id']))),
            'com_email' => count(array_filter($estabelecimentos, fn($e) => !empty($e['email']))),
            'com_localizacao' => count(array_filter($estabelecimentos, fn($e) => !empty($e['latitude']) && !empty($e['longitude'])))
        ];

        $dados = [
            'estabelecimentos' => $estabelecimentos,
            'estatisticas' => $estatisticas
        ];

        return $this->loadView("sistema/listaEstabelecimento", $dados);
    }

    /**
     * form
     */
    public function form($action = null, $id = null)
    {
        if ($this->action == "insert") {
            $dados = [
                'estabelecimento_id' => '',
                'nome' => '',
                'email' => '',
                'endereco' => '',
                'latitude' => '',
                'longitude' => ''
            ];
        } else {
            $estabelecimentoModel = new EstabelecimentoModel();

            $dados = $estabelecimentoModel->db
                ->table('estabelecimento')
                ->where('estabelecimento_id', $id)
                ->first();

            if (!$dados) {
                return Redirect::page('estabelecimento', [
                    'msgError' => 'Estabelecimento não encontrado'
                ]);
            }
        }

        return $this->loadView("sistema/formEstabelecimento", $dados);
    }

    /**
     * insert
     */
    public function insert()
    {
        $post = $this->request->getPost();
        $lError = false;
        $errors = [];

        // Validação de nome
        if (empty($post['nome'])) {
            $lError = true;
            $errors['nome'] = "O campo <b>Nome</b> é obrigatório.";
        } else {
            $estabelecimentoModel = new EstabelecimentoModel();

            if ($estabelecimentoModel->verificaDuplicidadeNome($post['nome'])) {
                $lError = true;
                $errors['nome'] = "Já existe um estabelecimento com este <b>Nome</b>.";
            }
        }

        // Validação de email
        if (!empty($post['email'])) {
            if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                $lError = true;
                $errors['email'] = "O <b>Email</b> informado é inválido.";
            }
        } else {
            $post['email'] = null;
        }

        // Tratamento de campos vazios
        if (empty($post['endereco'])) {
            $post['endereco'] = null;
        }
        if (empty($post['latitude'])) {
            $post['latitude'] = null;
        }
        if (empty($post['longitude'])) {
            $post['longitude'] = null;
        }

        // Remove campos desnecessários
        unset($post['action']);
        if (isset($post['estabelecimento_id']) && empty($post['estabelecimento_id'])) {
            unset($post['estabelecimento_id']);
        }

        // Inserção
        if (!$lError) {
            if ($this->model->insert($post)) {
                return Redirect::page($this->controller, ["msgSucesso" => "Estabelecimento cadastrado com sucesso."]);
            } else {
                $lError = true;
                $errors['geral'] = "Erro ao inserir registro no banco de dados.";
            }
        }

        // Retorno com erros
        if ($lError) {
            $_POST['formErrors'] = $errors;
            Session::set("inputs", $post);
            return Redirect::page($this->controller . '/form/insert/0');
        }
    }

    /**
     * update
     */
    public function update()
    {
        $post = $this->request->getPost();
        $lError = false;
        $errors = [];

        // Validação de nome
        if (empty($post['nome'])) {
            $lError = true;
            $errors['nome'] = "O campo <b>Nome</b> é obrigatório.";
        } else {
            $estabelecimentoModel = new EstabelecimentoModel();

            if ($estabelecimentoModel->verificaDuplicidadeNome($post['nome'], $post['estabelecimento_id'])) {
                $lError = true;
                $errors['nome'] = "Já existe outro estabelecimento com este <b>Nome</b>.";
            }
        }

        // Validação de email
        if (!empty($post['email'])) {
            if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                $lError = true;
                $errors['email'] = "O <b>Email</b> informado é inválido.";
            }
        } else {
            $post['email'] = null;
        }

        // Tratamento de campos vazios
        if (empty($post['endereco'])) {
            $post['endereco'] = null;
        }
        if (empty($post['latitude'])) {
            $post['latitude'] = null;
        }
        if (empty($post['longitude'])) {
            $post['longitude'] = null;
        }

        // Remove campos desnecessários
        unset($post['action']);

        // Atualização
        if (!$lError) {
            if ($this->model->update($post)) {
                return Redirect::page($this->controller, ["msgSucesso" => "Estabelecimento atualizado com sucesso."]);
            } else {
                $lError = true;
                $errors['geral'] = "Erro ao atualizar registro no banco de dados.";
            }
        }

        // Retorno com erros
        if ($lError) {
            $_POST['formErrors'] = $errors;
            Session::set("inputs", $post);
            return Redirect::page($this->controller . '/form/update/' . $post['estabelecimento_id']);
        }
    }

    /**
     * delete
     */
    public function delete()
    {
        $post = $this->request->getPost();

        if (empty($post['estabelecimento_id'])) {
            return Redirect::page($this->controller, [
                'msgError' => 'ID do estabelecimento não informado.'
            ]);
        }

        $estabelecimentoId = $post['estabelecimento_id'];
        $estabelecimentoModel = new EstabelecimentoModel();

        // Verifica se existe
        $estabelecimento = $estabelecimentoModel->db
            ->table('estabelecimento')
            ->where('estabelecimento_id', $estabelecimentoId)
            ->first();

        if (!$estabelecimento) {
            return Redirect::page($this->controller, [
                'msgError' => 'Estabelecimento não encontrado.'
            ]);
        }

        // Verifica usuário vinculado
        $usuario = $estabelecimentoModel->db
            ->table('usuario')
            ->where('estabelecimento_id', $estabelecimentoId)
            ->first();

        if ($usuario) {
            return Redirect::page($this->controller, [
                'msgError' => 'Não é possível excluir. Este estabelecimento possui usuário vinculado (Login: ' . $usuario['login'] . '). Exclua o usuário primeiro.'
            ]);
        }

        // Verifica vagas
        $vagas = $estabelecimentoModel->db
            ->table('vaga')
            ->where('estabelecimento_id', $estabelecimentoId)
            ->findAll();

        if (count($vagas) > 0) {
            return Redirect::page($this->controller, [
                'msgError' => 'Não é possível excluir. Este estabelecimento possui ' . count($vagas) . ' vaga(s) cadastrada(s). Exclua as vagas primeiro.'
            ]);
        }

        // Exclui telefones
        $estabelecimentoModel->db
            ->table('telefone')
            ->where('estabelecimento_id', $estabelecimentoId)
            ->delete();

        // Exclui categorias
        $estabelecimentoModel->db
            ->table('categoria_estabelecimento')
            ->where('estabelecimento_id', $estabelecimentoId)
            ->delete();

        // Exclui estabelecimento
        $deleted = $estabelecimentoModel->db
            ->table('estabelecimento')
            ->where('estabelecimento_id', $estabelecimentoId)
            ->delete();

        if ($deleted > 0) {
            return Redirect::page($this->controller, [
                'msgSucesso' => 'Estabelecimento excluído com sucesso.'
            ]);
        } else {
            return Redirect::page($this->controller, [
                'msgError' => 'Erro ao excluir estabelecimento.'
            ]);
        }
    }
}
