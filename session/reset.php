<?php
ob_start();
require_once '../inc/header.php';

if(isset($_GET['id']) && isset($_GET['token'])){
    require_once '../inc/db.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE id = :id AND reset_token = :token AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
    $req->execute(['id' => $_GET['id'], 'token' => $_GET['token']]);
    $user = $req->fetch();
    if($user){
        if(!empty($_POST)){
            if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
                $req = $pdo->prepare('UPDATE users SET password = :password, reset_token = NULL, reset_at = NULL');
                $req->execute(['password' => md5($_POST['password'])]);
                session_start();
                $_SESSION['flash']['success'] = 'Your password has been updated';
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();
            }
        }
    }else{
        session_start();
        $_SESSION['flash']['danger'] = "This token isn't valid anymore";
        header('Location: login.php');
        exit();
    }
}

?>

<h1>Reset your password</h1>

<form action="" method="post">
    <div class="form-group">
        <label for="password">New password</label>
        <input type="password" name="password" class="form-control">

        <label for="password_confirm">Confirm new password</label>
        <input type="password" name="password_confirm" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Reset password</button>
</form>

