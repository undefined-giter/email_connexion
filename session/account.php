<?php
require_once '../inc/functions.php';
login_needed();

if(!empty($_POST)){
    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $_SESSION['flash']['danger'] = 'Both passwords does not match';
    }else{
        $password = md5($_POST['password']);
        require_once '../inc/db.php';
        $req = $pdo->prepare('UPDATE users SET password = :password WHERE id = :user_id');
        if(isset($_SESSION['auth']->id)){
            $req->execute(['password' => md5($_POST['password']), 'user_id' => $_SESSION['auth']->id]);
        }else{
            $req->execute(['password' => md5($_POST['password']), 'user_id' => $_GET['id']]);
        }
        $_SESSION['flash']['success'] = 'Your password has been correctly updated';
    }
}

require_once '../inc/header.php';
?>

    <h1>Account</h1>

    <ul>
        <?php if(isset($_SESSION['auth']->username)): ?>
            <li class='noDot'>&rarr; Welcome <?= ucfirst($_SESSION['auth']->username); ?></li>
        <?php endif; ?>
        <!--< ?php foreach($_SESSION['auth'] as $key => $pseudo){if($key == 'username'){echo ucfirst($pseudo) . ' !';}} ?>-->
    </ul>

    <form action="" method="POST">
        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Change password">
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="password_confirm" placeholder="Confirm new password">
        </div>
        <button class="btn btn-primary">Change password</button>
    </form>

<?php require_once '../inc/footer.php'; ?>