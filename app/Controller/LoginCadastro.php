<?php
namespace App\Controller;

use App\Model\Estabelecimento;
use App\Model\PessoaFisica;
use App\Model\Telefone;
use App\Model\TermoUso;
use App\Model\TermoUsoAceite;
use App\Model\UsuarioModel;
use Core\Library\ControllerMain;
use Exception;
use PDO;
use PDOException;

class LoginCadastro extends ControllerMain
{
    private $conexao;
    private $pessoaFisica;
    private $usuario;

    public function __construct()
    {
        $this->loadHelper('utilits');
        $this->conexao = new PDO('mysql:host=localhost;dbname=descubra_muriae', 'root', '');
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);      
        
        $this->pessoaFisica = new PessoaFisica($this->conexao);
        $this->usuario = new UsuarioModel($this->conexao);

    }

    public function index()
    {
        return $this->loadView('loginRegistro/login', [], false);
    }

    // lógica de inserção tanto de empresa quanto de candidato funcionando
    public function registrar()
    {
        $tipoRegistro = $_POST['tipoRegistro'];
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cnpj = filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        try {
            $this->conexao->beginTransaction();

            if ($tipoRegistro === 'candidato') {
                $_SESSION['tipoRegistro'] = $tipoRegistro;
                
                $termoUso = new TermoUso($this->conexao);
                $termoDeUsoAceite = new TermoUsoAceite($this->conexao);
                $telefone = new Telefone($this->conexao);
                
                $this->pessoaFisica->inserirPessoaFisica($nome, $cpf);
                $pessoaFisicaId = $this->conexao->lastInsertId();
                
                if (!$this->usuario->emailJaExiste($email)) {
                    $usuarioId = $this->usuario->inserirUsuario($pessoaFisicaId, $email, $senha);
                    echo 'Usuário inserido com sucesso';
                    
                    $termoUso->inserirTermoUso($usuarioId);
                    $termoDeUsoAceite->inserirTermoUsoAceite($this->conexao->lastInsertId(), $usuarioId);
                    $telefone->inserirTelefone($usuarioId);
                    
                    $this->conexao->commit();
                    echo "Usuário registrado com sucesso.";
                } else {
                    echo 'E-mail já cadastrado';
                    $this->conexao->rollBack();
                }

            } elseif ($tipoRegistro === 'empresa') {
                $_SESSION['tipoRegistro'] = $tipoRegistro;
                $estabelecimento = new Estabelecimento($this->conexao);

                if ($this->usuario->emailJaExiste($email)) {
                    echo "E-mail já cadastrado";
                } else {

                    $sucesso = $estabelecimento->inserirEmpresa($nome, $cnpj, $email);
                    $this->conexao->commit();
                    
                    if ($sucesso) {
                        echo "Empresa inserida com sucesso";
                    } else {
                        $this->conexao->rollBack();
                        echo "Erro ao inserir empresa";
                    }
                }

                return $this->loadView('loginRegistro/login', [], false);
            }
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            echo "Erro ao registrar: " . $e->getMessage();
        }
    }
    // a tabela de estabelecimento deveria ter uma parte dedicada para
    // login, senha, cnpj ..., já q na tabela 'usuario', tem o campo pessoa_fisica
    // que é direcionado a uma pessoa com cpf

    // como serão dois tipos de login (candidato e empresa), senti a necessidade
    // de mais informações sobre o estabelecimento/empresa

    // falta implemetar o login da empresa
    // (discutir a respeito das tabelas 'usuario' e 'estabelecimento')
    public function login()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senhaDigitada = $_POST['senha'];

        $usuario = new UsuarioModel($this->conexao);

        $resultado = $usuario->getHash($email)->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($senhaDigitada, $resultado['senha'])) {
            $_SESSION['nomeUsuario'] = $this->pessoaFisica->getNomeUsuario($email);

            return $this->loadView('portalUsuario/homePortal', [], true);
        } else {
            var_dump("não foi possível logar");
        }
    }

    public function deslogar() {
        if (isset($_SESSION['nomeUsuario'])) {
            unset($_SESSION['nomeUsuario']);
        }
        session_destroy();

        return $this->loadView('loginRegistro/login', [], false);
    }
}
