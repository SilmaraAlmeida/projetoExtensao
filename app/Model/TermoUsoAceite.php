<?php 
namespace App\Model;

use Core\Library\ModelMain;
use PDO;

class TermoUsoAceite extends ModelMain
{
    protected $table = 'termodeusoaceite';
    protected $primaryKey = 'termodeuso_id';
    protected $useAutoIncrement = true;
    protected $allowedFiels = [
        'usuario_id',
        'dataHoraAceite',
    ];
    private $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function inserirTermoUsoAceite($termoDeUsoId, $usuarioId)
    {
        $sqlAceite = "INSERT INTO termodeusoaceite (termodeuso_id, usuario_id, dataHoraAceite)
            VALUES (:termodeuso_id, :usuario_id, NOW())";
        $stmtAceite = $this->conexao->prepare($sqlAceite);
        $stmtAceite->execute([
            ':termodeuso_id' => $termoDeUsoId,
            ':usuario_id' => $usuarioId
        ]);
    }
}
?>