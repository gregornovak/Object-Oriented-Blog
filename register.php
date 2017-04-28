<?php
require_once 'header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" id="register-user" enctype="multipart/form-data">
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
                <input type="submit" name="register" id="register-submit">
            </form>
        </div>
    </div>
</div>

<?php
if(Input::exists()) {
$validate = new Validate();
$validation = $validate->check( $_POST,
        [
            'username' => [
                'required'  => true,
                'min'       => 4,
                'max'       => 20,
                'unique'    => 'users',
                'pretty'    => 'Uporabniško ime'
            ],
            'email' => [
                'required'  => true,
                'max'       => 40,
                'unique'    => 'users',
                'pretty'    => 'Email naslov'
            ],
            'password1' => [
                'required'  => true,
                'min'       => 6,
                'pretty'    => 'Geslo'
            ],
            'password2' => [
                'required'  => true,
                'min'       => 6,
                'matches'   => 'password1',
                'pretty'    => 'Ponovite geslo'
            ]
        ]);
    var_dump($validation->errors());



    $a = new User();
    if($validation->passed()) {
        $pic = new Picture();
        $a->create([
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Hash::make(Input::get('password1')),
            'created' => Time::now(),
            'updated' => Time::now(),
            'last_login' => Time::now(),
            'registration_ip' => Client::ip(),
            'last_login_ip' => Client::ip(),
            'picture' => $pic->upload()

        ]);

    }


}

require_once 'footer.php';