<?php

namespace Core\Library;

class ModelMain
{
    public $db;
    public $validationRules = [];
    protected $table;
    protected $primaryKey = "id";

    /**
     * construct
     */
    public function __construct(?Database $db = null)
    {
        if ($db == null) {
            $this->db = new Database(
                $_ENV['DB_CONNECTION'],
                $_ENV['DB_HOST'],
                $_ENV['DB_PORT'],
                $_ENV['DB_DATABASE'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD']
            );
        } else {
            $this->db = $db;
        }

        $this->db->table($this->table);
    }

    /**
     * getById
     *
     * @param int $id 
     * @return array
     */
    public function getById($id)
    {
        if ($id == 0) {
            return [];
        } else {
            return $this->db->table($this->table)->where("id", $id)->first();
        }
    }

    /**
     * lista
     *
     * @param string $orderby 
     * @return array
     */
    public function lista($orderby = 'descricao', $direction = "ASC")
    {   
        return $this->db->table($this->table)->orderBy($orderby, $direction)->findAll();
    }

    /**
     * insert
     *
     * @param array $dados 
     * @return bool
     */
    public function insert($dados)
    {
        if (Validator::make($dados, $this->validationRules)) {
            return 0;
        } else {
            $this->db->table($this->table);
            if ($this->db->insert($dados) > 0) {
                return true;
            } else {
                return false;
            }
        } 
    }
    
    /**
     * insertGetId
     *
     * @param array $dados
     *
     * @return bool|int
     */
    public function insertGetId($dados)
    {
        // Validação
        if (Validator::make($dados, $this->validationRules)) {
            return false;
        }
        
        // Seta tabela e insere
        $this->db->table($this->table);
        $id = $this->db->insert($dados);
        
        // Retorna ID ou false
        if ($id > 0) {
            return $id;
        } else {
            return false;
        }
    }

    /**
     * update
     *
     * @param array $dados 
     * @return bool
     */
    public function update($dados)
    {
        if (Validator::make($dados, $this->validationRules)) {
            return 0;
        } else {
            if ( $this->db->table($this->table)->where($this->primaryKey, $dados[$this->primaryKey])->update($dados) > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * delete
     *
     * @param array $dados 
     * @return bool
     */
    public function delete($dados)
    {
        if ( $this->db->table($this->table)->where($this->primaryKey, $dados[$this->primaryKey])->delete() > 0) {
            return true;
        } else {
            return false;
        }
    }
}