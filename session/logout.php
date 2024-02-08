<?php
ob_start();
session_start();
//session_destroy();
unset($_SESSION['auth']);

$_SESSION['flash']['warning'] = 'You have been disconnected';

header('Location: ../session/login.php');
exit();