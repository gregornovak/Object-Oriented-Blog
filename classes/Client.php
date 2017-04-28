<?php

class Client
{
    private $_ip_address,
            $_time,
            $_os;

    public function ip()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $this->_ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
            $this->_ip_address = $_SERVER['HTTP_X_FORWARDED'];
        } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $this->_ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if(isset($_SERVER['HTTP_FORWARDED'])) {
            $this->_ip_address = $_SERVER['HTTP_FORWARDED'];
        } else if(isset($_SERVER['REMOTE_ADDR'])) {
            $this->_ip_address = $_SERVER['REMOTE_ADDR'];
        } else {
            $this->_ip_address = '0.0.0.0';
        }
        return $this->_ip_address;
    }

    public function requestTime()
    {
        $this->_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        return $this->_time;
    }

    public function os()
    {
        $reg = '/\(.*?\)/';
        preg_match($reg, $_SERVER['HTTP_USER_AGENT'], $this->_os);
        return $this->_os[0];
    }
}