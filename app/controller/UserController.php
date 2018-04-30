<?php

namespace Controller;

use Model\Dao\UserDao;
use Model\User;
use Model\Picture;
use model\Thumbnail;

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
                        'thumbs_profile' => $user['thumbs_profile'],
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

    // create and validates picture and thumb for user  photos - MAIN CALL #0

    // DO NOT DELETE
//    public function uploadProfilePhotos(){
//        $imgList = self::generateImages('photos');
//        if($imgList){
//            try{
//                $dao = UserDao::getInstance();
//                if($dao->insertUserImages($_SESSION['logged'], $imgList)){
//                    echo json_encode($imgList);
//                }
//            }
//            catch(\PDOException $e){
//                foreach ($imgList as $img){
//                    unset($img);
//                }
//                header('location:'.URL_ROOT.'/index/profile&error=' . $e->getMessage());
//            }
//        }
//
//    }

    // create and validates picture and thumb for user profile picture- MAIN CALL #0
    public function uploadProfilePic(){

        if(isset($_FILES['images']) && $_SERVER['REQUEST_METHOD'] == 'POST') {


            // section -> photos, profile, cover, albums, posts
            // this control if you are allowed to send single or many
            $section = 'profile';
            $formImages = $_FILES['images'];

            // validation
            // returns assoc array -> form key , status key , err key
            $validResult = self::imageValidation($formImages, $section);

            // if validation err or true / NOTE: wrong files or images wont stop
            if (isset($validResult['count_err'])) {
                $status['img_count_error'] = $validResult['count_err'];
                echo json_encode($status);
            } elseif (isset($validResult['form']) && empty($validResult['form']['name'])) {
                $status = array();
                $status['error'] = 'Failed to upload!';
                $status['info'] = $validResult['err'];
                echo json_encode($status);
            } elseif (isset($validResult['form'])) {
                $formImages = $validResult['form'];
                $imgObjects = self::generateImagesList($formImages, $section);

                // if img list generated
                if ($imgObjects) {

                    // if thumbnail generated
                    self::generateThumbnailsList($imgObjects, $section);

                    try {

                        $dao = UserDao::getInstance();

                        $newUserData = new User();
                        $newUserData->setId($_SESSION['logged']->getId());

                        // $imgObjects holds array with picture objects
                        $pic = $imgObjects[0]->getUrlOnDiskPicture();
                        $thumb = $imgObjects[0]->getUrlOnDiskThumb();

                        $newUserData->setProfilePic($pic);
                        $newUserData->setThumbsProfile($thumb);

                        if($dao->saveUserProfilePic($newUserData)){
                            $oldImgUrl = $_SESSION['logged']->getProfilePic();

                            if($oldImgUrl != $GLOBALS["male_default_picture"] &&
                                $oldImgUrl != $GLOBALS["female_default_picture"]){
                                $fileSplit = explode("/",$oldImgUrl);

                                $oldThumb = THUMBS_URI . $fileSplit[count($fileSplit)-1];

                                if(file_exists($oldImgUrl) && file_exists($oldThumb)){
                                    unlink($oldImgUrl);
                                    unlink($oldThumb);
                                }

                                $_SESSION['logged']->setProfilePic($pic);
                                $_SESSION['logged']->setThumbsProfile($thumb);
                            }
                            else{
                                $_SESSION['logged']->setProfilePic($pic);
                                $_SESSION['logged']->setThumbsProfile($thumb);
                            }

                            $response = [];
                            $response['success'] = true;
                            if (isset($validResult['err'])) {
                                $response['dataNotPassed'] = $validResult['err'];
                            }
                            $response['images']['full'] = $pic;
                            $response['images']['thumb'] = $thumb;
                            echo json_encode($response);
                        }

                    } catch (\PDOException $e) {
                        echo $e->getMessage();
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }

                } else {
                    echo "images not created";
                }
            } else {
                echo "Validation Error...";
            }
        }
        else{
           header('location:'.URL_ROOT.'/error/401');
        }
    }

    // this functions work for single or multi upload;

    // validate images - no direct call  !!! Depends on other function - #1
    public function imageValidation($formImages,$section){

        if(!isset($formImages)){
            header('location:'.URL_ROOT.'/index/main');
        }
        else {

            // folder validation create folder if not found folders // photos// fullsize/ thumbs
            if (!file_exists(UPLOAD_PHOTOS)) {
                if (mkdir(UPLOAD_PHOTOS)) {
                    if (!file_exists(UPLOAD_FULL_SIZE)) {
                        if (mkdir(UPLOAD_FULL_SIZE)) {

                        } else {
                            $msg = "fullsize folder fail";
                            header('location:' . URL_ROOT . '/index/profile&error=' . $msg);
                        }
                    }
                    if (!file_exists(UPLOAD_THUMBS)) {
                        if (mkdir(UPLOAD_THUMBS)) {

                        } else {
                            $msg = "Thumb folder failed";
                            header('location:' . URL_ROOT . '/index/profile&error=' . $msg);
                        }
                    }
                } else {
                    $msg = "photos folder error";
                    header('location:' . URL_ROOT . '/index/profile&error=' . $msg);
                }
            } else {
                if (!file_exists(UPLOAD_FULL_SIZE)) {
                    if (mkdir(UPLOAD_FULL_SIZE)) {

                    } else {
                        $msg = "fullsize folder fail";
                        header('location:' . URL_ROOT . '/index/profile&error=' . $msg);
                    }
                }
                if (!file_exists(UPLOAD_THUMBS)) {
                    if (mkdir(UPLOAD_THUMBS)) {

                    } else {
                        $msg = "Thumb folder failed";
                        header('location:' . URL_ROOT . '/index/profile&error=' . $msg);
                    }
                }
            }

            // count how many files are send, MAX 15 with -> type many
            // for profile and cover limit one

            switch ($section) {
                case 'profile':
                case 'cover':
                    $maxQuantity = 1;
                    $countFormImages = count($formImages['name']);
                    if ($countFormImages > $maxQuantity) {
                        $err['count_err'] = 'Profile and Cover picture upload limit is 1';
                        return $err;
                    }
                    break;
                case 'photos';
                case 'albums';
                case 'posts';
                    $maxQuantity = MAX_IMG_UPLOAD_PHOTOS;
                    $countFormImages = count($formImages['name']);
                    if ($countFormImages > $maxQuantity) {
                        $err['count_err'] = 'Too many files, maximum images upload at once is ' . MAX_IMG_UPLOAD_PHOTOS;
                        return $err;
                    }
                    break;

            }

            // marking which files are not the one allowed
            $blackList = array();
            $num = 0;
            foreach ($formImages['type'] as $idx => $mime) {
                if ($mime !== 'image/jpeg' && $mime !== 'image/png' && $mime !== 'image/gif') {

                    $blackList[$num]['idx'] = $idx;
                    $blackList[$num]['name'] = $formImages['name'][$idx];
                    $blackList[$num]['errors'][] = 'File type not allowed';
                    $num++;
                }

            }

            // check size for image
            $oldnum = 0;
            foreach ($formImages['size'] as $idx => $size) {
                if ($size > MAX_IMG_UPLOAD_PHOTO_SIZE) {


                    if (isset($blackList[$oldnum]) && $idx === $blackList[$oldnum]['idx']) {
                        $blackList[$num]['size'] = $formImages['name'][$idx];
                        $blackList[$num]['errors'][] = 'File too large, max ' .
                            formatBytes(MAX_IMG_UPLOAD_PHOTO_SIZE) . 'MB each photo';
                    } else {
                        $num = count($blackList);
                        $blackList[$num]['idx'] = $idx;
                        $blackList[$num]['name'] = $formImages['name'][$idx];
                        $blackList[$num]['errors'][] = 'File too large, max ' .
                            formatBytes(MAX_IMG_UPLOAD_PHOTO_SIZE) . ' each photo';

                    }
                }
                $oldnum++;
            }

            // unset not allowed files from original


            foreach ($formImages as &$item) {
                $count = 0;
                foreach ($item as $idx => $param) {
                    if ($idx > count($blackList) - 1) {
                        break;
                    }

                    unset($item[$blackList[$count]['idx']]);
                    $count++;

                }
                // reset array indexes
                $item = array_merge($item);
            }

            $data['status'] = true;
            $data['form'] = $formImages;
            $data['err'] = $blackList;

            return $data;
        }


    }

    // creates picture objects fill data and save to disk !!! Depends on other function - #2
    public function generateImagesList($imgList,$section)
    {
        if(!isset($imgList)){
            header('location:'.URL_ROOT.'/error/401');
        }
        else {


            $createdPics = array();

            $imgCount = count($imgList['name']);

            //creating empty pictures list
            for ($i = 0; $i < $imgCount; $i++) {
                $createdPics[] = new Picture();
            }

            // setting pictures properties from form
            foreach ($imgList as $key => $prop) {
                for ($x = 0; $x < count($prop); $x++) {
                    switch ($key) {
                        case "name":
                            $createdPics[$x]->setName($prop[$x]);
                            break;
                        case "type":
                            $createdPics[$x]->setType($prop[$x]);
                            break;
                        case "tmp_name":
                            $createdPics[$x]->setTmpFileUrl($prop[$x]);
                            break;
                        case "size":
                            $createdPics[$x]->setSize($prop[$x]);
                            break;
                    }
                }
            }

            // set other properties based on whats given + write img on disk
            foreach ($createdPics as $img) {
                // set picure mew name, !!! no extention onlu name
                $img->setNewName($_SESSION['logged']->getFirstName() . '-' . time() . '-' . uniqid() . '-' . $section);

                // set ext of the file only
                $splitFile = explode(".", $img->getName());
                $img->setExtension($splitFile[count($splitFile) - 1]);

                // set path, check and move new file on disk
                if (is_uploaded_file($img->getTmpFileUrl())) {
                    $pathfile = UPLOAD_FULL_SIZE . '/' . $img->getNewName() . "." . $img->getExtension();
                    if (move_uploaded_file($img->getTmpFileUrl(), $pathfile)) {
                        $img->setUrlOnDiskPicture($pathfile);
                    } else {
                        $error[] = "Files not moved!!!";
                    }
                } else {
                    $error[] = 'files not uploaded!!!';
                }
                //set dimensions
                $dim = getimagesize($img->getUrlOnDiskPicture());
                $img->setWidth($dim[0]);
                $img->setHeight($dim[1]);

            }

            if (!isset($error)) {
                return $createdPics;
            } else {
                return $stat['error'] = $error;
            }
        }
    }

    // create thumb object fill data from picture object, !!! Depends on other function #3
    // save small pic to db - insert url to thumbs in picture object
    public function generateThumbnailsList($picObjects){
        if(!isset($picObjects)){
            header('location:'.URL_ROOT.'/error/401');
        }
        else {

            $createdThumbs = array();

            $imgCount = count($picObjects);

            //creating empty pictures list
            for ($i = 0; $i < $imgCount; $i++) {
                $createdThumbs[] = new Thumbnail();
            }

            $objectIndex = 0;
            // array for imagecreatefrom function
            $ims = array();
            // array for imagecreatetruecolor function
            $nms = array();
            foreach ($createdThumbs as $thumb) {
                // set thumb mew name, !!! no extention onlu name
                $thumb->setNewName($picObjects[$objectIndex]->getNewName());

                // set ext of the file only
                $thumb->setExtension($picObjects[$objectIndex]->getExtension());


                if ($picObjects[$objectIndex]->getExtension() === 'jpg') {
                    $ims[$objectIndex] = imagecreatefromjpeg($picObjects[$objectIndex]->getUrlOnDiskPicture());
                } elseif ($picObjects[$objectIndex]->getExtension() === 'gif') {
                    $ims[$objectIndex] = imagecreatefromgif($picObjects[$objectIndex]->getUrlOnDiskPicture());

                } elseif ($picObjects[$objectIndex]->getExtension() === 'png') {
                    $ims[$objectIndex] = imagecreatefrompng($picObjects[$objectIndex]->getUrlOnDiskPicture());
                }

                // setHeight
                $thumb->setHeight(THUMB_SIZE);
                // setWidth
                $thumb->setWidth(floor($picObjects[$objectIndex]->getWidth() * ($thumb->getHeight() / $picObjects[$objectIndex]->getHeight())));
                $nms[$objectIndex] = imagecreatetruecolor($thumb->getWidth(), $thumb->getHeight());

                imagecopyresized($nms[$objectIndex], $ims[$objectIndex], 0, 0, 0, 0, $thumb->getWidth(), $thumb->getHeight(), $picObjects[$objectIndex]->getWidth(), $picObjects[$objectIndex]->getHeight());

                if ($thumb->getExtension() === 'jpg') {
                    imagejpeg($nms[$objectIndex], UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());

                    $thumb->setUrlOnDiskPicture(UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());
                } elseif ($thumb->getExtension() === 'gif') {
                    imagegif($nms[$objectIndex], UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());
                    $thumb->setUrlOnDiskPicture(UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());
                } elseif ($thumb->getExtension() === 'png') {
                    imagepng($nms[$objectIndex], UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());
                    $thumb->setUrlOnDiskPicture(UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());
                }

                $picObjects[$objectIndex]->setUrlOnDiskThumb($thumb->getUrlOnDiskPicture());

                $objectIndex++;
            }
        }

    }
}