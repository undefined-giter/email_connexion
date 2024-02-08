<?php
ob_start();

if(!empty($_POST) && !empty($_POST['email'])){
    require_once '../inc/db.php';
    require_once '../inc/functions.php';
    
    $req = $pdo->prepare('SELECT * FROM users WHERE email = :email AND confirm_at IS NOT NULL');
    $req->execute(['email' => $_POST['email']]);
    $user = $req->fetch();
    if($user){
        session_start();
        $reset_token = str_random(50);
        $rq = $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?');
        $rq->execute([$reset_token, $user->id]);
        $_SESSION['flash']['success'] = 'You should receive an email to reset your password';
        mail($_POST['email'], 'StatWorld - Reset your password', "You asked to reset your password, please follow this link :\n\nhttp://127.0.0.1:8000/session/reset.php?id={$user->id}&token=$reset_token");
        header('Location: login.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = 'There is no account liked to this email';
    }
}

require_once '../inc/header.php';
?>

<h1>Forgot your password ?</h1>

<p>Receives a link to reset your password</p>

<form action="" method="POST">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" placeholder="Enter your email">

    <button type="submit" class="btn btn-primary">Ok</button>
</form>




<?php require_once '../inc/footer.php'; ?>