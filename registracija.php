<?php
require_once 'header.php';

$user = new User();
if($user->isLoggedIn()) {
    Redirect::to('/');
}

if(Input::exists()) {

    if (Token::exists(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST,
            [
                'username' => [
                    'required' => true,
                    'min' => 4,
                    'max' => 20,
                    'unique' => 'users',
                    'pretty' => 'Uporabniško ime'
                ],
                'email' => [
                    'required' => true,
                    'format' => 'email',
                    'max' => 40,
                    'unique' => 'users',
                    'pretty' => 'Email naslov'
                ],
                'password1' => [
                    'required' => true,
                    'min' => 6,
                    'pretty' => 'Geslo'
                ],
                'password2' => [
                    'required' => true,
                    'min' => 6,
                    'matches' => 'password1',
                    'pretty' => 'Ponovite geslo'
                ]
            ]);


        $a = new User();
        $pic = new Picture();
        // if file has been uploaded -> validate fields for file and user

        if ($pic->exists('picture')) {
            $pic->checkType('picture');
            if ($validation->passed() && $pic->passed()) {

                if($a->create([
                    'username'          => Input::get('username'),
                    'email'             => Input::get('email'),
                    'password'          => Hash::make(Input::get('password1')),
                    'created'           => Time::now(),
                    'updated'           => Time::now(),
                    'last_login'        => Time::now(),
                    'registration_ip'   => Client::ip(),
                    'last_login_ip'     => Client::ip(),
                    'picture'           => $pic->upload('picture'),
                    'activation_hash'   => Input::get('activation_hash')
                ])){
                    if($a->sendActivationEmail(Input::get('email'), Input::get('username'))){
                        Session::flash('email_activation', 'Na vaš email naslov smo vam poslali povezavo do aktivacije računa!');
                        Redirect::to('/');
                    } else {
                        $errors3[] = 'Prišlo je do napake pri pošiljanju aktivacijskega emaila.';
//                        Session::flash('email_activation', 'Vaš račun ni bil aktiviran, ker je prišlo do napake.');
                    }
                }

            } else {
                $errors = $validation->errors();
                $errors2 = $pic->errors();
            }
            // else validate just the fields without the file check
        } else {
            if ($validation->passed()) {
                echo 'passed without picture';
                if($a->create([
                    'username'          => Input::get('username'),
                    'email'             => Input::get('email'),
                    'password'          => Hash::make(Input::get('password1')),
                    'created'           => Time::now(),
                    'updated'           => Time::now(),
                    'last_login'        => Time::now(),
                    'registration_ip'   => Client::ip(),
                    'last_login_ip'     => Client::ip(),
                    'activation_hash'   => Input::get('activation_hash')
                ])){
                    if($a->sendActivationEmail(Input::get('email'), Input::get('username'))){
                        Session::flash('email_activation', 'Na vaš email naslov smo vam poslali povezavo z aktivacijo vašega računa!');
                        Redirect::to('/');
                    } else {
//                        Session::flash('email_activation', 'Vaš račun ni bil aktiviran, ker je prišlo do napake.');
                        $errors3[] = 'Prišlo je do napake pri pošiljanju aktivacijskega emaila.';
                    }
                }
            } else {
                $errors = $validation->errors();
            }

        }

    }
}
?>

<div class="main-wrapper register-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="auth-center">
                    <h1 class="auth-heading">Registracija računa</h1>
                    <div class="cross-wrapper">
                        <div class="auth-cross cross1"></div>
                        <div class="auth-cross cross2"></div>
                    </div>
                    <form action="" class="users-form" method="post" id="register-user" enctype="multipart/form-data">
                        <div class="input-container">
                            <label for="username" class="auth-labels">Uporabniško ime <span class="required">*</span></label>
                            <input type="text" class="auth-inputs" id="username" name="username" value="<?php echo Input::get('username') ?>">
                        </div>
                        <div class="input-container">
                            <label for="email" class="auth-labels">Email naslov <span class="required">*</span></label>
                            <input type="email" class="auth-inputs" id="email" name="email" value="<?php echo Input::get('email') ?>">
                        </div>
                        <div class="input-container">
                            <label for="password1" class="auth-labels">Geslo <span class="required">*</span></label>
                            <input type="password" class="auth-inputs" id="password1" name="password1">
                        </div>
                        <div class="input-container">
                            <label for="password2" class="auth-labels">Ponovite geslo <span class="required">*</span></label>
                            <input type="password" class="auth-inputs" id="password2" name="password2">
                        </div>
                        <div class="input-container file-input-container">
                            <label for="picture" class="auth-labels file-label">
                                <span class="glyphicon glyphicon-floppy-open file-picture" aria-hidden="true"></span>Slika profila
                            </label>
                            <input type="file" name="picture" id="picture">
                        </div>
                        <span class="required-fields">
                            Polja označena z * so obvezna!
                        </span>
                        <div class="errors">
                            <?php foreach($errors as $error): ?>
                                <p class="err"><?php echo $error; ?></p>
                            <?php endforeach; ?>
                            <?php foreach($errors2 as $error): ?>
                                <p class="err"><?php echo $error; ?></p>
                            <?php endforeach; ?>
                            <?php foreach($errors3 as $error): ?>
                                <p class="err"><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::make() ?>">
                        <input type="hidden" name="activation_hash" value="<?php echo Hash::email() ?>">
                        <button type="submit" name="register" id="register-submit">Registriraj me</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';