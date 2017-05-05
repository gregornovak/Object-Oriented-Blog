<?php
require_once 'core/init.php';
require_once 'header.php';

if(Input::exists()) {
    $validation = new Validate();
    $validate = $validation->check($_POST, [
        'email' => [
            'required'  => true,
            'format'    => 'email',
            'max'       => 40,
            'pretty'    => 'Email naslov'
        ],
        'password'  => [
            'required'  => true,
            'min'       => 6,
            'pretty'    => 'Geslo'
        ]
    ]);

    if($validate->passed()) {
        $user = new User();
        $user->login();
    }


}
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="" class="users-form" method="post" id="login-user">
                    <div class="input-container">
                        <label for="email">Email naslov</label>
                        <input type="email" id="email" name="email" value="<?php echo Input::get('email') ?>">
                    </div>
                    <div class="input-container">
                        <label for="password">Geslo</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div class="input-container">
                        <label for="remember">Zapomni si me</label>
                        <input type="checkbox" id="remember" name="remember">
                    </div>
                    <input type="hidden" name="token" value="<?php echo Token::make() ?>">
                    <input type="submit" name="login" id="login-submit">
                </form>
            </div>
        </div>
    </div>

    <div style="height:500px; background: #666;"></div>

<?php
require_once 'footer.php';