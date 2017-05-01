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

    /**
     * Checks if user exists
     *
     * @param array $where
     *
     * @return bool
     */
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
            throw new Exception('Prišlo je do napake pri ustvarjanju računa.');
        }
        return true;
    }

    public function sendActivationEmail($email, $user)
    {
        $to         = $email;
        $username   = $user;
        $hash       = Input::get('activation_hash');
        $headers    = Config::get('email/type');
        $headers    .= Config::get('email/from');
        $subject    = 'Aktivacija računa na gregornovak.si';
        $message    = "<h3>Pozdravljeni {$username},</h3>";
        $message    .= "<p>zahvaljujem se vam za registracijo računa, s klikom na spodnjo povezavo boste aktivirali vaš račun.</p>";
        $message    .= "<a href=\"http://gregornovak.si/aktivacija.php?email={$to}&hash={$hash}\">Povezava do aktivacije.</a>";

        return (mail($to, $subject, $message, $headers)) ? true : false ;
    }

    public function data()
    {
        return $this->_data;
    }


}