<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

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
     *
     * @return void
     */
    public function index()
    {
        return $this->loadView("sistema/listaPessoaFisica", $this->model->lista("pessoa_fisica_id"));
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
            $dados = [];
        } else {
            $dados = $this->model->getUserId($id);
        }

        return $this->loadView("sistema/formPessoaFisica", $dados);
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

        // Validação de CPF se preenchido
        if (!empty($post['cpf'])) {
            if (!$this->model->validarCPF($post['cpf'])) {
                $lError = true;
                $errors['cpf'] = "O <b>CPF</b> informado é inválido.";
                Session::set('errors', $errors);
            } else {
                // Remove caracteres não numéricos para salvar no banco
                $post['cpf'] = preg_replace('/\D/', '', $post['cpf']);
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
            return Redirect::page($this->controller . '/form/' . $post['action'] . '/' . $post['pessoa_fisica_id']);
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

        // Validação de CPF se preenchido
        if (!empty($post['cpf'])) {
            if (!$this->model->validarCPF($post['cpf'])) {
                $lError = true;
                $errors['cpf'] = "O <b>CPF</b> informado é inválido.";
                Session::set('errors', $errors);
            } else {
                // Remove caracteres não numéricos para salvar no banco
                $post['cpf'] = preg_replace('/\D/', '', $post['cpf']);
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
            return Redirect::page($this->controller . '/form/' . $post['action'] . '/' . $post['pessoa_fisica_id']);
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
        
        if ($this->model->delete(["pessoa_fisica_id" => $post['pessoa_fisica_id']])) {
            return Redirect::page($this->controller, ['msgSucesso' => "Registro excluído com sucesso."]);
        } else {
            return Redirect::page($this->controller, ["msgError" => "Falha ao excluir os dados na base de dados."]);
        }
    }
}
