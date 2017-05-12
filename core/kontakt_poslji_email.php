<?php

if(isset($_POST)) {
    if(empty($_POST['name'])      ||
        empty($_POST['email'])     ||
        empty($_POST['message'])   ||
        !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
    {
        echo "Izpolniti morate vsa polja!";
        return false;
    }

    $name = strip_tags(htmlspecialchars($_POST['name']));
    $email_address = strip_tags(htmlspecialchars($_POST['email']));
    $phone = strip_tags(htmlspecialchars($_POST['phone']));
    $message = strip_tags(htmlspecialchars($_POST['message']));


    $to = 'info@gregornovak.si';
    $email_subject = "Email iz kontaktnega obrazca:  $name";
    $email_body = "Prejeli ste novo sporočilo.\n\n"."Podatki iz kontaktnega obrazca:\n\nIme: $name\n\nEmail: $email_address\n\nSporočilo:\n$message";
    $headers = "Content-Type: text/html; charset=UTF-8";
    $headers .= "From: noreply@gregornovak.si\n";
    $headers .= "Reply-To: $email_address";
    mail($to,$email_subject,$email_body,$headers);
    return true;
}

?>
