<?php
require_once 'core/init.php';

$user = new User();
$user->logout();
session_unset();
Session::flash('logout_successful','Uspešno ste se odjavili!');
Redirect::to('index.php');