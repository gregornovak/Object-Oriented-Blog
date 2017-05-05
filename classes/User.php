<?php

class User
{
    private $_db,
            $_data,
            $_table = 'users',
            $_is_logged_in,
            $_session_name,
            $_cookie_name;

    public function __construct($user = null)
    {
        $this->_db = Database::getInstance();
        $this->_session_name = Config::get('session/session_name');
        $this->_cookie_name = Config::get('remember/cookie_name');

        if(!$user) {
            if(Session::exists($this->_session_name)) {
                $user = Session::get($this->_session_name)['user_id'];

                if($this->find(['id', $user])) {
                    $this->_isLoggedIn = true;

                } else {
                    throw new Exception('Prišlo je do napake pri prijavi.');
                }
            }
        } else {
            $this->find($user);
        }
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

    /**
     * Creates the user account
     *
     * @param array $fields
     *
     * @return bool
     *
     * @throws Exception
     */
    public function create($fields = [])
    {
        if($this->find(['username', '=', $fields['username'], 'OR', 'email', '=', $fields['email']])) {
            return false;
        }
        if(!$this->_db->insert($this->_table, $fields)){
            throw new Exception('Prišlo je do napake pri ustvarjanju računa.');
        }
        return true;
    }

    public function update($fields = [], $where = [])
    {
        if(!$this->_db->update($this->_table, $fields, $where)) {
            throw new Exception('Prišlo je do napake pri posodabljanju vašega računa.');
        }
        return true;
    }

    public function login($email = null, $password = null, $remember = false)
    {
        if(!$email && !$password && $this->exists()) {
            Session::make($this->_session_name, $this->data()->id);
        } else {
            $user = $this->find(['email',$email]);
            if($user) {
                if($this->data()->password == Hash::check($password, $this->_data->password)) {
                    Session::make($this->_session_name, [
                        'user_id'   => $this->data()->id,
                        'username'  => $this->data()->username,
                        'email'     => $this->data()->email
                    ]);
                    if($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->select('users_sessions', ['user_id', '=', $this->data()->id]);

                        if(!$hashCheck->count()) {
                            $this->_db->insert('users_sessions', [
                                'user_id'   => $this->data()->id,
                                'hash'      => $hash
                            ]);
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::make($this->_cookie_name, $hash, Config::get('remember/cookie_expiry'));
                    }
                    return true;
                }
            }
        }

        return false;
    }

    public function logout()
    {
        $this->_db->delete('users_sessions', ['user_id', '=', $this->data()->id]);
        Session::delete($this->_session_name);
        Cookie::delete($this->_cookie_name);
    }

    // spremeni dovoljenja da je samo admin
    public function hasPermission($key)
    {
        $group = $this->_db->select('groups', ['id', '=', $this->data()->groupNum]);

        if($group->count()) {
            $permissions = $group->first()->permissions;

            if($permissions[$key] == true) {
                return true;
            }
        }
        return false;
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
        $message    .= "<p>zahvaljujem se Vam za registracijo računa na gregornovak.si, s klikom na spodnjo povezavo boste aktivirali vaš račun.</p>";
        $message    .= "<a href=\"http://gregornovak.si/aktivacija.php?email={$to}&hash={$hash}\">Povezava do aktivacije.</a>";

        return (mail($to, $subject, $message, $headers)) ? true : false;
    }

    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_is_logged_in;
    }


}