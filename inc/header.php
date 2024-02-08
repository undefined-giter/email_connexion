<?php
    ob_start();
    require_once 'functions.php'; 
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>StatsWorld</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.1/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.1/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.1/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <style>
        *{
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .pLighty{
            background-color: indigo !important;
        }
        #statworld{
            text-align: center !important;
            margin: 0 auto !important;
            padding: 0 auto !important;
            font-size: 2em;
        }
        a{
            text-decoration: none !important;
        }
        input{
            width: 250px !important;
        }
        #forgot_pass{
            color: blue;
            font-family: 'Lucida Sans', 'serif';
            font-size: 8px;
            margin-left: 178px;
            position: absolute;
        }
        .noDot{
            list-style-type: none;
        }
        #main{
            height: 80vh;
            margin: 0 7%;
        }
        #connection{
            position: absolute;
            right: 2%;
        }
    </style>
</head>
<body>
    <header class="container py-4 pb-3 mb-4 border-bottom">
        <div style="text-align: center !important">
            <a id="statworld" href="/" title="statworld"><i class="fas fa-globe"></i></a>
        </div>
        <br>
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active"><a class="nav-link" href="/">Home<span class="sr-only">(current)</span></a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Statistics</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/do_stats.php">Do stats</a>
                            <a class="dropdown-item" href="/see_my_stats.php">See my stats</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/all_stats.php">All stats</a>
                        </div>
                    </li>
                    <?php if(!isset($_SESSION['auth'])){
                        echo '<li id="connection" class="dropdown">';
                        echo '<a class="nav-link dropdown-toggle" id="connection_nav" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Connection</a>';
                        echo '<div class="dropdown-menu" aria-labelledby="connection_nav">';
                        echo    '<a class="dropdown-item" href="../session/login.php">Login</a>';
                        echo    '<a class="dropdown-item" href="../session/register.php">Register</a>';
                        echo '</div></li>';
                    }else{
                        echo '<li id="connection"><a href="../session/logout.php" class="nav-link">Logout</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>

        <?php if(isset($_SESSION['flash'])): ?>
            <?php foreach($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?= $type; ?>">
                    <?= $message; ?>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
    </header>
    <main id="main">