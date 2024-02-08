<?php
ob_start();
error_reporting(E_ERROR | E_PARSE);
require '../inc/header.php';

if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    require_once '../inc/db.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE username = :username OR email = :username');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();
    //require_once '../inc/functions.php';
    // debug(md5($_POST['password']));
    // debug($user->password);
    if(md5($_POST['password']) == $user->password && $user->confirm_at != NULL){
        $_SESSION['flash']['success'] = 'You\'r connected';
        $_SESSION['auth'] = $user;
        header('Location: account.php');
        exit();
    }elseif((md5($_POST['password']) == $user->password || $_POST['password'] == $user->email) && $user->confirm_at == NULL){
        echo "<div class='alert alert-warning'>";
        echo    'You must confirm your email before';
        echo "</div>";
    }else{
        //$_SESSION['flash']['danger'] =
        echo "<div class='alert alert-danger'>";
        echo    'Email, pseudo or password incorrect';
        echo "</div>";
    }
}
?>

<h1>Login</h1>
<br>
<form action="" method="POST">
    <div class="form-group">
        <label for="">Email or pseudo</label>
        <input type="text" name="username" class="form-control" required/>
    </div>

    <div class="form-group">
        <label for="">Password</label>
        <input type="password" name="password" class="form-control" required/>
        <a id="forgot_pass" href="/session/forgot.php">Forgot password ?</a>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php require_once '../inc/footer.php'; ?>
 