<?php
use \model\Dao\UserDao;
use \model\User;
require_once "../include/default_paths.php";

function __autoload($class) {
    $class = "..\\" . $class;
    require_once str_replace("\\", "/", $class) . ".php";
}

if (isset($_POST['register'])) {
    $first_name = htmlentities($_POST['first_name']);
    $last_name = htmlentities($_POST['last_name']);
    $email = htmlentities($_POST['email']);
    $password = htmlentities(sha1($_POST['password']));
    $confirm_pass = htmlentities(sha1($_POST['confirm_pass']));
    $gender = htmlentities($_POST['gender']);
    $pdo = new UserDao();

    if($gender == "male"){
        $profile_pic = $GLOBALS['male_default_picture'];

    }
    elseif($gender == "female"){
        $profile_pic = $GLOBALS['female_default_picture'];

    }
    else{
        $profile_pic = "no picture/no gender";
    }

    $birthday = htmlentities($_POST['b_day']);
    $cover_pic = $GLOBALS['default_cover_pic'];

    $error = false;
    $success = false;

    if ($pdo->regUserExist($email)) {
        $error = 'Email already exists! Please try another.';
        header("location: ../view/register.php?error=" . htmlentities($error));
    }
    elseif($password !== $confirm_pass) {
        $error = 'Password miss match!';
        header("location: ../view/register.php?error=" . htmlentities($error));
    }
    elseif(empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_pass) || empty($gender) || empty($birthday)) {
        $error = 'All inputs are required! Please fill in them';
        header("location: ../view/register.php?error=" . htmlentities($error));
    }
    else {
        $user = new User($first_name, $last_name, $email, $password, $gender, $birthday, $profile_pic, $cover_pic);
        $pdo->register($user);
        $success = 'Successfuly registered!';
        header("location: ../view/register.php?success=" . htmlentities($success));
    }
}
