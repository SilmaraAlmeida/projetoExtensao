<?php

namespace App\Controller;

use App\Model\UsuarioModel;
use Core\Library\ControllerMain;
use Core\Library\Email;
use Core\Library\Redirect;
use Core\Library\Session;

class Login extends ControllerMain
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->auxiliarConstruct();
        $this->loadHelper("formHelper");
        $this->model   = new UsuarioModel();
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return $this->loadView("login/login", []);
    }

    /**
     * signIn
     *
     * @return void
     */
    public function signIn()
    {
        $post  = $this->request->getPost();
        $login = trim($post['login'] ?? '');
        $senha = trim($post['senha'] ?? '');

        $aUser = $this->model->getUserLogin($login);

        if (empty($aUser)) {
            return Redirect::page("login", [
                "msgError" => 'Login ou senha inválido.',
                'inputs' => ["login" => $login]
            ]);
        }

        if (!password_verify($senha, $aUser['senha'])) {
            return Redirect::page("login", [
                "msgError" => 'Login ou senha inválido.',
                'inputs' => ["login" => $login]
            ]);
        }

        Session::set("userId", $aUser['usuario_id']);
        Session::set("userNome", $aUser['nome']);
        Session::set("userLogin", $aUser['login']);
        Session::set("userNivel", $aUser['tipo']);
        Session::set("userSenha", $aUser['senha']);

        return Redirect::page("sistema");
    }


    /**
     * signOut
     *
     * @return void
     */
    public function signOut()
    {
        Session::destroy('userId');
        Session::destroy('userNome');
        Session::destroy('userLogin');
        Session::destroy('userNivel');
        Session::destroy('userSenha');

        return Redirect::Page("home");
    }

    /**
     * formEsqueciASenha
     *
     * @return void
     */
    public function esqueciASenha()
    {
        return $this->loadView("login/esqueciASenha");
    }

    /**
     * esqueciASenhaEnvio
     *
     * @return void
     */
    public function esqueciASenhaEnvio()
    {
        $this->loadHelper("emailHelper");

        $post       = $this->request->getPost();
        $user       = $this->model->getUserLogin($post['login']);

        if (!$user) {

            return Redirect::page("Login/esqueciASenha", [
                "msgError" => "Não foi possivel localizar o e-mail na base de dados !;"
            ]);
        } else {

            $created_at = date('Y-m-d H:i:s');
            $chave      = sha1($user['usuario_id'] . $user['senha'] . date('YmdHis', strtotime($created_at)));
            $cLink      = baseUrl() . "login/recuperarSenha/" . $chave;
            $emailTexto = emailRecuperacaoSenha($cLink);

            $lRetMail = Email::enviaEmail(
                $_ENV['MAIL_USER'],                         /* Email do Remetente*/
                $_ENV['MAIL_NOME'],                         /* Nome do Remetente */
                $emailTexto['assunto'],                     /* Assunto do e-mail */
                $emailTexto['corpo'],                       /* Corpo do E-mail */
                $user['login']                              /* Destinatário do E-mail */
            );

            if ($lRetMail) {

                // Gravar o link no banco de dados
                $usuarioRecuperaSenhaModel = $this->loadModel("UsuarioRecuperaSenha");

                // Desativando solicitações antigas
                $usuarioRecuperaSenhaModel->desativaChaveAntigas($user["usuario_id"]);

                // Inserindo nova solicitação
                $resIns = $usuarioRecuperaSenhaModel->db->table('usuariorecuperasenha')->insert([
                    "usuario_id" => $user["usuario_id"],
                    "chave" => $chave,
                    "created_at" => $created_at
                ]);

                if ($resIns) {
                    return Redirect::page("login", [
                        "msgSucesso" => "Link para recuperação da senha enviado com sucesso! Verifique seu e-mail."
                    ]);
                } else {
                    return Redirect::page("login/esqueciASenha");
                }
            } else {
                return Redirect::page("login/esqueciASenha", ["inputs" => $post]);
            }
        }
    }
    /**
     * recuperarSenha
     *
     * @param string $chave 
     * @return void
     */
    public function recuperarSenha($chave)
    {
        $usuarioRecuperaSenhaModel  = $this->loadModel('UsuarioRecuperaSenha');
        $userChave                  = $usuarioRecuperaSenhaModel->getRecuperaSenhaChave($chave);

        if ($userChave) {

            if (date("Y-m-d H:i:s") <= date("Y-m-d H:i:s", strtotime("+1 hours", strtotime($userChave['created_at'])))) {

                $usuarioModel = $this->loadModel('Usuario');
                $user         = $usuarioModel->getUserId($userChave['usuario_id']);

                if ($user) {

                    $chaveRecSenha = sha1($userChave['usuario_id'] . $user['senha'] . date("YmdHis", strtotime($userChave['created_at'])));

                    if ($chaveRecSenha == $userChave['chave']) {

                        $dbDados = [
                            "usuario_id" => $user['usuario_id'],
                            'nome'       => $user['nome'],
                            'usuariorecuperasenha_id' => $userChave['id']
                        ];

                        Session::destroy("msgError");

                        // chave válida
                        return $this->loadView("login/recuperarSenha", $dbDados);
                    } else {
                        // Desativa chave
                        $upd = $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);

                        return Redirect::page("Login/esqueciASenha", [
                            "msgError" => "Link de recuperação da senha inválido."
                        ]);
                    }
                } else {

                    // Desativa chave
                    $upd = $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);

                    return Redirect::page("Login/esqueciASenha", [
                        "msgError" => "Usuário para o link de recuperação da senha não localizado."
                    ]);
                }
            } else {

                // Desativa chave
                $upd = $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);

                return Redirect::page("Login/esqueciASenha", [
                    "msgError" => "Link de recuperação da senha expirado."
                ]);
            }
        } else {
            return Redirect::page("Login/esqueciASenha", [
                "msgError" => "Link de recuperação da senha não localizado."
            ]);
        }
    }

    /**
     * atualizaRecuperaSenha
     *
     * @return void
     */
    public function atualizaRecuperaSenha()
    {
        $UsuarioModel = $this->loadModel("Usuario");

        $post       = $this->request->getPost();
        $userAtual  = $UsuarioModel->getUserId($post["usuario_id"]);

        if ($userAtual) {

            if (trim($post["NovaSenha"]) == trim($post["NovaSenha2"])) {

                // CORREÇÃO: usar 'usuario_id' ao invés de 'id'
                if ($UsuarioModel->db
                    ->table("usuario")
                    ->where(['usuario_id' => $post['usuario_id']])
                    ->update([
                        'senha' => password_hash(trim($post["NovaSenha"]), PASSWORD_DEFAULT)
                    ])
                ) {

                    // Desativa chave
                    $usuarioRecuperaSenhaModel = $this->loadModel('UsuarioRecuperaSenha');
                    $upd = $usuarioRecuperaSenhaModel->desativaChave($post['usuariorecuperasenha_id']);

                    Session::destroy("msgError");
                    return Redirect::page("Login", [
                        "msgSucesso" => "Senha atualizada com sucesso!"
                    ]);
                } else {
                    Session::set("msgError", "Erro ao atualizar senha na base de dados!");
                    return $this->loadView("login/recuperarSenha", $post);
                }
            } else {
                Session::set("msgError", "Nova senha e conferência da senha estão divergentes!");
                return $this->loadView("login/recuperarSenha", $post);
            }
        } else {
            Session::set("msgError", "Usuário inválido!");
            return $this->loadView("login/recuperarSenha", $post);
        }
    }

    //     /**
    //      * criaSuperUser
    //      *
    //      * @return void
    //      */
    //     public function criaSuperUser()
    //     {
    //         $dados = [
    //             "tipo"             => "G",
    //             "nome"              => "Admin",
    //             "login"             => "suadmin@admin.com.br",
    //             "senha"             => password_hash("fasm@2025", PASSWORD_DEFAULT),
    //         ];

    //         $aSuperUser = $this->model->getUserLogin($dados['email']);

    //         if (count($aSuperUser) > 0) {
    //             return Redirect::Page("login", ["msgError" => "Login já existe."]);
    //         } else {
    //             if ($this->model->insert($dados)) {
    //                 return Redirect::Page("login", ["msgSucesso" => "Login criado com sucesso."]);
    //             } else {
    //                 return Redirect::Page("login");
    //             }
    //         }
    //     }
}
