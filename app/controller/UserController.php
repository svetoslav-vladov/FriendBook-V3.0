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

            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            if(empty($email) || empty($password)) {
                $error = 'All inputs are required! Please fill in them';
            }
            elseif(strlen(trim($email)) == 0 || strlen(trim($password)) == 0){
                $error = 'No empty inputs...';
            }

            if(!isset($error)){
                $dao = UserDao::getInstance();
                $user = new User();
                $user->setEmail($email);
                $user->setPassword(sha1($password));

                try{
                    // check if login is true, select to all user data
                    $result = $dao->loginCheck($user);

                    if($result){
                        // function from stdClass to model\User Class - app/include/functions.php
                        cast($user,$result);

                        $user->setPassword(null);
                        $user->setFullName($user->getFirstName() ." ". $user->getLastName());

                        $success = "login successfully";
                        $_SESSION['logged'] = $user;
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
                header('location:'.URL_ROOT.'/index/login&error=' . $error);
            }
        }
        else{
            $msg = "Wrong action... please fill the form!";
            header('location:'.URL_ROOT.'/index/login&error=' . $msg);
        }
    }

    public function register(){
        $requestType = $_SERVER['REQUEST_METHOD'];

        if($requestType == 'POST'){
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
            $user = new User();
            $user->setEmail($email);

            $checkUserExists = $dao->checkIfExists($user);

            if ($checkUserExists) {
                $error = 'Username is already taken.';
            }
            elseif($pass !== $pass_valid) {
                $error = 'Passwords differ, miss match!';
            }
            elseif(empty($firstname) || empty($lastname) || empty($email) || empty($pass) ||
                empty($pass_valid) || empty($gender) || empty($birthday)) {
                $error = 'All inputs are required! Please fill in them';
            }
            elseif(strlen(trim($firstname)) == 0 || strlen(trim($lastname)) == 0 || strlen(trim($email)) == 0
                || strlen(trim($pass)) == 0|| strlen(trim($pass_valid)) == 0
                || strlen(trim($gender)) == 0 || strlen(trim($birthday)) == 0) {
                $error = 'No empty fields allowed!!!';
            }
            try{
                if(!isset($error)){
                    $user = new User();
                    $user->setFirstName($firstname);
                    $user->setLastName($lastname);
                    $user->setEmail($email);
                    $user->setPassword(sha1($pass));
                    $user->setGender($gender);
                    $user->setBirthday($birthday);
                    $user->setProfileCover($cover_pic);
                    $user->setProfilePic($profile_pic);

                    $insert = $dao->insertUserDb($user);

                    if($insert){
                        $success = "Registered successfully";
                        header('location:'.URL_ROOT.'/index/login&success=' . $success);
                    }
                }
                else{
                    header('location:'.URL_ROOT.'/index/register&error=' . $error);
                }
            }
            catch (\PDOException $e){
                header('location:'.URL_ROOT.'/index/register&error=' . $e->getMessage());
            }
            catch (\Exception $e){
                header('location:'.URL_ROOT.'/index/register&error=' . $e->getMessage());
            }
        }
        else{
            $msg = "Wrong action... please fill the form!";
            header('location:'.URL_ROOT.'/index/register&error=' . $msg);
        }

    }

    public function getUserInfo(User $user){
        $dao = UserDao::getInstance();
        $result = $dao->getUserInfoById($user);
        try{
            if($result){

                cast($user,$result);
                $user->setPassword(null);
                $user->setFullName($user->getFirstName() . " " . $user->getLastName());
                return $user;
            }
            else{
                // return false if no user with that id
                return false;
            }
        }
        catch (\PDOException $e){
            header('location:'.URL_ROOT.'/index/profile&error=' . $e->getMessage());
        }
    }

    public function getUserPhotos($userId){
        echo 'yes controller';
    }


}