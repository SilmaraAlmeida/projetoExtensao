<?php 
namespace App\Model;

use Core\Library\ModelMain;
use PDO;

class PessoaFisica extends ModelMain
{
    protected $table = 'pessoa_fisica';
    protected $primaryKey = 'pessoa_fisica_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'nome',
        'cpf',
        'visitente_id'
    ];
    private $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function inserirPessoaFisica($nome, $cpf)
    {
        $sqlPessoaFisica = "INSERT INTO pessoa_fisica (nome, cpf) VALUES (:nome, :cpf)";
        $stmtPessoaFisica = $this->conexao->prepare($sqlPessoaFisica);
        $stmtPessoaFisica->execute([
            ':nome' => $nome, ':cpf' => $cpf
        ]);

        return $this->conexao->lastInsertId();
    }

    public function getNomeUsuario($email)
    {
        $getUsuario = "SELECT pessoa_fisica.nome, usuario.login
                    FROM usuario
                    INNER JOIN pessoa_fisica ON usuario.pessoa_fisica_id = pessoa_fisica.pessoa_fisica_id
                    WHERE usuario.login = :email";
        
        $buscar = $this->conexao->prepare($getUsuario);
        $buscar->execute([
            ':email' => $email,
        ]);

        $resultado = $buscar->fetch(PDO::FETCH_ASSOC);

        if ($resultado && isset($resultado['nome'])) {
            return $resultado['nome'];
        }

        return null;
    }
}
?>