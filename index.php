<?php
require_once 'header.php';
?>
<div class="container">
    <h2>hello there</h2>
</div>

<?php
$u = new User();
var_dump($u->create(['username'          => Input::get('username'),
    'email'             => Input::get('email'),
    'password'          => Hash::make(Input::get('password1')),
    'created'           => Time::now(),
    'updated'           => Time::now(),
    'last_login'        => Time::now(),
    'registration_ip'   => Client::ip(),
    'last_login_ip'     => Client::ip(),
    'activation_hash'   => Input::get('activation_hash')]));
require_once 'footer.php';