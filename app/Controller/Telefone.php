<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Telefone extends ControllerMain
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->auxiliarConstruct();
        $this->loadHelper(['formHelper', 'tabela']);
        $this->validaNivelAcesso("A");                     // Valida nível de acesso Anunciante ou superior
    }
    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return $this->loadView("sistema/listaTelefone", $this->model->listaTelefone());
    }

    /**
     * form
     *
     * @param string $action 
     * @param integer $id 
     * @return void
     */
    public function form($action = null, $id = null)
    {
        if ($this->action == "insert") {
            $dados = [
                "tipo" => "m" // Padrão móvel
            ];
        } else {
            $dados = $this->model->getTelefoneById($id);
        }

        // Buscar estabelecimentos para o select
        $dados['estabelecimentos'] = $this->model->db->table('estabelecimento')
            ->select('estabelecimento_id, nome')
            ->orderBy('nome', 'ASC')
            ->findAll();

        // Buscar usuários para o select
        $dados['usuarios'] = $this->model->db->table('usuario')
            ->select('usuario.usuario_id, pessoa_fisica.nome')
            ->join('pessoa_fisica', 'usuario.pessoa_fisica_id = pessoa_fisica.pessoa_fisica_id', 'INNER')
            ->orderBy('pessoa_fisica.nome', 'ASC')
            ->findAll();

        return $this->loadView("sistema/formTelefone", $dados);
    }

    /**
     * insert
     *
     * @return void
     */
    public function insert()
    {        
        $post = $this->request->getPost();
        $lError = false;

        // Validação: deve ter pelo menos estabelecimento_id OU usuario_id
        if (empty($post['estabelecimento_id']) && empty($post['usuario_id'])) {
            $lError = true;
            $errors['vinculo'] = "Deve ser informado pelo menos um <b>Estabelecimento</b> ou <b>Usuário</b>.";
            Session::set('errors', $errors);
        }

        // Limpar campos vazios para evitar erro de FK
        if (empty($post['estabelecimento_id'])) {
            $post['estabelecimento_id'] = null;
        }
        if (empty($post['usuario_id'])) {
            $post['usuario_id'] = null;
        }

        // Validação e formatação do número
        if (!empty($post['numero'])) {
            $numero = preg_replace('/\D/', '', $post['numero']);
            if (strlen($numero) < 10 || strlen($numero) > 11) {
                $lError = true;
                $errors['numero'] = "O <b>Número</b> deve ter entre 10 e 11 dígitos.";
                Session::set('errors', $errors);
            } else {
                $post['numero'] = $numero;
            }
        }

        if (!$lError) {
            if ($this->model->insert($post)) {
                return Redirect::page($this->controller, ["msgSucesso" => "Registro inserido com sucesso."]);
            } else {
                $lError = true;
            }    
        }
        
        if ($lError) {
            Session::set("inputs", $post);
            return Redirect::page($this->controller . '/form/' . ($post['action'] ?? 'insert') . '/' . ($post['telefone_id'] ?? '0'));
        }
    }

    /**
     * update
     *
     * @return void
     */
    public function update()
    {        
        $post = $this->request->getPost();
        $lError = false;

        // Validação: deve ter pelo menos estabelecimento_id OU usuario_id
        if (empty($post['estabelecimento_id']) && empty($post['usuario_id'])) {
            $lError = true;
            $errors['vinculo'] = "Deve ser informado pelo menos um <b>Estabelecimento</b> ou <b>Usuário</b>.";
            Session::set('errors', $errors);
        }

        // Limpar campos vazios para evitar erro de FK
        if (empty($post['estabelecimento_id'])) {
            $post['estabelecimento_id'] = null;
        }
        if (empty($post['usuario_id'])) {
            $post['usuario_id'] = null;
        }

        // Validação e formatação do número
        if (!empty($post['numero'])) {
            $numero = preg_replace('/\D/', '', $post['numero']);
            if (strlen($numero) < 10 || strlen($numero) > 11) {
                $lError = true;
                $errors['numero'] = "O <b>Número</b> deve ter entre 10 e 11 dígitos.";
                Session::set('errors', $errors);
            } else {
                $post['numero'] = $numero;
            }
        }

        if (!$lError) {
            if ($this->model->update($post)) {
                return Redirect::page($this->controller, ["msgSucesso" => "Registro atualizado com sucesso."]);
            } else {
                $lError = true;
            }    
        }
        
        if ($lError) {
            Session::set("inputs", $post);
            return Redirect::page($this->controller . '/form/' . ($post['action'] ?? 'update') . '/' . ($post['telefone_id'] ?? '0'));
        }
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->request->getPost();
        
        if ($this->model->delete(["telefone_id" => $post['telefone_id']])) {
            return Redirect::page($this->controller, ['msgSucesso' => "Registro excluído com sucesso."]);
        } else {
            return Redirect::page($this->controller, ["msgError" => "Falha ao excluir os dados na base de dados."]);
        }
    }
}
