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

    public function getUserPhotos(){
        $dao = UserDao::getInstance();
        $user_id = htmlentities($_GET['user_id']);
        $targetUser = new User();
        $targetUser->setId($user_id);
        $data = [];
        try{
            $data['data'] = $dao->getUserPhotos($targetUser);
        }
        catch (\PDOException $e){
            $data['PDO_error'] = $e->getMessage();
        }
        catch (\Exception $e){
            $data['exception'] = $e->getMessage();
        }
        echo json_encode($data['data']);
    }

//    public function addOnlyImage(){
//        if (!empty($_FILES) && $_FILES['file']["size"] < 1000000) {
//            if (0 < $_FILES['file']['error']) {
//                $message['file-firs-error'] = $_FILES['file']['error'];
//            } else {
//                $tmp_name = $_FILES['file']['tmp_name'];
//                $orig_name = $_FILES['file']['name'];
//            }
//
//            if (is_uploaded_file($tmp_name)) {
//                $exploded_name = explode(".", $orig_name);
//                $ext = $exploded_name[count($exploded_name) - 1];
//
//                $image_to_upload = "./uploads/users/photos/" . time() . "-" . $_SESSION['logged']->getId() . "." . $ext;
//                if (move_uploaded_file($tmp_name, $image_to_upload)) {
//                    $dao = UserDao::getInstance();
//                    try {
//
//                        if ($dao->insertSignleImage($_SESSION['logged'], $image_to_upload)) {
//
//                            $message['img_url'] = $image_to_upload;
//                        } else {
//                            $message['error'] = true;
//                        }
//
//                    } catch (\PDOException $e) {
//                        $message['pdo_error'] = $e->getMessage();
//                    } catch (\Exception $e) {
//                        $message['exeption'] = $e->getMessage();
//                    }
//
//                }
//                else {
//                    $message['move_error'] = "File not moves successfully";
//                }
//            }
//            else {
//                $message['upload_error'] = "File not uploaded successfully";
//            }
//        }
//        else {
//            $message['uplod_max'] = "File max upload size reach, no more than 1MB";
//        }
//        echo json_encode($message);
//    }

    public function searchUser() {
        $dao = UserDao::getInstance();
        $users = $dao->getAllUsers($_SESSION['logged']->getId());

        if (isset($_GET['search'])) {
            $searched_user = htmlentities($_GET['search']);
            $result = [];
            $found = false;
            $counter = 0;
            foreach ($users as $user) {
                $fullName = '';
                $fullName .= $user["first_name"];
                $fullName .= " ";
                $fullName .= $user['last_name'];
                if(strpos(strtolower($fullName), strtolower($searched_user)) === 0) {
                    $result[] = [
                        'id' => $user['id'],
                        'first_name' =>$user['first_name'],
                        'last_name' => $user['last_name'],
                        'profile_pic' => $user['profile_pic'],
                        'gender' => $user['gender']
                    ];
                    $found = true;
                    $counter++;
                }
                if ($counter == 6) {
                    break;
                }
            }
            if (!$found) {
                echo "Not found!";
            }else {
                echo json_encode($result);
            }
        }
    }
    // Generate images + thumbnail + valid + send to DB
    public function generateImages() {
        if(isset($_POST) && isset($_FILES)){
            $files = [];
            $save_path = './uploads/users/photos';
            $dir = '/fullsized/';

           // var_dump($_POST);
           // var_dump($_FILES['images']);

            if (!file_exists($save_path . '/fullsized') && !is_dir($save_path . '/fullsized')) {
                mkdir($save_path . '/fullsized');
                $dir = '/fullsized/';
            }
            if (!file_exists($save_path . '/thumbs') && !is_dir($save_path . '/thubs')) {
                mkdir($save_path . '/thumbs');
            }

            $fileArr = $_FILES['images'];
            $imgUrlList = array();
            $error = false;
            for($i = 0; $i < count($fileArr['name']); $i++){

                if(preg_match('/[.](jpg)|(gif)|(png)$/',$fileArr['name'][$i])){

                    $files[$i]['name'] = $fileArr['name'][$i];
                    $files[$i]['newName'] = $_SESSION['logged']->getFirstName().'-'
                        . time() . '-' . $files[$i]['name'];
                    $files[$i]['source'] = $fileArr['tmp_name'][$i];
                    $files[$i]['target'] = $save_path .$dir. $files[$i]['newName'];
                    //var_dump($files[$i]['target']);

                    if (is_uploaded_file($fileArr['tmp_name'][$i])) {
                        if(move_uploaded_file($files[$i]['source'], $files[$i]['target'])){
                            $imgUrlList[] = $files[$i]['target'];
                        }
                    }

                    self::generateThumbnail($files[$i]['newName']);

                }
            }
            if(!$error){
                try{
                    $dao = UserDao::getInstance();
                    if($dao->insertUserImages($_SESSION['logged'], $imgUrlList)){
                        echo json_encode($imgUrlList);
                    }
                }
                catch(\PDOException $e){
                    foreach ($imgUrlList as $img){
                        unset($img);
                    }
                    header('location:'.URL_ROOT.'/index/profile&error=' . $e);
                }
            }
           // var_dump($files);
        }
        else{
            $msg = 'Invalid action request';
            header('location:'.URL_ROOT.'/index/profile&error=' . $msg);
        }
    }

    // list of images - array
    public function uploadImagesValidation($images){

    }

    // generate thumbnail for uploaded images
    public function generateThumbnail($fileName){
        $thumbHeight = 150;
        $im = null;
        $save_path = './uploads/users/photos';
        $dir = '/fullsized/';
        $thumbs = '/thumbs/';
        if(preg_match('/[.]jpg$/', $fileName)){
            $im = imagecreatefromjpeg($save_path . $dir . $fileName);
        }
        elseif (preg_match('/[.]gif$/', $fileName)){
            $im = imagecreatefromgif($save_path . $dir . $fileName);

        }
        elseif (preg_match('/[.]png$/', $fileName)){
            $im = imagecreatefrompng($save_path . $dir . $fileName);
        }

        $ox = imagesx($im);
        $oy = imagesy($im);

        $ny = $thumbHeight;
        $nx =  floor($ox * ($thumbHeight / $oy));


        $nm = imagecreatetruecolor($nx,$ny);

        imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

        if(!file_exists($save_path . $thumbs)){
            if(mkdir($save_path . $thumbs)){
                self::checkThumbsExtention($nm,$save_path,$thumbs,$fileName);
            }
            else{
                $msg = "Thumbnail generator problem...";
                header('location:'.URL_ROOT.'/index/profile&error=' . $msg);
            }
        }
        else{
            self::checkThumbsExtention($nm,$save_path,$thumbs,$fileName);
        }

    }

    // check thumbs extension save method
    public function checkThumbsExtention($nm,$save_path,$thumbs,$fileName){
        if(preg_match('/[.]jpg$/', $fileName)){
            imagejpeg($nm, $save_path . $thumbs . $fileName);
        }
        elseif (preg_match('/[.]gif$/', $fileName)){
            imagegif($nm, $save_path . $thumbs . $fileName);

        }
        elseif (preg_match('/[.]png$/', $fileName)){
            imagepng($nm, $save_path . $thumbs . $fileName);
        }
    }

    public function sendImageListDb(){

    }

}