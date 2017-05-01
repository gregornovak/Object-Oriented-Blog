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
            // TO DO naredi update metodo za uporabnike ter redirectaj na home page
            $user->update();
            Redirect::to();
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