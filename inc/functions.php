<?php

function debug($var){
    echo '<pre>' . print_r($var, true) . '</pre>';
}

function str_random($length){
    $string = "0123456789azertyuiopmlkjhgfdsqwxcvbnAZERTYUIOPMLKJHGFDSQWXCVBN";
    return substr(str_shuffle(str_repeat($string, 15)), 0, $length);
}

function login_needed(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['auth'])){
        $_SESSION['flash']['danger'] = 'Login yourself before';
        header('Location: login.php');
        exit();
    }
}