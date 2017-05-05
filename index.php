<?php
require_once 'header.php';
?>
<div class="container">
    <h2>hello there</h2>
</div>

<?php
if(Session::exists('email_activation')) {
    echo Session::get('email_activation');
}
if(Session::exists('registration_completed')) {
    echo Session::get('registration_completed');
}
if(Session::exists('login_successful')) {
    echo Session::get('login_successful');
}
if(Session::exists('logout_successful')) {
    echo Session::get('logout_successful');
}
require_once 'footer.php';