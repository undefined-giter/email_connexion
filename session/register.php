<?php
ob_start();
require_once '../inc/db.php';
require_once '../inc/functions.php';
session_start();

//mail('leo.ripert@gmail.com', 'Rent', "valid");
if(!empty($_POST)){
    $errors = [];

    if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_-]+$/', $_POST['username'])){
        $errors['username'] = "Your pseudo isn't valid";
    } else{
        $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        if($user){
            $errors['username'] = "This pseudo is already taken";
        }
    }

    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Your mail isn't valid";
    }

    $req = $pdo->prepare('SELECT email FROM users WHERE email = :email');
    $req->execute(['email' => $_POST['email']]);
    $mail = $req->fetch();
    if($mail){
        $errors['already_bind_email'] = "You already have an account"; // -> Bad security
    }

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $errors['password'] = "Your password is invalid";
    }

    if(empty($errors)){
        $req = $pdo->prepare("INSERT INTO users (username, email, password, validation_token) VALUES (:username, :email, :password, :validation_token)");
        $req->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $req->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $req->bindParam(':password', $pass, PDO::PARAM_STR);
        $req->bindParam(':validation_token', $token, PDO::PARAM_STR);
        $pass = md5($_POST['password']);
        $token = str_random(50);
        $req->execute();
        //die('You have been registered');

        $user_id = $pdo->lastInsertId();

        $pseudo = $_POST['username'];
        mail($_POST['email'], 'Registered account', "Hi $pseudo,\nTo valid your account, click here\n\nhttp://127.0.0.1:8000/session/confirm_passwd.php?id=$user_id&token=$token", 'leo.ripert@gmail.com');

        $_SESSION['flash']['success'] = 'A confirmation email have been sent to you';

        header('Location: login.php');
        exit();
    }
}
?>
<?php require_once('../inc/header.php'); ?>

<h1>Register</h1>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <p>We detected some errors :</p>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="" method="POST">
    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" class="form-control" required/>
    </div>

    <div class="form-group">
        <label for="">Email</label>
        <input type="text" name="email" class="form-control" required/>
    </div>

    <div class="form-group">
        <label for="">Password</label>
        <input type="password" name="password" class="form-control" required/>
    </div>

    <div class="form-group">
        <label for="">Confirm password</label>
        <input type="password" name="password_confirm" class="form-control" required/>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
</form>
<?php require_once('../inc/footer.php'); ?>