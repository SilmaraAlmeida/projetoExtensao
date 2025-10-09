<?php

namespace App\Model;

use Core\Library\ModelMain;

class EstabelecimentoModel extends ModelMain
{
    protected $table = "estabelecimento";
    protected $primaryKey = "estabelecimento_id";

    public $validationRules = [
        "nome" => [
            "label" => 'Nome do Estabelecimento',
            "rules" => 'required|min:3|max:50'
        ],
        "endereco" => [
            "label" => 'Endereço',
            "rules" => 'max:200'
        ],
        "latitude" => [
            "label" => 'Latitude',
            "rules" => 'required|min:3|max:12'
        ],
        "longitude" => [
            "label" => 'Longitude',
            "rules" => 'required|min:3|max:12'
        ],
        "email" => [
            "label" => 'Email',
            "rules" => 'email|max:150'
        ]
    ];

    /**
     * getEstabelecimentoId
     *
     * @param int $id ID do estabelecimento
     * @return array
     */
    public function getEstabelecimentoId($id)
    {
        return $this->db
            ->table('estabelecimento')
            ->where('estabelecimento_id', $id)
            ->first();
    }

    /**
     * getEstabelecimentoEmail
     *
     * @param string $email 
     * @return array
     */
    public function getEstabelecimentoEmail($email)
    {
        return $this->db
            ->table('estabelecimento')
            ->where('email', $email)
            ->first();
    }

    /**
     * listaEstabelecimento
     *
     * @param string $orderby Campo para ordenação
     * @param string $direction Direção da ordenação (ASC/DESC)
     * @return array
     */
    public function listaEstabelecimento($orderby = "nome", $direction = "ASC")
    {
        return $this->db
            ->table('estabelecimento')
            ->orderBy($orderby, $direction)
            ->findAll();
    }

    /**
     * buscaEstabelecimento
     *
     * @param string $termo Termo de busca
     * @return array
     */
    public function buscaEstabelecimento($termo)
    {
        return $this->db
            ->table('estabelecimento')
            ->where("MATCH(nome) AGAINST(? IN NATURAL LANGUAGE MODE)", [$termo])
            ->findAll();
    }

    /**
     * getEstabelecimentosSelect
     *
     * @return array
     */
    public function getEstabelecimentosSelect()
    {
        return $this->db
            ->table('estabelecimento')
            ->select('estabelecimento_id, nome')
            ->orderBy('nome', 'ASC')
            ->findAll();
    }

    /**
     * getEstabelecimentosPorRegiao
     *
     * @param string $latMin Latitude mínima
     * @param string $latMax Latitude máxima
     * @param string $lonMin Longitude mínima
     * @param string $lonMax Longitude máxima
     * @return array
     */
    public function getEstabelecimentosPorRegiao($latMin, $latMax, $lonMin, $lonMax)
    {
        return $this->db
            ->table('estabelecimento')
            ->where('latitude >=', $latMin)
            ->where('latitude <=', $latMax)
            ->where('longitude >=', $lonMin)
            ->where('longitude <=', $lonMax)
            ->findAll();
    }

    /**
     * verificaDuplicidadeNome
     *
     * @param string $nome
     * @param int|null $estabelecimentoId ID para excluir da verificação
     * @return bool
     */
    public function verificaDuplicidadeNome(string $nome, ?int $estabelecimentoId = null): bool
    {
        $query = $this->db
            ->table('estabelecimento')
            ->where('nome', $nome);

        if ($estabelecimentoId !== null) {
            $query->where('estabelecimento_id !=', $estabelecimentoId);
        }

        $rs = $query->first();

        return !empty($rs);
    }
}
