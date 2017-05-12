<?php
require_once 'core/init.php';
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Blog">
    <meta name="author" content="Gregor Novak">

    <meta name="theme-color" content="#2196F3">
    <meta name="msapplication-navbutton-color" content="#2196F3">
    <meta name="apple-mobile-web-app-status-bar-style" content="#2196F3">

    <link rel="icon" href="lib/favicon/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="lib/favicon/favicon.ico" type="image/x-icon"/>

    <title>Blog</title>

    <!-- Bootstrap Core CSS -->
    <link href="lib/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="lib/css/clean-blog.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="lib/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<!--    <script src="lib/js/main.js"></script>-->
    <link href="lib/css/styles.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-default navbar-custom navbar-fixed-top <?php if(!Client::isHome()) { echo 'not-home'; } ?>">
    <div class="container-fluid">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle navbar-toggle-custom" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-bars fa-2x"></i>
            </button>
            <a class="navbar-brand" href="/">Gregor Novak</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
<!--                <li>-->
<!--                    <a href="#">Vse objave</a>-->
<!--                </li>-->
                <li>
                    <a href="kontakt">Kontakt</a>
                </li>
                <?php if(Session::exists('user')): ?>
                    <li>
                        <a href="odjava">Odjava</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="prijava">Prijava</a>
                    </li>
                    <li>
                        <a href="registracija">Registracija</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>