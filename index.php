<?php
require_once 'header.php';
?>
<div class="index-wrapper">
    <header class="intro-header" style="background-image: url('lib/img/home-code.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Blog incoming</h1>
                        <hr class="small">
                        <span class="subheading">TBA</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <h2>hello there</h2>
        <?php
        if(Session::exists('email_activation')) {
            echo Session::flash('email_activation');
        }
        if(Session::exists('registration_completed')) {
            echo Session::flash('registration_completed');
        }
        if(Session::exists('login_successful')) {
            echo Session::flash('login_successful');
        }
        if(Session::exists('logout_successful')) {
            echo Session::flash('logout_successful');
        }
        ?>
    </div>
</div>

<?php
require_once 'footer.php';