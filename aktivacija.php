<?php
require_once 'header.php';

if(Input::exists()) {
    $validate = new Validate();
    $validation = $validate->check($_GET, [
        'email' => [
            'required' => true,
            'format' => 'email',
            'max' => 40,
            'pretty' => 'Email naslov'
        ]
    ]);
    if($validation->passed()) {
        $user = new User();
        if($user->find(['email', '=', Input::get('email'), 'AND', 'activation_hash', '=', Input::get('hash')])){
            if($user->update(['active' => 1], ['activation_hash' => Input::get('hash')])) {
                Session::flash('registration_completed', 'Vaš račun je bil uspešno aktiviran!');
                Redirect::to('index.php');
            }
        } else {
            echo 'Ta uporabnik ne obstaja!';
        }
    } else {
        foreach($validation->errors() as $error) {
            echo $error . "<br>";
        }
    }
}

require_once 'footer.php';