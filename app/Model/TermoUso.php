<?php 
namespace App\Model;

use Core\Library\ModelMain;
use PDO;

class TermoUso extends ModelMain
{
    protected $table = 'termodeuso';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'textoTermo',
        'statusRegistro',
        'rascunho',
        'usuario_id',
    ];
    private $conexao;

    public function __construct(PDO $conexao)
    {  
       $this->conexao = $conexao; 
    }

    public function inserirTermoUso($usuarioId)
    {
        $sqlTermo = "INSERT INTO termodeuso (textoTermo, statusRegistro, rascunho, usuario_id) 
            VALUES (:textoTermo, :statusRegistro, :rascunho, :usuario_id)";
        $stmtTermo = $this->conexao->prepare($sqlTermo);
        $stmtTermo->execute([
            ':textoTermo' => 'Texto do termo',
            ':statusRegistro' => 1,
            ':rascunho' => 0,
            ':usuario_id' => $usuarioId
        ]);
    }
}
?>