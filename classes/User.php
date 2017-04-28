<?php

class User
{
    private $_db,
            $_data,
            $_table = 'users';

    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    public function find($where = [])
    {
        $data = $this->_db->select($this->_table, $where);
        if($data->count()) {
            $this->_data = $data->first();
            return true;
        }
        return false;
    }

    public function create($fields = [])
    {
        if(!$this->_db->insert($this->_table, $fields)){
            throw new Exception('There was a problem creating the account');
        }
        return true;
    }

    public function data()
    {
        return $this->_data;
    }


}