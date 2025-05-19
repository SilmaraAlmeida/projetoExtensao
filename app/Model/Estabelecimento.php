<?php 
namespace App\Model;

use Core\Library\ModelMain;
use PDO;

class Estabelecimento extends ModelMain
{
    protected $table = 'estabelecimento';
    protected $primaryKey = 'estabelecimento_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'nome',
        'endereco',
        'latitude',
        'longtude',
        'email',
    ];
    private $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function inserirEmpresa($nome, $cnpj, $email) {
        $sqlEstabelecimento = "INSERT INTO estabelecimento (nome, endereco, latitude, longitude, email) VALUES (:nome, :endereco, :latitude, :longitude, :email)";
        $stmtEstabelecimento = $this->conexao->prepare($sqlEstabelecimento);
        $stmtEstabelecimento->execute([
            ':nome' => $nome,
            ':endereco' => 'endereço',
            ':latitude' => 'latitude',
            ':longitude' => 'longitude',
            ':email' => $email,
        ]);

        return $this->conexao->lastInsertId();
    }
}
?>