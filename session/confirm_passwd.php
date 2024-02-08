<?php
ob_start();

$user_id = $_GET['id'];
$token = $_GET['token'];
require_once '../inc/db.php';

$req = $pdo->prepare('SELECT validation_token FROM users WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();
session_start();

if($user && $user->validation_token == $token){
    // We delete the old token, once verified he would be useless
    $req = $pdo->prepare('UPDATE users SET validation_token = NULL, confirm_at = NOW() WHERE id = ?');
    $req->execute([$user_id]);

    $_SESSION['auth'] = $user;

    $_SESSION['flash']['success'] = 'Your account has been successfully verified';

    $_SESSION['auth']->id = $_GET['id'];

    header('Location: account.php');
    exit();
}else{
    $_SESSION['flash']['danger'] = 'This token isn\'t valid anymore';
    header('Location: login.php');
    exit();
}