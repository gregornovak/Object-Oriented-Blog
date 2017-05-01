<?php
require_once 'header.php';

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
                echo 'passed';

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
                        Session::make('email_activation', 'Vaš račun je bil uspešno aktiviran!');
                    } else {
                        Session::make('email_activation', 'Vaš račun ni bil aktiviran, ker je prišlo do napake.');
                    }
                }

            } else {
                $errors1 = $validation->errors();
                $errors2 = $pic->errors();
                foreach ($errors1 as $error) {
                    echo $error . '<br>';
                }
                foreach ($errors2 as $error) {
                    echo $error . '<br>';
                }
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
                        Session::make('email_activation', 'Vaš račun je bil uspešno aktiviran!');
                    } else {
                        Session::make('email_activation', 'Vaš račun ni bil aktiviran, ker je prišlo do napake.');
                    }
                }
            } else {
                $errors = $validation->errors();
                foreach ($errors as $error) {
                    echo $error . '<br>';
                }
            }


        }


    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="" class="users-form" method="post" id="register-user" enctype="multipart/form-data">
                <div class="input-container">
                    <label for="username">Uporabniško ime</label>
                    <input type="text" id="username" name="username" value="<?php echo Input::get('username') ?>">
                </div>
                <div class="input-container">
                    <label for="email">Email naslov</label>
                    <input type="email" id="email" name="email" value="<?php echo Input::get('email') ?>">
                </div>
                <div class="input-container">
                    <label for="password1">Geslo</label>
                    <input type="password" id="password1" name="password1">
                </div>
                <div class="input-container">
                    <label for="password2">Ponovite geslo</label>
                    <input type="password" id="password2" name="password2">
                </div>
                <div class="input-container">
                    <label for="picture">Slika profila:</label>
                    <input type="file" name="picture" id="picture">
                </div>
                <input type="hidden" name="token" value="<?php echo Token::make() ?>">
                <input type="hidden" name="activation_hash" value="<?php echo Hash::email() ?>">
                <input type="submit" name="register" id="register-submit">
            </form>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';