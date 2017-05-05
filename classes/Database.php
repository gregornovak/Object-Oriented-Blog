<?php

class Database
{
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    /**
     * Database constructor.
     */
    private function __construct()
    {
        try {
           $this->_pdo = new PDO(
               'mysql:host=' . Config::get('database/host') . ';' .
               'dbname=' . Config::get('database/db_table') . ';' .
               'charset=' . Config::get('database/charset') ,
               Config::get('database/username') ,
               Config::get('database/password')
           );
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }

    /**
     * @return Database|null
     */
    public static function getInstance()
    {
        if(!isset(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    /**
     * @param $table
     * @param array $where
     * @return $this
     */
    public function select($table, $where = [])
    {
        $this->_error = false;
        if($table) {

            if(count($where) == 2) {

                $field      = $where[0];
                $operator   = '=';
                $value      = $where[1];
                $sql = "SELECT * FROM {$table} WHERE {$field} {$operator} ?";
                $this->_query = $this->_pdo->prepare($sql);
                $this->_query->bindValue(1, $value);
            } else if(count($where) === 3) {

                $operators  = ['>', '>=', '<', '<=', '='];
                $field      = $where[0];
                $operator   = $where[1];
                $value      = $where[2];

                if(in_array($operator, $operators)) {
                    $sql = "SELECT * FROM {$table} WHERE {$field} {$operator} ?";
                    $this->_query = $this->_pdo->prepare($sql);
                    $this->_query->bindValue(1, $value);
                }

            } else if(count($where) === 7) {
                $operators  = ['>', '>=', '<', '<=', '='];
                $field      = $where[0];
                $operator   = $where[1];
                $value      = $where[2];
                $logicBind  = $where[3];
                $field2     = $where[4];
                $operator2  = $where[5];
                $value2     = $where[6];

                if(in_array($operator, $operators)) {
                    $sql = "SELECT * FROM {$table} WHERE {$field} {$operator} ? {$logicBind} {$field2} {$operator2} ?";
                    $this->_query = $this->_pdo->prepare($sql);
                    $this->_query->bindValue(1, $value);
                    $this->_query->bindValue(2, $value2);
                }
            } else {
                $sql = "SELECT * FROM {$table}";
                $this->_query = $this->_pdo->prepare($sql);
            }

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count   = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }

        } else {
            $this->_error = true;
        }
        return $this;
    }

    /**
     * @param $table
     * @param array $fields
     * @return bool
     */
    public function insert($table, $fields = [])
    {
        $this->_error = false;

        if($table && is_array($fields)) {
            $keys       = array_keys($fields);
            $keysCount  = count($keys) - 1;
            $keyBinds   = implode(', ', $keys);
            $i          = 0;
            $binds      = '';
            foreach($keys as $key) {
                if($keysCount == $i) {
                    $binds .= '?';
                } else {
                    $binds .= '?, ';
                }
                $i++;
            }
            $sql = "INSERT INTO {$table} ({$keyBinds}) VALUES ({$binds})";
            $this->_query = $this->_pdo->prepare($sql);

            $j = 1;
            foreach($fields as $field) {
                $this->_query->bindValue($j, $field);
                $j++;
            }

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count   = $this->_query->rowCount();
                return true;
            } else {
                $this->_error = true;
            }
        } else {
            $this->_error = true;
        }
        return false;
    }

    /**
     * @param $table
     * @param array $fields
     * @param array $where
     * @return bool
     */
    public function update($table, $fields = [], $where = [])
    {
        $this->_error = false;

        if($table && is_array($fields) && is_array($where)) {
            $fieldKeys  = array_keys($fields);
            $fieldCount = count($fields) - 1;
            $whereKey   = key($where);
            $bind       = '';
            $i = 0;

            foreach($fieldKeys as $key) {
                $bind .= $key . '= ?';
                if($fieldCount > $i) {
                    $bind .= ', ';
                }
                $i++;
            }
            $sql = "UPDATE {$table} SET {$bind} WHERE {$whereKey} = ?";
            $this->_query = $this->_pdo->prepare($sql);

            $j = 1;
            foreach($fields as $field) {
                $this->_query->bindValue($j, $field);
                $j++;
            }
            $this->_query->bindValue($j, $where[$whereKey]);

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count   = $this->_query->rowCount();
                return true;
            } else {
                $this->_error = true;
            }
        }
        return false;
    }

    /**
     * @param $table
     * @param array $where
     * @return bool
     */
    public function delete($table, $where = [])
    {
        $this->_error = false;

        if($table && is_array($where)) {

            $whereCount = count($where);
            $sql = '';

            if($whereCount == 2) {
                $parameter  = $where[0];
                $value      = $where[1];
                $sql = "DELETE FROM {$table} WHERE {$parameter} = ?";
            } else {
                $parameter  = $where[0];
                $operator   = $where[1];
                $value      = $where[2];
                $sql = "DELETE FROM {$table} WHERE {$parameter} {$operator} ?";
            }

            $this->_query = $this->_pdo->prepare($sql);
            $this->_query->bindValue(1,$value);

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count   = $this->_query->rowCount();
                return true;
            } else {
                $this->_error = true;
            }
        }
        return false;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->_count;
    }

    /**
     * @return bool
     */
    public function errors()
    {
        return $this->_error;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->_results;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->_results[0];
    }

}