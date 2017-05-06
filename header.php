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

    <script src="lib/js/main.js"></script>
    <link href="lib/css/styles.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-default <?php if($_SERVER['REQUEST_URI'] == ('/' || 'index.php' || 'index')) { echo 'navbar-custom navbar-fixed-top'; } ?>">
    <div class="container-fluid">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="#">Start Bootstrap</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="index.php">Domov</a>
                </li>
                <li>
                    <a href="#">O meni</a>
                </li>
                <li>
                    <a href="#">Vse objave</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
                <?php if(Session::exists('user')): ?>
                    <li>
                        <a href="logout.php">Odjava</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="login.php">Prijava</a>
                    </li>
                    <li>
                        <a href="register.php">Registracija</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>