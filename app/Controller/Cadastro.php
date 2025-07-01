<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Session;
use Core\Library\Redirect;
use App\Model\CadastroModel;

class Cadastro extends ControllerMain
{
    public $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new CadastroModel();
    }

    public function index()
    {
        $this->loadView('login/cadastro');
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
            if ($this->model->verificarEmailExistente($post['email'])) {
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
                    if ($this->model->verificarCpfExistente($cpf)) {
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

        // Validação do tipo de telefone (padrão móvel se não informado)
        $tipoTelefone = !empty($post['tipoTelefone']) && in_array($post['tipoTelefone'], ['m', 'f']) ? $post['tipoTelefone'] : 'm';

        if ($lError) {
            Session::set('errors', $errors);
            Session::set('inputs', $post);
            return Redirect::page("Cadastro/form");
        }

        // 1. Inserir na tabela pessoa_fisica
        $dadosPessoaFisica = [
            'nome' => $post['nome'],
            'cpf' => $post['cpf']
        ];
        
        $pessoaFisicaId = $this->model->inserirPessoaFisica($dadosPessoaFisica);
        if (!$pessoaFisicaId) {
            Session::set('msgError', 'Erro ao criar conta. Tente novamente.');
            return Redirect::page("Cadastro/form");
        }

        // 2. Inserir na tabela usuario
        $dadosUsuario = [
            'pessoa_fisica_id' => $pessoaFisicaId,
            'login' => $post['email'],
            'senha' => $post['senha'],
            'tipo' => 'CN' // A = Anunciante
        ];
        
        $usuarioId = $this->model->inserirUsuario($dadosUsuario);
        if (!$usuarioId) {
            Session::set('msgError', 'Erro ao criar conta. Tente novamente.');
            return Redirect::page("Cadastro/form");
        }

        // 3. Inserir na tabela telefone
        $dadosTelefone = [
            'usuario_id' => $usuarioId,
            'numero' => $post['telefone'],
            'tipo' => $tipoTelefone
        ];
        
        if (!$this->model->inserirTelefone($dadosTelefone)) {
            Session::set('msgError', 'Erro ao criar conta. Tente novamente.');
            return Redirect::page("Cadastro/form");
        }

        // 4. Registrar aceite dos termos de uso (se aceitos)
        if (!empty($post['termos'])) {
            $termoAtivo = $this->model->buscarTermoUsoAtivo();
            if ($termoAtivo) {
                $dadosAceite = [
                    'termodeuso_id' => $termoAtivo['termodeuso_id'],
                    'usuario_id' => $usuarioId,
                    'dataHoraAceite' => date('Y-m-d H:i:s')
                ];
                
                $this->model->inserirAceiteTermoUso($dadosAceite);
            }
        }

        Session::set('msgSucesso', 'Conta criada com sucesso! Faça login para continuar.');
        return Redirect::page("Login");
    }
}
