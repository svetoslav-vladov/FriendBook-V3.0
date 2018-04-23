<?php

namespace Controller;

use Model\Dao\UserDao;
use Model\User;

class UserController extends BaseController {

    public function logout(){
        if(isset($_SESSION['logged'])){
            $requestType = $_SERVER['REQUEST_METHOD'];
            if($requestType == 'GET'){
                session_destroy();
                header('location:'.URL_ROOT.'/index/login');
            }
            else{
                $msg = "Wrong action...!";
                header('location:'.URL_ROOT.'/index/main&error=' . $msg);
            }
        }
        else{
            $msg = "You are not logged in to logout!";
            header('location:'.URL_ROOT.'/index/login&error=' . $msg);
        }

    }
    public function login(){

        $requestType = $_SERVER['REQUEST_METHOD'];
        if($requestType == 'POST'){
            $errors = false;
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            if(empty($email) || empty($password)) {
                $error[] = 'All inputs are required! Please fill in them';
                $errors = true;
            }
            elseif(strlen(trim($email)) == 0 || strlen(trim($password)) == 0){
                $error[] = 'No empty inputs...';
                $errors = true;
            }

            if(!$errors){
                try{
                    $loginDao = UserDao::getInstance();
                    $user = new User();
                    $user->setEmail($email);
                    $user->setPassword(sha1($password));

                    $result = $loginDao->loginCheck($user);

                    if($result){
                        $db_user_data = $loginDao->getUserByEmail($email);
                        $success = "login successfully";
                        $_SESSION['logged'] = $db_user_data;
                        $_SESSION['logged']['full_name'] = $db_user_data['first_name'] . " " . $db_user_data['last_name'];
                        header('location:'.URL_ROOT.'/index/main&success=' . $success);
                    }
                    else{
                        $nosuccess = "Wrong email or password";
                        header('location:'.URL_ROOT.'/index/login&error=' . $nosuccess);
                    }
                }
                catch (\PDOException $e){
                    header('location:'.URL_ROOT.'/index/login&error=' . $e->getMessage());
                }
                catch(\Exception $e){
                    header('location:'.URL_ROOT.'/index/login&error=' . $e->getMessage());
                }
            }
            else{
                header('location:'.URL_ROOT.'/index/login&error=' . $error[0]);
            }

        }
        else{
            $msg = "Wrong action... please fill the form!";
            header('location:'.URL_ROOT.'/index/login&error=' . $msg);
        }
    }

    public function register(){
        $requestType = $_SERVER['REQUEST_METHOD'];
        try{
            if($requestType == 'POST'){
                $errors = false;
                $firstname = htmlentities($_POST['first_name']);
                $lastname = htmlentities($_POST['last_name']);
                $email = htmlentities($_POST['email']);
                $pass = htmlentities($_POST['password']);
                $pass_valid = htmlentities($_POST['confirm_pass']);
                $gender = htmlentities($_POST['gender']);
                $birthday = htmlentities($_POST['birthday']);
                // BETTER PHP validation NEEDED here

                if($gender == "male"){
                    $profile_pic = $GLOBALS['male_default_picture'];

                }
                elseif($gender == "female"){
                    $profile_pic = $GLOBALS['female_default_picture'];

                }
                else{
                    $profile_pic = "no picture/no gender";
                }

                $cover_pic = $GLOBALS['default_cover_pic'];

                $dao = UserDao::getInstance();
                $checkUserExists = $dao->checkIfExists($email);

                if ($checkUserExists) {
                    $error[] = 'Username is already taken.';
                    $errors = true;
                }
                elseif($pass !== $pass_valid) {
                    $error[] = 'Passwords differ, miss match!';
                    $errors = true;
                }
                elseif(empty($firstname) || empty($lastname) || empty($email) || empty($pass) ||
                        empty($pass_valid) || empty($gender) || empty($birthday)) {
                    $error[] = 'All inputs are required! Please fill in them';
                    $errors = true;
                }
                elseif(strlen(trim($firstname)) == 0 || strlen(trim($lastname)) == 0 || strlen(trim($email)) == 0
                    || strlen(trim($pass)) == 0|| strlen(trim($pass_valid)) == 0
                    || strlen(trim($gender)) == 0 || strlen(trim($birthday)) == 0) {
                    $error[] = 'No empty fields allowed!!!';
                    $errors = true;
                }

                if(!$errors && !isset($error)){
                    $user = new User();
                    $user->setFirstName($firstname);
                    $user->setLastName($lastname);
                    $user->setEmail($email);
                    $user->setPassword(sha1($pass));
                    $user->setGender($gender);
                    $user->setBirthday($birthday);
                    $user->setCoverPic($cover_pic);
                    $user->setProfilePic($profile_pic);

                    $insert = $dao->insert_user_db($user);

                    if($insert){
                        $success = "Registered successfully";
                        header('location:'.URL_ROOT.'/index/login&success=' . $success);
                    }
                }
                else{
                    header('location:'.URL_ROOT.'/index/register&error=' . $error[0]);
                }
            }
            else{
                $msg = "Wrong action... please fill the form!";
                header('location:'.URL_ROOT.'/index/register&error=' . $msg);
            }
        }
        catch (\PDOException $e){
            header('location:'.URL_ROOT.'/index/register&error=' . $e->getMessage());
        }
        catch (\Exception $e){
            header('location:'.URL_ROOT.'/index/register&error=' . $e->getMessage());
        }
    }

}