<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Usuario extends ControllerMain
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
        return $this->loadView("sistema/listaUsuario", $this->model->listaUsuario("usuario_id"));
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
                "tipo" => "CN",
                "trocarSenha" => "S",
            ];
        } else {
            $dados = $this->model->getUserId($id);
        }

        // Adiciona lista de pessoas físicas para o select
        $dados['usuarios'] = $this->model->getUsuariosSelect();

        return $this->loadView("sistema/formUsuario", $dados);
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

        if (empty($post['senha'])) {
            $lError = true;
            $errors['senha'] = "O campo <b>Senha</b> deve ser preenchido.";
            Session::set('errors', $errors);
        } else {
            unset($post['confSenha']);
            $post['senha'] = password_hash($post['senha'], PASSWORD_DEFAULT);
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
            return Redirect::page($this->controller . '/form/' . $post['action'] . '/' . $post['usuario_id']);
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

        unset($post['confSenha']);

        if (empty($post['senha'])) {
            unset($post['senha']);
        } else {
            $post['senha'] = password_hash($post['senha'], PASSWORD_DEFAULT);
        }

        if (!$lError) {
            if ($this->model->update($post)) {
                return Redirect::page($this->controller, ["msgSucesso" => "Registro atualizado com sucesso."]);
            } else {
                $lError = true;
            }
        } else {
            Session::set("inputs", $post);
            return Redirect::page($this->controller . '/form/' . $post['action'] . '/' . $post['id']);
        }
    }

    /**
     * delete
     *
     * @return void
     */
    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->request->getPost();

        $resultado = $this->model->deletarComDependencias($post['usuario_id']);

        if ($resultado['sucesso']) {
            return Redirect::page($this->controller, ['msgSucesso' => $resultado['mensagem']]);
        } else {
            return Redirect::page($this->controller, ['msgError' => $resultado['mensagem']]);
        }
    }


    /**
     * formTrocarSenha
     *
     * @return void
     */
    public function formTrocarSenha()
    {
        return $this->loadView("sistema/formTrocaSenha");
    }

    /**
     * updateNovaSenha
     *
     * @return void
     */
    public function updateNovaSenha()
    {
        $post = $this->request->getPost();
        $userAtual = $this->model->getById($post["usuario_id"]);

        if ($userAtual) {
            if (password_verify(trim($post["senhaAtual"]), $userAtual['senha'])) {
                if (trim($post["novaSenha"]) == trim($post["novaSenha2"])) {
                    $novaSenhaCripyt = password_hash(trim($post["novaSenha"]), PASSWORD_DEFAULT);

                    $lUpdate = $this->model->db->where(['usuario_id' => $post['usuario_id']])->update([
                        'senha' => $novaSenhaCripyt
                    ]);

                    if ($lUpdate) {
                        Session::set("userSenha", $novaSenhaCripyt);
                        return Redirect::page("Usuario/formTrocarSenha", [
                            "msgSucesso" => "Senha alterada com sucesso !"
                        ]);
                    } else {
                        return Redirect::page("Usuario/formTrocarSenha");
                    }
                } else {
                    return Redirect::page("Usuario/formTrocarSenha", [
                        "msgError" => "Nova senha e conferência da senha estão divergentes !"
                    ]);
                }
            } else {
                return Redirect::page("Usuario/formTrocarSenha", [
                    "msgError" => "Senha atual informada não confere!"
                ]);
            }
        } else {
            return Redirect::page("Usuario/formTrocarSenha", [
                "msgError" => "Usuário inválido !"
            ]);
        }
    }
}
