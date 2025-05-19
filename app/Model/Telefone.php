<?php 
namespace App\Model;

use Core\Library\ModelMain;
use PDO;

class Telefone extends ModelMain
{
    protected $table = 'telefone';
    protected $primaryKey = 'telefone_id';
    protected $useAutoIncrement = true;
    protected $allowedFild = [
        'estabelecimento_id',
        'usuario_id',
        'numero',
        'tipo',
    ];
    private $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function inserirTelefone($usuarioId)
    {
        $sqlTelefone = "INSERT INTO telefone (usuario_id, numero, tipo) VALUES (:usuario_id, :numero, :tipo)";
        $stmtTelefone = $this->conexao->prepare($sqlTelefone);
        $stmtTelefone->execute([
            ':usuario_id' => $usuarioId,
            ':numero' => '32999999999',
            ':tipo' => 'celular'
        ]);
    }
}
?>