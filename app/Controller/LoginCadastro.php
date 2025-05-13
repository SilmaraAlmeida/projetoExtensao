<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use PDO;
use PDOException;

class LoginCadastro extends ControllerMain
{
    public function index()
    {
        return view('comuns/loginRegistro/login');
    }

    public function registrar()
    {
        $nome  = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $cpf   = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        try {
            $conexao = new PDO('mysql:host=localhost;dbname=descubra_muriae', 'root', '');
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $conexao->beginTransaction();

            // Inserir na tabela pessoa_fisica
            $sqlPessoaFisica = "INSERT INTO pessoa_fisica (nome, cpf) VALUES (:nome, :cpf)";
            $stmtPessoaFisica = $conexao->prepare($sqlPessoaFisica);
            $stmtPessoaFisica->execute([':nome' => $nome, ':cpf' => $cpf]);

            $pessoaFisicaId = $conexao->lastInsertId();

            // verifica se já tem um cadastro com esse e-mail
            $queryCheck = "SELECT COUNT(*) FROM usuario WHERE login = :email";
            $stmtCheck = $conexao->prepare($queryCheck);
            $stmtCheck->execute([':email' => $email]);
            if ($stmtCheck->fetchColumn() > 0) {
                echo "E-mail já cadastrado";
                return;
            }
            
            // Inserir na tabela usuario
            $sqlUsuario = "INSERT INTO usuario (pessoa_fisica_id, login, senha, tipo) VALUES (:pessoa_fisica_id, :login, :senha, :tipo)";
            $stmtUsuario = $conexao->prepare($sqlUsuario);
            $stmtUsuario->execute([
                ':pessoa_fisica_id' => $pessoaFisicaId,
                ':login' => $email,
                ':senha' => $senha,
                ':tipo' => 'usuario'
            ]);

            $usuarioId = $conexao->lastInsertId();

            // inseriri no telefone
            // $sqlTelefone = "INSERT INTO telefone (usuario_id, numero, tipo) VALUES (:usuario_id, :numero, :tipo)";
            // $stmtTelefone = $conexao->prepare($sqlTelefone);
            // $stmtTelefone->execute([
            //     ':usuario_id' => $usuarioId,
            //     ':numero' => '32999999999',
            //     ':tipo' => 'celular'
            // ]);

            // Inserir no termodeuso
            $sqlTermo = "INSERT INTO termodeuso (textoTermo, statusRegistro, rascunho, usuario_id) 
                        VALUES (:textoTermo, :statusRegistro, :rascunho, :usuario_id)";
            $stmtTermo = $conexao->prepare($sqlTermo);
            $stmtTermo->execute([
                ':textoTermo' => 'Texto do termo',
                ':statusRegistro' => 1,
                ':rascunho' => 0,
                ':usuario_id' => $usuarioId
            ]);

            $termoDeUsoId = $conexao->lastInsertId();

            // inserir no temodeusoaceite
            $sqlAceite = "INSERT INTO termodeusoaceite (termodeuso_id, usuario_id, dataHoraAceite)
                        VALUES (:termodeuso_id, :usuario_id, NOW())";
            $stmtAceite = $conexao->prepare($sqlAceite);
            $stmtAceite->execute([
                ':termodeuso_id' => $termoDeUsoId,
                ':usuario_id' => $usuarioId
            ]);

            $conexao->commit();

            echo "Usuário registrado com sucesso.";
        } catch (PDOException $e) {
            $conexao->rollBack();
            echo "Erro ao registrar: " . $e->getMessage();
        }
    }

    public function login()
    {

        $conexao = new PDO('mysql:host=localhost;dbname=descubra_muriae', 'root', '');

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senhaDigitada = $_POST['senha'];

        $getHash = "SELECT senha FROM usuario WHERE login = :email";
        $validarHash = $conexao->prepare($getHash);
        $validarHash->execute([
            ':email' => $email,
        ]);

        $resultado = $validarHash->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($senhaDigitada, $resultado['senha'])) {
            var_dump('Logado');
        } else {
            var_dump("não foi possível logar");
        }

    }
}
