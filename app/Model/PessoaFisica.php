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
}

?>