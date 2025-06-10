<?php

namespace Core\Library;

use PDO;
use PDOException;
use Exception;

class Database 
{
    private $conexao;
    private static $dbdrive  = "";
    private static $host     = "";
    private static $port     = "";
    private static $user     = "";
    private static $password = "";
    private static $db       = "";
    
    protected $table;
    private $select = "*";
    private $join = "";
    private $where = "";
    private $groupBy = "";
    private $orderBy = "";
    private $limit = "";  
    private $params = [];

    /**
     * construct
     *
     * @param string $db_dbdrive 
     * @param string $db_host 
     * @param string $db_port 
     * @param string $db_bdados 
     * @param string $db_user 
     * @param string $db_password 
     */
    public function __construct(
        $db_dbdrive,
        $db_host,
        $db_port,
        $db_bdados,
        $db_user,
        $db_password       
    ) {
        self::$dbdrive  = $db_dbdrive;
        self::$host     = $db_host;
        self::$port     = $db_port;
        self::$db       = $db_bdados;  
        self::$user     = $db_user;
        self::$password = $db_password;
    }

    /**
     * clone - Evita que a classe seja clonada
     *
     * @return void
     */
    private function __clone() 
    {
    }

    /**
     * destruct - Método que destroi a conexão com banco de dados e remove da memória todas as variáveis setadas
     */
    public function __destruct() {
        $this->disconnect();
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    private function getDBDrive() {return self::$dbdrive;}
    private function getHost()    {return self::$host;}
    private function getPort()    {return self::$port;}
    private function getUser()    {return self::$user;}
    private function getPassword(){return self::$password;}
    private function getDB()      {return self::$db;}

    /**
     * connect
     *
     * @return object
     */
    public  function connect()
    { 
        try {
            if ( $this->getDBDrive() == 'mysql' ) {            // MySQL

                $this->conexao = new PDO(
                                            $this->getDBDrive().":host=".$this->getHost().";port=".$this->getPort().";dbname=".$this->getDB(), 
                                            $this->getUser(), 
                                            $this->getPassword(), 
                                            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
                                        );

            } else if ( $this->getDBDrive() == 'sqlsrv' ) {    // SQL Server

                $this->conexao = new PDO(
                                            $this->getDBDrive().":Server=".$this->getHost().",".$this->getPort().";DataBase=".$this->getDB(), 
                                            $this->getUser(), 
                                            $this->getPassword(), 
                                            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
                                        );

            }

            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, $this->conexao::ERRMODE_EXCEPTION);

        } catch (PDOException $i) {
            //se houver exceçao, exibe
            die("Erro: <code>" . $i->getMessage() . "</code>");
        }

        return ($this->conexao);
        
    }

    /**
     * disconnect
     *
     * @return void
     */
    private function disconnect(){
        $this->conexao = null;
    }

    /**
     * Método select que retorna um array de objetos
    *   @param string $sql
    *   @param array $params
    *   @return void
    */
    public function dbSelect($sql, $params = null)
    {
        if ((gettype($params) != 'array') && (gettype($params) != "NULL") ) {
            $params = [$params];
        }
        
        $query = $this->connect()->prepare( $sql , array( PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL ) );
        $query->execute( $params );
        $rs = $query;
        
        self::__destruct();
        
        return $rs;
        
    }
    
    /**
     * dbInsert - Método insert que insere valores no banco de dados e retorna o último id inserido
     *
     * @param string $sql 
     * @param mixed $params 
     * @return void
     */
    public function dbInsert($sql, $params = null)
    {
        try {        
            $conexao = $this->connect();
            $query   = $conexao->prepare($sql);
            $query->execute($params);
            
            $rs      = $conexao->lastInsertId(); // or die(print_r($query->errorInfo(), true));
            
            self::__destruct();
            
            return $rs;

        } catch (Exception $e) {
            var_dump($sql);
            print_r($query->debugDumpParams());
            var_dump($params);
            echo 'Exceção capturada: '.  $e->getMessage(); exit;
        }     
    }

    /**
     * dbUpdate - Método update que altera valores do banco de dados e retorna o número de linhas afetadas
     *
     * @param string $sql 
     * @param mixed $params 
     * @return void
     */
    public function dbUpdate($sql, $params = null)
    {
        try {
            $query = $this->connect()->prepare($sql);
            $query->execute($params);
            
            $rs = $query->rowCount();// or die(print_r($query->errorInfo(), true));
            self::__destruct();            
            
            return $rs;

        } catch (Exception $e) {
            echo 'Exceção capturada: '.  $e->getMessage(); exit;
        }  
    }

    /**
     * dbDelete - Método delete que exclusão valores do banco de dados retorna o número de linhas afetadas
     *
     * @param string $sql 
     * @param mixed $params 
     * @return int|bool
     */
    public function dbDelete($sql, $params=null)
    {
        $query=$this->connect()->prepare($sql);
        
        try {
            
            $query->execute($params);
            $rs = $query->rowCount(); 
            
        } catch (Exception $exc) {
            echo "Erro ao Excluir Registro, favor entrar em contato com Suporte Tenico" . $exc->getTraceAsString();
        }

        self::__destruct();
        
        if ($rs == array()) {
            return false;
        } else {
            return $rs;
        }       
    }

    /**
     * dbBuscaDados - Método que retornar a posição atual do registro (OBJ)
     *
     * @param object $rscPdo 
     * @return object
     */
    public function dbBuscaDados($rscPdo)
    {
        return $rscPdo->fetch(PDO::FETCH_OBJ);
    }
    
    /**
     * dbBuscaDadosAll - Método que retornar todos os registros (OBJ)
     *
     * @param object $rscPdo 
     * @return object
     */
    public function dbBuscaDadosAll($rscPdo)
    {
        return $rscPdo->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     * dbBuscaArray - Método que retornar a posição atual do registro (array)
     *
     * @param object $rscPdo 
     * @return array
     */
    public function dbBuscaArray( $rscPdo )
    {
        $aRegistro = $rscPdo->fetch(PDO::FETCH_ASSOC);

        if ($aRegistro === false) {
            return [];
        } else {
            return $aRegistro;
        }
    }

    /**
     * dbBuscaArrayAll - Método que retornar a posição atual do registro (array)
     *
     * @param object $rscPdo 
     * @return array
     */
    public function dbBuscaArrayAll($rscPdo)
    {
        return $rscPdo->fetchall(PDO::FETCH_ASSOC);
    }
    
    /**
     * dbNumeroLinhas - Método que retornar o Numero de linhas Selecionadas
     *
     * @param object $rscPdo 
     * @return int
     */    
    public function dbNumeroLinhas($rscPdo)
    {
        return $rscPdo->rowCount();
    }

    /**
     * dbNumeroColunas - Método que retornar o Numero de Colunas Selecionadas
     *
     * @param object $rscPdo 
     * @return int
     */
    public function dbNumeroColunas($rscPdo)
    {
        return $rscPdo->columnCount();
    }            
    
    /**
     * dbResultado
     *
     * @param object $rscRes 
     * @param array $CampoRetorno 
     * @return void
     */
    public function dbResultado($rscRes, $CampoRetorno)
    {
        $rowResX = $this->dbBuscaArray( $rscRes );
        
        return $rowResX[ $CampoRetorno ];
    }

    /**
     * select
     *
     * @param string $columns 
     * @return object
     */
    public function select($columns = "*")
    {
        $this->select = $columns;
        return $this;
    }

    /**
     * table
     *
     * @param string $table 
     * @return object
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * join
     *
     * @param string $table 
     * @param string $condition 
     * @param string $tipoJoin 
     * @return object
     */
    public function join($table, $condition, $tipoJoin = "INNER")
    {
        $this->join .= ' ' . $tipoJoin . " JOIN " . $table . " ON " . $condition;
        return $this;
    }

    /**
     * whereHaving
     *
     * @param string|array $condition 
     * @param string $params 
     * @param string $operadorLogico 
     * @return object
     */
    public function whereHaving($condition, $params = "", $operadorLogico = 'AND')
    {
        $operadores = ["=", ">=", "<=", ">", "<", "<>"];

        if ($this->where == "") {
            $this->where = " WHERE ";
        } else {
            $this->where .= " {$operadorLogico} ";
        }

        if (gettype($condition) == "string") {

            $aKey = explode(" ", $condition);

            if (count($aKey) > 1) {
                if (in_array(explode(" ", $condition)[1], $operadores)) {
                    $this->where .= $condition . " ? ";
                } else {
                    $this->where .= $condition . " = ? ";
                }
            } else {
                $this->where .= $condition . " = ? ";
            }

            $this->params = array_merge($this->params, [$params]);

        } else {

            $lAnd = false;

            foreach ($condition as $key => $value) {

                if ($lAnd) {
                    $this->where .= " {$operadorLogico} ";
                } else {
                    $lAnd = true;
                }

                $aKey = explode(" ", $key);

                if (count($aKey) > 1) {
                    if (in_array(explode(" ", $key)[1], $operadores)) {
                        $this->where .= $key . " ? ";
                    } else {
                        $this->where .= $key . " = ? ";
                    }
                } else {
                    $this->where .= $key . " = ? ";
                }
            }

            $this->params = array_values($condition);
        }

        return $this;
    }

    /**
     * where
     *
     * @param string|array $condition 
     * @param string $params 
     * @return object
     */
    public function where($condition, $params = "")
    {
        return $this->whereHaving($condition, $params);
    }

    /**
     * where
     *
     * @param string|array $condition 
     * @param string $params 
     * @return object
     */
    public function orWhere($condition, $params = "")
    {
        return $this->whereHaving($condition, $params, "OR");
    }

    /**
     * whereIn
     *
     * @param string $field 
     * @param array $params 
     * @param string $operadorLogico 
     * @param bool $notIn 
     * @return object
     */
    public function whereInHaving($field, $params, $operadorLogico = 'AND', $notIn = false)
    {
        $placeholders = [];

        foreach ($params as $i => $value) {
            $placeholders[] = "?";
            $this->params[] = $value;
        }

        // Monta cláusula IN
        $clause = "{$field} " . ($notIn ? "NOT" : "" ) . " IN (" . implode(', ', $placeholders) . ")";

        // Adiciona a cláusula WHERE
        if (empty($this->where)) {
            $this->where = " WHERE {$clause}";
        } else {
            $this->where .= " {$operadorLogico} {$clause}";
        }

        return $this;
    }

    /**
     * whereIn
     *
     * @param string $field 
     * @param array $params 
     * @param string $operadorLogico 
     * @return object
     */
    public function whereIn($field, $params, $operadorLogico = 'AND')
    {
        return $this->whereInHaving($field, $params, $operadorLogico);
    }

    /**
     * whereIn
     *
     * @param string $field 
     * @param array $params 
     * @param string $operadorLogico 
     * @return object
     */
    public function whereNotIn($field, $params, $operadorLogico = 'AND')
    {
        return $this->whereInHaving($field, $params, $operadorLogico, true);
    }

    /**
     * whereLike
     *
     * @param mixed $field 
     * @param strung $value 
     * @param string $operadorLogico 
     * @return object
     */
    public function whereLike($field, $value, $operadorLogico = "AND")
    {
        // Monta cláusula IN
        $clause = " {$field} LIKE ? ";

        // Setando valores
        $this->params[] = "%$value%";

        // Adiciona a cláusula WHERE
        if (empty($this->where)) {
            $this->where = " WHERE {$clause}";
        } else {
            $this->where .= " {$operadorLogico} {$clause}";
        }

        return $this;
    }

    /**
     * whereBetween
     *
     * @param string $field 
     * @param mixed $valorIni 
     * @param mixed $valorFim 
     * @param string $operadorLogico 
     * @return object
     */
    public function whereBetween($field, $valorIni, $valorFim, $operadorLogico = "AND")
    {
        // Monta cláusula IN
        $clause = " {$field} BETWEEN ? AND  ? ";

        // Setando valores
        $this->params[] = $valorIni;
        $this->params[] = $valorFim;

        // Adiciona a cláusula WHERE
        if (empty($this->where)) {
            $this->where = " WHERE {$clause}";
        } else {
            $this->where .= " {$operadorLogico} {$clause}";
        }

        return $this;
    }

    /**
     * group
     *
     * @param string $operadorLogico - AND, OR
     * @return object
     */
    public function group($operadorLogico = "AND")
    {
        $this->where .= $operadorLogico . " ( ";
        return $this;
    }

    /**
     * endGroup
     *
     * @return object
     */
    public function endGroup()
    {
        $this->where .= " ) ";
        return $this;
    }

    /**
     * groupBy
     *
     * @param string $column 
     * @return object
     */
    public function groupBy($column)
    {
        $this->groupBy = " GROUP BY $column";
        return $this;
    }

    /**
     * orderBy
     *
     * @param string $column 
     * @param string $direction 
     * @return object
     */
    public function orderBy($column, $direction = "ASC")
    {
        $this->orderBy = " ORDER BY " . $column . " " . $direction;
        return $this;
    }

    /**
     * prepareSelect
     *
     * @param string $tipoRetorno 
     * @return array|int
     */
    public function prepareSelect($tipoRetorno = "all")
    {
        $cSql = "SELECT {$this->select} FROM {$this->table} {$this->join} {$this->where} {$this->groupBy} {$this->orderBy}";
        $query = $this->connect()->prepare($cSql, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $rscDados = $query->execute($this->params);

        self::dbClear();

        if ($tipoRetorno == "all") {
            return $this->dbBuscaArrayAll($query);
        } elseif ($tipoRetorno == "first") {
            return $this->dbBuscaArray($query);
        } elseif ($tipoRetorno == "count") {
            return $this->dbNumeroLinhas($rscDados);
        }
    }

    /**
     * dbClear
     *
     * @return void
     */
    public function dbClear()
    {
        $this->select = "*";
        $this->join = "";
        $this->where = "";
        $this->groupBy = "";
        $this->orderBy = "";
        $this->limit = "";  
        $this->params = [];
    }

    /**
     * findAll
     *
     * @return array
     */
    public function findAll()
    {
        return $this->prepareSelect();
    }

    /**
     * first
     *
     * @return array
     */
    public function first()
    {
        return $this->prepareSelect("first");
    }

    /**
     * findCount
     *
     * @return int
     */
    public function findCount()
    {
        return $this->prepareSelect("count");
    }

    /**
     * insert
     *
     * @param array $data 
     * @return int
     */
    public function insert(array $data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $placeHolders = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeHolders)";

            $conexao = $this->connect();
            $query = $conexao->prepare($sql);
            $query->execute($data);

            $rs = $conexao->lastInsertId();

            self::dbClear();

        } catch (\Exception $err) {
            Session::set("msgError", "Erro ao inserir dados na base de dados: " . $err->getMessage());
            $rs = 0;
        }

        return $rs;
    }

    /**
     * update
     *
     * @param array $data 
     * @return int
     */
    public function update(array $data)
    {
        try {
            $fields = implode(" = ?, ", array_keys($data)) . " = ?";
            $sql    = "UPDATE {$this->table} SET {$fields} {$this->where}";
            $updData = array_merge(array_values($data), $this->params);

            $query  = $this->connect()->prepare($sql);
            $query->execute($updData);

            $rs = $query->rowCount();

            self::dbClear();

        } catch (\Exception $err) {
            Session::set("msgError", "Erro ao Atualizar dados na base de dados: " . $err->getMessage());
            $rs = 0;
        }

        return $rs;
    }

    /**
     * delete
     *
     * @return int
     */
    public function delete()
    {
        try {
            $sql    = "DELETE FROM {$this->table} {$this->where};";

            $query  = $this->connect()->prepare($sql);
            $query->execute($this->params);

            $rs = $query->rowCount();

            self::dbClear();

        } catch (\Exception $err) {
            Session::set("msgError", "Erro ao Excluir dados na base de dados: " . $err->getMessage());
            $rs = 0;
        }

        return $rs;
    }
}