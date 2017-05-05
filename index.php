<?php
require_once 'header.php';
?>
<div class="container">
    <h2>hello there</h2>
</div>

<?php
if(Session::exists('registration_completed')) {
    echo Session::get('registration_completed');
}
require_once 'footer.php';