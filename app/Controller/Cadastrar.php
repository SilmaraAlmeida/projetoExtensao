<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Cadastrar extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    /**
     * cadastro
     *
     * @return void
     */
    public function cadastro()
    {
        return $this->loadView("Login/cadastro");
    }

    /**
     * cadastroUsuario
     *
     * @return void
     */
    public function cadastroUsuario()
    {
        $post = $this->request->getPost();
        $lError = false;
        $errors = [];

        // Validação de nome
        if (empty($post['nome']) || strlen($post['nome']) < 3) {
            $lError = true;
            $errors['nome'] = "O nome deve ter pelo menos 3 caracteres.";
        }

        // Validação de email
        if (empty($post['email']) || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $lError = true;
            $errors['email'] = "Email inválido.";
        } else {
            // Verificar se email já existe
            $emailExistente = $this->model->getUserLogin($post['email']);
            if ($emailExistente) {
                $lError = true;
                $errors['email'] = "Este email já está cadastrado.";
            }
        }

        // Validação de telefone
        if (empty($post['telefone'])) {
            $lError = true;
            $errors['telefone'] = "O telefone é obrigatório.";
        } else {
            $telefone = preg_replace('/\D/', '', $post['telefone']);
            if (strlen($telefone) < 10 || strlen($telefone) > 11) {
                $lError = true;
                $errors['telefone'] = "Telefone deve ter 10 ou 11 dígitos.";
            } else {
                $post['telefone'] = $telefone;
            }
        }

        // Validação e formatação do CPF (opcional)
        if (!empty($post['cpf'])) {
            $cpf = preg_replace('/\D/', '', $post['cpf']);
            if (strlen($cpf) !== 11) {
                $lError = true;
                $errors['cpf'] = "CPF deve ter 11 dígitos.";
            } elseif (preg_match('/(\d)\1{10}/', $cpf)) {
                $lError = true;
                $errors['cpf'] = "CPF inválido.";
            } else {
                // Validação completa do CPF
                $validCpf = true;
                for ($t = 9; $t < 11; $t++) {
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf[$c] * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf[$c] != $d) {
                        $validCpf = false;
                        break;
                    }
                }
                if (!$validCpf) {
                    $lError = true;
                    $errors['cpf'] = "CPF inválido.";
                } else {
                    // Verificar se CPF já existe
                    $cpfExistente = $this->model->db->where('cpf', $cpf)->first();
                    if ($cpfExistente) {
                        $lError = true;
                        $errors['cpf'] = "Este CPF já está cadastrado.";
                    } else {
                        $post['cpf'] = $cpf;
                    }
                }
            }
        } else {
            $post['cpf'] = null;
        }

        // Validação da data de nascimento
        if (!empty($post['dataNascimento'])) {
            $data = \DateTime::createFromFormat('Y-m-d', $post['dataNascimento']);
            if (!$data || $data->format('Y-m-d') !== $post['dataNascimento']) {
                $lError = true;
                $errors['dataNascimento'] = "Data de nascimento inválida.";
            } elseif ($data > new \DateTime()) {
                $lError = true;
                $errors['dataNascimento'] = "Data de nascimento não pode ser futura.";
            }
        } else {
            $post['dataNascimento'] = null;
        }

        // Validação de senha
        if (empty($post['senha']) || strlen($post['senha']) < 7) {
            $lError = true;
            $errors['senha'] = "A senha deve ter pelo menos 7 caracteres.";
        } elseif ($post['senha'] !== $post['confSenha']) {
            $lError = true;
            $errors['confSenha'] = "A confirmação da senha não confere.";
        } else {
            $post['senha'] = password_hash($post['senha'], PASSWORD_DEFAULT);
            unset($post['confSenha']);
        }

        // Validação dos termos
        if (empty($post['termos'])) {
            $lError = true;
            $errors['termos'] = "Você deve aceitar os termos de uso.";
        }
        unset($post['termos']);

        // Definir valores padrão para cliente
        $post['nivel'] = 2; // Cliente
        $post['statusRegistro'] = 1; // Ativo

        if ($lError) {
            Session::set('errors', $errors);
            Session::set("inputs", $post);
            return Redirect::page("Login/cadastro");
        }

        // Inserir usuário
        if ($this->model->insert($post)) {
            return Redirect::page("Login", [
                "msgSucesso" => "Conta criada com sucesso! Faça login para continuar."
            ]);
        } else {
            return Redirect::page("Login/cadastro", [
                "msgError" => "Erro ao criar conta. Tente novamente."
            ]);
        }
    }
}