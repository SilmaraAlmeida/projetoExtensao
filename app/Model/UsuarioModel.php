<?php 
namespace App\Model;

use Core\Library\ModelMain;
use PDO;

class UsuarioModel extends ModelMain
{
    protected $table = 'usuario';
    protected $primaryKey = 'usuario_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'pessoa_fisica_id',
        'login',
        'senha',
        'tipo',
    ];
    private $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function emailJaExiste($email)
    {
        $queryCheck = "SELECT COUNT(*) FROM usuario WHERE login = :email";
        $stmtCheck = $this->conexao->prepare($queryCheck);
        $stmtCheck->execute([':email' => $email]);
        return $stmtCheck->fetchColumn() == 0;
    }

    public function inserirUsuario($pessoaFisicaId, $email, $senha)
    {
        $sqlUsuario = "INSERT INTO usuario (pessoa_fisica_id, login, senha, tipo) VALUES (:pessoa_fisica_id, :login, :senha, :tipo)";
        $stmtUsuario = $this->conexao->prepare($sqlUsuario);
        $stmtUsuario->execute([
            ':pessoa_fisica_id' => $pessoaFisicaId,
            ':login' => $email,
            ':senha' => $senha,
            ':tipo' => 'usuario'
        ]);

        return $this->conexao->lastInsertId();
    }

    public function getHash($email)
    {
        $getHash = "SELECT senha FROM usuario WHERE login = :email";
        $validarHash = $this->conexao->prepare($getHash);
        $validarHash->execute([
            ':email' => $email,
        ]);

        return $validarHash;
    }
}
?>