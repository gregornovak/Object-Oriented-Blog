<?php

class Picture
{
    private $_db,
            $_errors,
            $_passed,
            $_type,
            $_file_name,
            $_tmp_name,
            $_full_name,
            $_file_destination;

    /**
     * Picture constructor.
     */
    public function __construct()
    {
        return $this->_db = Database::getInstance();
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return (isset($_FILES)) ? true : false;
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if(!$this->checkType()) {
            return null;
        }
        if($this->_passed) {
            $this->_full_name = uniqid() . '_' . $this->_file_name . '.' . $this->_type;
            $this->_file_destination = 'uploads' . DIRECTORY_SEPARATOR . 'profile_pics'
                                                 . DIRECTORY_SEPARATOR . $this->_full_name;

            if(move_uploaded_file($this->_tmp_name, $this->_file_destination)) {
                return $this->_full_name;
            }
        }
    }

    /**
     * @return $this
     */
    private function checkType()
    {
        if(isset($_FILES)) {
            $allowed    = ['jpg', 'jpeg', 'png', 'gif'];
            $max_size   = 2097152; //2mb
            $name       = $_FILES['picture']['name'];
            $error      = $_FILES['picture']['error'];
            $size       = $_FILES['picture']['size'];
            $tmp_name   = $_FILES['picture']['tmp_name'];

            $file_exp   = explode('.', strtolower($name));
            $file_ext   = end($file_exp);

            if(in_array($file_ext, $allowed) && $error == 0) {
                if($size <= $max_size) {
                    $this->_type        = $file_ext;
                    $this->_file_name   = $file_exp[0];
                    $this->_tmp_name    = $tmp_name;
                    $this->_passed = true;

                } else {
                    $this->_passed = false;
                    $this->addError('Velikost slike mora biti manjša od 2mb!');
                }
            } else {
                $this->_passed = false;
                $this->addError('Naložite lahko samo slike sledečih formatov: ' . implode(', ', $allowed) . '!');
            }

            return $this;
        }

        return null;

    }

    /**
     * @return mixed
     */
    public function passed()
    {
        return $this->_passed;
    }

    /**
     * @param $string
     */
    public function addError($string)
    {
        $this->_errors[] = $string;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->_errors;
    }
}