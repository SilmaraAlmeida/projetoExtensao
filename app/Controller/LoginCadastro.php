<?php
namespace App\Controller;

use App\Model\PessoaFisica;
use App\Model\Telefone;
use App\Model\TermoUso;
use App\Model\TermoUsoAceite;
use App\Model\UsuarioModel;
use Core\Library\ControllerMain;
use PDO;
use PDOException;

class LoginCadastro extends ControllerMain
{
    private $conexao;
    private $pessoaFisica;

    public function __construct()
    {
        $this->loadHelper('utilits');
        $this->conexao = new PDO('mysql:host=localhost;dbname=descubra_muriae', 'root', '');
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);      
        
        $this->pessoaFisica = new PessoaFisica($this->conexao);
    }

    public function index()
    {
        return $this->loadView('loginRegistro/login', [], false);
    }

    public function registrar()
    {
        $nome  = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cpf   = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        try {
            $this->conexao->beginTransaction();

            $usuario = new UsuarioModel($this->conexao);
            $termoUso = new TermoUso($this->conexao);
            $termoDeUsoAceite = new TermoUsoAceite($this->conexao);
            $telefone = new Telefone($this->conexao);

            $this->pessoaFisica->inserirPessoaFisica($nome, $cpf);
            $pessoaFisicaId = $this->conexao->lastInsertId();

            if ($usuario->emailJaExiste($email)) {
                $usuarioId = $usuario->inserirUsuario($pessoaFisicaId, $email, $senha);
                echo 'Usuário inserido com sucesso';

                $termoUso->inserirTermoUso($usuarioId);
                $termoDeUsoAceite->inserirTermoUsoAceite($this->conexao->lastInsertId(), $usuarioId);
                $telefone->inserirTelefone($usuarioId);

                $this->conexao->commit();
                echo "Usuário registrado com sucesso.";
            } else {
                $this->conexao->rollBack();
                echo 'E-mail já cadastrado';
            }
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            echo "Erro ao registrar: " . $e->getMessage();
        }
    }

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
