<?php

use \model\Dao\UserDao;
require_once '../include/session.php';
function __autoload($class) {
    $class = "..\\" . $class;
    require_once str_replace("\\", "/", $class) . ".php";
}

if (isset($_POST['login'])) {
    $email = trim(htmlentities($_POST['email']));
    $password = trim(htmlentities(sha1($_POST['password'])));
    $error = false;
    $pdo = new UserDao();

    if (empty($email) || empty($password)) {
        $error = "All fields are required! Please fill in them";
        header("location: ../view/login.php?error=" . htmlentities($error));
    }
    elseif($pdo->userPassCheck($email, $password)) {
        $pdo->loginSession($email, $password);
        header('location: ../view/main.php');
    }
    else {
        $error = 'Wrong email or password!';
        header("location: ../view/login.php?error=" . htmlentities($error));
    }
}