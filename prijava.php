<?php
require_once 'header.php';

$user = new User();
if($user->isLoggedIn()) {
    Redirect::to('/');
}

if(Input::exists()) {
    if(Token::exists(Input::get('token'))) {
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
            $remember_me = Input::get('remember') == 'on' ? true : false;
            $user = new User();
            $user->login(Input::get('email'), Input::get('password'), $remember_me);
            if($user) {
                Session::flash('login_successful', 'Prijava je bila uspešna!');
                Redirect::to('/');
            } else {
                echo 'Prijava je bila neuspešna!';
            }

        } else {
            $errors = $validate->errors();
        }

    }
}
?>

<div class="main-wrapper login-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="auth-center">
                    <h1 class="auth-heading">Prijava</h1>
                    <form action="" class="users-form" method="post" id="login-user">
                        <div class="input-container">
                            <label for="email" class="auth-labels">Email naslov</label>
                            <input type="email" class="auth-inputs" id="email" name="email" value="<?php echo Input::get('email') ?>">
                        </div>
                        <div class="input-container">
                            <label for="password" class="auth-labels">Geslo</label>
                            <input type="password" class="auth-inputs" id="password" name="password">
                        </div>
                        <div class="input-container">
                            <label for="remember" class="auth-labels">Zapomni si me</label>
                            <input type="checkbox" class="auth-inputs" id="remember" name="remember">
                        </div>
                        <div class="errors">
                            <?php foreach($errors as $error): ?>
                                <p class="err"><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::make() ?>">
                        <button type="submit" name="login" id="login-submit">Prijavi me</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';