<?php

namespace Controller;

use Model\Dao\UserDao;
use Model\User;
use Model\Picture;
use Model\Thumbnail;

class UserController extends BaseController{

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

                        $_SESSION['logged'] = $user;

                        header('location:'.URL_ROOT.'/index/main');
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

            $checkUserExists = $dao->checkIfExistsEmail($user->getEmail());

            if ($checkUserExists) {
                $error = 'Username is already taken.';
            }
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format!";
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
        if(isset($user)) {

            $dao = UserDao::getInstance();
            $result = $dao->getUserInfoById($user);
            try {
                if ($result) {

                    cast($user, $result);
                    $user->setPassword(null);
                    $user->setFullName($user->getFirstName() . " " . $user->getLastName());
                    return $user;
                } else {
                    // return false if no user with that id
                    return false;
                }
            } catch (\PDOException $e) {
                header('location:' . URL_ROOT . '/index/profile&error=' . $e->getMessage());
            }
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
                if(strstr(strtolower($fullName), strtolower($searched_user))) {
                    $result[] = [
                        'id' => $user['id'],
                        'first_name' => strtolower($user['first_name']),
                        'last_name' => strtolower($user['last_name']),
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
    public function uploadProfilePhotos(){

        if(isset($_FILES['images']) && $_SERVER['REQUEST_METHOD'] == 'POST') {


            // mode -> photos, profile, cover, albums, posts
            // this control if you are allowed to send single or many
            $mode = 'photos';
            $formImages = $_FILES['images'];

            // validation
            // returns assoc array -> form key , status key , err key
            $validResult = parent::imageValidation($formImages, $mode);

            // if validation err or true / NOTE: wrong files or images wont stop
            if (isset($validResult['count_err'])) {
                $status['img_count_error'] = $validResult['count_err'];
                echo json_encode($status);
            }
            elseif (isset($validResult['form']) && empty($validResult['form']['name'])) {
                $status = array();
                $status['error'] = 'Failed to upload!';
                $status['info'] = $validResult['err'];
                echo json_encode($status);
            }
            elseif (isset($validResult['form'])) {
                $formImages = $validResult['form'];
                $imgObjects = parent::generateImagesList($formImages, $mode);

                // if img list generated
                if ($imgObjects) {

                    //  thumbnail generated
                    parent::generateThumbnailsList($imgObjects, $mode);

                    $dao = UserDao::getInstance();
                    try {

                        if($dao->saveUserProfilePhotos($_SESSION['logged'],$imgObjects)){
                            $response = [];
                            $response['success'] = true;
                            if (isset($validResult['err'])) {
                                $response['dataNotPassed'] = $validResult['err'];
                            }

                            foreach ($imgObjects as $idx=>$row){
                                $response['picture_object_data'][] = $imgObjects[$idx]->object_to_array($imgObjects[$idx]);
                            }
                            echo json_encode($response);

                        }

                    } catch (\PDOException $e) {
                        $status['error'] = $e->getMessage();
                        echo json_encode($status);
                    } catch (\Exception $e) {
                        $status['error'] = $e->getMessage();
                        echo json_encode($status);
                    }

                } else {
                    echo "images not created";
                }
            }
            else {
                echo "Validation Error...";
            }
        }
        else{
            header('location:'.URL_ROOT.'/error/401');
        }
    }

    // create album

    public function createAlbumPhotos(){
        if(isset($_FILES) && !is_array($_FILES['albumFiles']['name'])){
            $status['error'] = 'Wrong input type, mutiple files expected';
            echo json_encode($status);
        }
        elseif(isset($_FILES) && !count($_FILES['albumFiles']['name']) > 0){
            $status['error'] = 'Files input cannot be empty';
            echo json_encode($status);
        }

        if(isset($_POST['albumName']) && isset($_FILES['albumFiles']) && !isset($status['error'])){
            $albumName = htmlentities(trim($_POST['albumName']));

            $mode = 'albums';
            $formImages = $_FILES['albumFiles'];
            $status = array();

            if(!$albumName > 0){
                $status['error'] = "Album name cannot be empty";
            }
            if(!$albumName > 0){
                $status['error'] = "Album name cannot be empty";
            }

            if(!isset($status['error'])){
                // validation
                // returns assoc array -> form key , status key , err key
                $validResult = parent::imageValidation($formImages, $mode);

                // if validation err or true / NOTE: wrong files or images wont stop
                if (isset($validResult['count_err'])) {
                    $status['img_count_error'] = $validResult['count_err'];
                    echo json_encode($status);
                }
                elseif (isset($validResult['form']) && empty($validResult['form']['name'])) {
                    $status = array();
                    $status['error'] = 'Failed to upload!';
                    $status['info'] = $validResult['err'];
                    echo json_encode($status);
                }
                elseif (isset($validResult['form'])) {
                    $formImages = $validResult['form'];
                    $imgObjects = parent::generateImagesList($formImages, $mode);

                    // if img list generated
                    if ($imgObjects) {

                        //  thumbnail generated
                        parent::generateThumbnailsList($imgObjects, $mode);

                        $dao = UserDao::getInstance();
                        try {

                            if($dao->saveUserAlbumAndPhotos($_SESSION['logged']->getId(),$albumName,$imgObjects)){
                                $response = [];
                                $response['success'] = true;
                                if (isset($validResult['err'])) {
                                    $response['dataNotPassed'] = $validResult['err'];
                                }

                                foreach ($imgObjects as $idx=>$row){
                                    $response['picture_object_data'][] = $imgObjects[$idx]->object_to_array($imgObjects[$idx]);
                                }
                                echo json_encode($response);

                            }

                        } catch (\PDOException $e) {
                            $status['error'] = $e->getMessage();
                            echo json_encode($status);
                        } catch (\Exception $e) {
                            $status['error'] = $e->getMessage();
                            echo json_encode($status);
                        }

                    }
                    else {
                        echo "images not created";
                    }
                }
                else {
                    echo "Validation Error...";
                }
            }
            else{
                echo json_encode($status);
            }
        }
    }

    // create and validates picture and thumb for user profile picture- MAIN CALL #0
    public function uploadProfilePic(){

        if(isset($_FILES['images']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

            // mode -> photos, profile, cover, albums, posts
            // this control if you are allowed to send single or many
            $mode = 'profile';
            $formImages = $_FILES['images'];

            // validation
            // returns assoc array -> form key , status key , err key
            $validResult = self::imageValidation($formImages, $mode);

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
                $imgObjects = self::generateImagesList($formImages, $mode);

                // if img list generated
                if ($imgObjects) {

                    // if thumbnail generated
                    self::generateThumbnailsList($imgObjects, $mode);

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

                                if(file_exists($oldImgUrl)) {
                                    unlink($oldImgUrl);
                                }
                                if(file_exists($oldThumb)){
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

    public function uploadProfileCover(){

        if(isset($_FILES['images']) && $_SERVER['REQUEST_METHOD'] == 'POST') {


            // mode -> photos, profile, cover, albums, posts
            // this control if you are allowed to send single or many
            $mode = 'cover';
            $formImages = $_FILES['images'];

            // validation
            // returns assoc array -> form key , status key , err key
            $validResult = self::imageValidation($formImages, $mode);

            // if validation err or true / NOTE: wrong files or images wont stop
            if (isset($validResult['count_err'])) {
                $status['img_count_error'] = $validResult['count_err'];
                echo json_encode($status);
            }
            elseif (isset($validResult['form']) && empty($validResult['form']['name'])) {
                $status = array();
                $status['error'] = 'Failed to upload!';
                $status['info'] = $validResult['err'];
                echo json_encode($status);
            }
            elseif (isset($validResult['form'])) {

                $formImages = $validResult['form'];
                $imgObjects = self::generateImagesList($formImages, $mode);

                // if img list generated
                if ($imgObjects) {

                    // if thumbnail generated
                    self::generateThumbnailsList($imgObjects, $mode);

                    try {

                        $dao = UserDao::getInstance();

                        $newUserData = new User();
                        $newUserData->setId($_SESSION['logged']->getId());

                        // $imgObjects holds array with picture objects
                        $pic = $imgObjects[0]->getUrlOnDiskPicture();
                        $thumb = $imgObjects[0]->getUrlOnDiskThumb();

                        $newUserData->setProfileCover($pic);
                        $newUserData->setThumbsCover($thumb);

                        if($dao->saveUserProfileCover($newUserData)){
                            $oldImgUrl = $_SESSION['logged']->getProfileCover();

                            if($oldImgUrl != $GLOBALS["default_cover_pic"]){
                                $fileSplit = explode("/",$oldImgUrl);

                                $oldThumb = THUMBS_URI . $fileSplit[count($fileSplit)-1];

                                if(file_exists($oldImgUrl) && file_exists($oldThumb)){
                                    unlink($oldImgUrl);
                                    unlink($oldThumb);
                                }

                                $_SESSION['logged']->setProfileCover($pic);
                                $_SESSION['logged']->setThumbsCover($thumb);
                            }
                            else{
                                $_SESSION['logged']->setProfileCover($pic);
                                $_SESSION['logged']->setThumbsCover($thumb);
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

    //function for send request for friend
    public function sendFriendRequest() {
        $dao = UserDao::getInstance();
        $approved = 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $requested_by = $_SESSION['logged']->getId();
            $requester_id = htmlentities($_POST['requester_id']);
            try{
                $dao->sendFriendRequest($requested_by, $requester_id, $approved);
                $status['success'] = true;
                echo json_encode($status);
            }
            catch (\PDOException $e){
                $status['err'] = $e->getMessage();
                echo json_encode($status);
            }
        }
    }

    //function for cancel request for friend
    public function cancelFriendRequest() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $requested_by = $_SESSION['logged']->getId();
            $requester_id = htmlentities($_POST['requester_id']);
            try{
                $dao->cancelFriendRequest($requested_by, $requester_id);
                $status['success'] = true;
                echo json_encode($status);
            }
            catch (\PDOException $e){
                    $status['err'] = $e->getMessage();
                    echo json_encode($status);
            }
        }
    }

    public function saveGeneralSettings(){
        if(isset($_POST['data'])){
            // working with objects
            $data = json_decode($_POST['data']);
        }

        if(isset($_POST['general']) && count($_POST['data'])>0){

            $first_name = htmlentities($data->first_name);
            $last_name = htmlentities($data->last_name);
            $display_name = htmlentities($data->display_name);
            $relation_status = htmlentities($data->relation_status);
            $gender = htmlentities($data->gender);
            $birthday = htmlentities($data->birthday);
            $country = htmlentities($data->country);
            $website = htmlentities($data->website);
            $mobile_number = htmlentities($data->mobile_number);
            $skype_name = htmlentities($data->skype_name);

            $loggedUsr = $_SESSION['logged'];

            $newUserInfo = clone $_SESSION['logged'];

            $status = [];
            var_dump(strlen($_POST['data']));

            // THIS IFs have to modify them with something more dynamic for or fore
            if(strlen(trim($first_name)) > 0){
                $newUserInfo->setFirstName($data->first_name);
            }

            if(strlen(trim($last_name)) > 0){
                $newUserInfo->setLastName($data->last_name);
            }

            if(strlen(trim($gender)) > 0){
                $newUserInfo->setGender($data->gender);
            }

            if(strlen(trim($birthday)) > 0 ){
                $newUserInfo->setBirthday($data->birthday);
            }

            if(strlen(trim($country)) > 0 ){
                $newUserInfo->setCountryId($data->country);
            }

            if(strlen(trim($relation_status)) > 0){
                $newUserInfo->setRelationshipId($data->relation_status);
            }

            if(strlen(trim($display_name)) > 0){
                $newUserInfo->setDisplayName($data->display_name);
            }

            if(strlen(trim($mobile_number)) > 0){
                $newUserInfo->setMobileNumber($data->mobile_number);
            }

            if(strlen(trim($website)) > 0){
                $newUserInfo->setWww($data->website);
            }

            if(strlen(trim($skype_name)) > 0){
                $newUserInfo->setSkype($data->skype_name);
            }
            var_dump($_POST['data']);
            if($newUserInfo != $loggedUsr){
                try{
                    $dao = UserDao::getInstance();
                    // passing new user info which is cloned from session

                    if($dao->saveUserGeneralSettings($newUserInfo)){

                        $newUserInfo = $dao->getFullUserInfoById($loggedUsr);

                        // this is setting = object from db with User Class
                        cast($_SESSION['logged'],$newUserInfo);
                        $fullname = $_SESSION['logged']->getFirstName() . " " . $_SESSION['logged']->getLastName();
                        $_SESSION['logged']->setFullName($fullname);
                        $_SESSION['logged']->setPassword('');
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                $status['errors'] = 'No Changes saved!!!';
                echo json_encode($status);
            }
        }
        else{
            $msg = 'Wrong action...';
            header('location:'.URL_ROOT.'/index/login&error=' . $msg);
        }
    }

    // GENERAL SETTINGS PAGE
    public function changeFirstName(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['firstName'])){

            $firstName = htmlentities(trim($_POST['firstName']));
            $status = array();

            if($firstName === $_SESSION['logged']->getFirstName()){
                $status['errors'] = 'No changes made!';
            }
            elseif(!(mb_strlen($firstName) > 0)){
                $status['errors'] = 'Input cannot be empty';
            }
            elseif (mb_strlen($firstName) > 15){
                $status['errors'] = 'Input cannot be more than 15 characters';
            }

            if(!isset($status['errors'])){

                $dao = UserDao::getInstance();

                try{
                    if($dao->saveFirstName($_SESSION['logged']->getId(),$firstName)){

                        $fullName = $firstName . " " . $_SESSION['logged']->getLastName();
                        $_SESSION['logged']->setFullName($fullName);
                        $_SESSION['logged']->setFirstName($firstName);

                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }
    public function changeLastName(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['lastName'])){

            $lastName = htmlentities(trim($_POST['lastName']));
            $status = array();

            if($lastName === $_SESSION['logged']->getLastName()){
                $status['errors'] = 'No changes made!';
            }
            elseif(!(mb_strlen($lastName) > 0)){
                $status['errors'] = 'Input cannot be empty';
            }
            elseif (mb_strlen($lastName) > 15){
                $status['errors'] = 'Input cannot be more than 15 characters';
            }

            if(!isset($status['errors'])){

                $dao = UserDao::getInstance();

                try{
                    if($dao->saveLastName($_SESSION['logged']->getId(),$lastName)){

                        $fullName = $_SESSION['logged']->getFirstName() . " " . $lastName;
                        $_SESSION['logged']->setLastName($lastName);
                        $_SESSION['logged']->setFullName($fullName);

                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }
    public function changeDisplayName(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['displayName'])){

            $displayName = htmlentities(trim($_POST['displayName']));
            $status = array();

            if($displayName === $_SESSION['logged']->getDisplayName()){
                $status['errors'] = 'No changes made!';
            }
            elseif(!(mb_strlen($displayName) > 0)){
                $status['errors'] = 'Input cannot be empty';
            }
            elseif (mb_strlen($displayName) > 20){
                $status['errors'] = 'Input cannot be more than 20 characters';
            }

            if(!isset($status['errors'])){

                $dao = UserDao::getInstance();

                try{
                    if($dao->saveDisplayName($_SESSION['logged']->getId(),$displayName)){
                        $_SESSION['logged']->setDisplayName($displayName);
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }

    public function changeRelationship(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['relationStatus'])){

            $relationshipId = htmlentities(trim($_POST['relationStatus']));
            $status = array();

            if($relationshipId === $_SESSION['logged']->getRelationshipId()){
                $status['errors'] = 'No changes made!';
            }
            elseif(!(mb_strlen($relationshipId) > 0)){
                $status['errors'] = 'Input cannot be empty';
            }
            elseif (!is_numeric($relationshipId)){
                $status['errors'] = 'Wrong Input value';
            }

            if(!isset($status['errors'])){

                $dao = UserDao::getInstance();

                try{


                    if($dao->saveRelationshipId($_SESSION['logged']->getId(),$relationshipId)){
                        $relation_name = $dao->getRelationshipStatus($_SESSION['logged']->getId());

                        $_SESSION['logged']->setRelationshipId($relationshipId);
                        $_SESSION['logged']->setRelationshipTag($relation_name->status_name);
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }
    public function changeGender(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['gender'])){

            $gender = htmlentities(trim($_POST['gender']));
            $status = array();

            if($gender === $_SESSION['logged']->getGender()){
                $status['errors'] = 'No changes made!';
            }
            elseif(!(mb_strlen($gender) > 0)){
                $status['errors'] = 'Input cannot be empty';
            }
            elseif ($gender !== "male" && $gender !== "female"){
                $status['errors'] = 'Wrong Input value,must be male or female';
            }

            if(!isset($status['errors'])){

                $dao = UserDao::getInstance();

                try{

                    if($dao->saveGender($_SESSION['logged']->getId(),$gender)){

                        $_SESSION['logged']->setGender($gender);
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }
    public function changeBirthday(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['birthday'])){

            $birthday = htmlentities(trim($_POST['birthday']));
            $status = array();

            $dateInput = strtotime($birthday);
            $todayDate = strtotime('now');

            if($birthday === $_SESSION['logged']->getBirthday()){
                $status['errors'] = 'No changes made!';
            }
            elseif(!(mb_strlen($birthday) > 0)){
                $status['errors'] = 'Input cannot be empty';
            }
            elseif ($dateInput > $todayDate){
                $status['errors'] = 'Date can go far than today';
            }


            if(!isset($status['errors'])){

                $dao = UserDao::getInstance();

                try{

                    if($dao->saveGender($_SESSION['logged']->getId(),$birthday)){

                        $_SESSION['logged']->setBirthday($birthday);
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }
    public function changeCountry(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['country'])){

            $countryId = htmlentities(trim($_POST['country']));
            $status = array();

            if($countryId === $_SESSION['logged']->getCountryId()){
                $status['errors'] = 'No changes made!';
            }
            elseif(!(mb_strlen($countryId) > 0)){
                $status['errors'] = 'Input cannot be empty';
            }
            elseif (!is_numeric($countryId)){
                $status['errors'] = 'Wrong Input value';
            }

            if(!isset($status['errors'])){

                $dao = UserDao::getInstance();

                try{


                    if($dao->saveCountryId($_SESSION['logged']->getId(),$countryId)){
                        $country = $dao->getCountryName($_SESSION['logged']->getId());

                        $_SESSION['logged']->setCountryId($countryId);
                        $_SESSION['logged']->setCountryName($country->country_name);
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }

    public function changeMobileNumber(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['mobileNumber'])){

            $mobileNumber = htmlentities(trim($_POST['mobileNumber']));
            $status = array();

            if($mobileNumber === $_SESSION['logged']->getMobileNumber()){
                $status['errors'] = 'No changes made!';
            }
            elseif(!(mb_strlen($mobileNumber) > 0)){
                $status['errors'] = 'Input cannot be empty';
            }
            elseif (mb_strlen($mobileNumber) > 20){
                $status['errors'] = 'Input cannot be more than 20 digits';
            }
            elseif (!preg_match('/^\d+$/', $mobileNumber)){
                $status['errors'] = 'Only Digits allowed';
            }

            if(!isset($status['errors'])){

                $dao = UserDao::getInstance();

                try{
                    if($dao->saveMobileNumber($_SESSION['logged']->getId(),$mobileNumber)){
                        $_SESSION['logged']->setMobileNumber($mobileNumber);
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }
    public function changeWebsite(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['webAddres'])){

            $webAddres = htmlentities(trim($_POST['webAddres']));
            $status = array();

            if($webAddres === $_SESSION['logged']->getWww()){
                $status['errors'] = 'No changes made!';
            }
            elseif(!(mb_strlen($webAddres) > 0)){
                $status['errors'] = 'Input cannot be empty';
            }
            elseif (mb_strlen($webAddres) > 40){
                $status['errors'] = 'Input cannot be more than 40 digits';
            }
// preg_match validation pattern in future
//            elseif (!preg_match('/^\$/', $webAddres)){
//                $status['errors'] = 'Only Digits allowed';
//            }

            if(!isset($status['errors'])){

                $dao = UserDao::getInstance();

                try{
                    if($dao->saveWebsite($_SESSION['logged']->getId(),$webAddres)){
                        $_SESSION['logged']->setWww($webAddres);
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }

    public function changeSkypeName(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['skypeName'])){

            $skypeName = htmlentities(trim($_POST['skypeName']));
            $status = array();

            if($skypeName === $_SESSION['logged']->getSkype()){
                $status['errors'] = 'No changes made!';
            }
            elseif(!(mb_strlen($skypeName) > 0)){
                $status['errors'] = 'Input cannot be empty';
            }
            elseif (mb_strlen($skypeName) > 40){
                $status['errors'] = 'Input cannot be more than 40 digits';
            }

            if(!isset($status['errors'])){

                $dao = UserDao::getInstance();

                try{
                    if($dao->saveWebsite($_SESSION['logged']->getId(),$skypeName)){
                        $_SESSION['logged']->setSkype($skypeName);
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }

    public function changeEmail(){

        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['email'])){

            $email = htmlentities(trim($_POST['email']));
            $password = htmlentities(trim($_POST['emailPassword']));
            $status = array();

            if($email === $_SESSION['logged']->getEmail()){
                $status['errors'] = 'No changes made!';
            }
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $status['errors'] = 'Not a valid email';
            }
            elseif(!(mb_strlen($email) > 0)){
                $status['errors'] = 'Email cannot be empty';
            }
            elseif (mb_strlen($email) > 40){
                $status['errors'] = 'Email cannot be more than 40 digits';
            }
            elseif(!(mb_strlen($password) > 0)){
                $status['errors'] = 'Password cannot be empty';
            }
            elseif (mb_strlen($password) > 40){
                $status['errors'] = 'Password cannot be more than 40 digits';
            }
            elseif (mb_strlen($password) < 2){
                $status['errors'] = 'Password cannot be less than 3 symbols';
            }

            $dao = UserDao::getInstance();

            if($dao->checkIfExistsEmail($email)){
                $status['denied'] = 'Save denied, email exists';
                echo json_encode($status);
            }
            elseif(!isset($status['errors'])){

                try{
                    if($dao->saveEmail($_SESSION['logged']->getId(),$email,sha1($password))){
                        $_SESSION['logged']->setEmail($email);
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied, password incorrect';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }

    public function changePassword(){

        if($_SERVER['REQUEST_METHOD'] === "POST" &&
            (isset($_POST['oldPass']) && isset($_POST['newPass']) && isset($_POST['newPassValid']))){

            $oldPass = htmlentities(trim($_POST['oldPass']));
            $newPass = htmlentities(trim($_POST['newPass']));
            $newPassValid = htmlentities(trim($_POST['newPassValid']));
            $status = array();

            if(!self::validPassLength($oldPass)){
                $res = self::validPassLength($oldPass);
                $status['errors'] = $res['error'];
            }
            if(!self::validPassLength($newPass)){
                $res = self::validPassLength($oldPass);
                $status['errors'] = $res['error'];
            }
            if(!self::validPassLength($newPassValid)){
                $res = self::validPassLength($newPassValid);
                $status['errors'] = $res['error'];
            }
            if($newPass !== $newPassValid){
                $status['errors'] = 'New Password do not match with password confirm';
                echo json_encode($status);
            }

            if(!isset($status['errors'])){
                $dao = UserDao::getInstance();
                try{
                    if($dao->savePassword($_SESSION['logged']->getId(),sha1($oldPass),sha1($newPass))){
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied, password incorrect';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                echo json_encode($status);
            }

        }

    }

    // DESCRIPTION SETTINGS PAGE
    public function saveDescriptionSettings(){
        if(isset($_POST['data'])){
            // working with objects
            $data = json_decode(trim(($_POST['data'])));
        }
        if(isset($_POST['description']) && count($_POST['data'])>0){

            $description = htmlentities($data->description);

            $loggedUsr = $_SESSION['logged'];

            $newUserInfo = clone $_SESSION['logged'];

            $status = [];

            // THIS IFs have to modify them with something more dynamic for or fore
            if(strlen($description) > 0 && strlen($description) < 1500){
                $newUserInfo->setDescription($data->description);
            }
            else{
                $status['errors'] = 'Length error';
                echo json_encode($status);
            }

            if($newUserInfo != $loggedUsr && !isset($status['errors'])){
                try{
                    $dao = UserDao::getInstance();
                    // passing new user info which is cloned from session

                    if($dao->saveUserDescriptionSettings($newUserInfo)){

                        $newUserInfo = $dao->getFullUserInfoById($loggedUsr);

                        // this is setting = object from db with User Class
                        cast($_SESSION['logged'],$newUserInfo);
                        $fullname = $_SESSION['logged']->getFirstName() . " " . $_SESSION['logged']->getLastName();
                        $_SESSION['logged']->setFullName($fullname);
                        $_SESSION['logged']->setPassword('');
                        $status['success'] = true;
                        echo json_encode($status);
                    }
                    else{
                        $status['denied'] = 'Save denied!!!';
                        echo json_encode($status);
                    }
                }catch (\PDOException $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }catch (\Exception $e){
                    $status['errors'] = $e->getMessage();
                    echo json_encode($status);
                }
            }
            else{
                $status['errors'] = 'No Changes saved!!!';
                echo json_encode($status);
            }
        }
        else{
            $msg = 'Wrong action...';
            header('location:'.URL_ROOT.'/index/login&error=' . $msg);
        }
    }

    public function getFriendRequests() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $user_id = $_SESSION['logged']->getId();
            echo json_encode($dao->getAllFriendRequests($user_id));
        }
    }

    public function declineFriendRequest() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $requested_by = $_SESSION['logged']->getId();
            $requester_id = htmlentities($_POST['requester_id']);
            try{
                $dao->cancelFriendRequest($requester_id, $requested_by);
                $status['success'] = true;
                echo json_encode($status);
            }
            catch (\PDOException $e){
                $status['err'] = $e->getMessage();
                echo json_encode($status);
            }
        }
    }

    public function acceptFriendRequest () {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $requester_id = $_SESSION['logged']->getId();
            $requested_by = htmlentities($_POST['requested_by']);
            try{
                $dao->acceptFriendRequest($requested_by, $requester_id);
                $status['success'] = true;
                echo json_encode($status);
            }
            catch (\PDOException $e){
                $status['err'] = $e->getMessage();
                echo json_encode($status);
            }
        }
    }

    public function checkForRequests() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $user_id = $_SESSION['logged']->getId();
            echo $dao->checkForFriendRequests($user_id);
        }
    }

    public function getSuggestedUsers() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            echo json_encode($dao->getSuggestedUsers($_SESSION['logged']->getId()));
        }
    }

    public function getFriends() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $user_id = htmlentities($_GET['user_id']);
            echo json_encode($dao->getFriends($user_id));
        }
    }

    public function getOwnFriends() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            echo json_encode($dao->getOwnFriends());
        }
    }

    public function deleteFriend() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $session_user_id = $_SESSION['logged']->getId();
            $friend_id = htmlentities($_POST['friend_id']);
            try{
                $dao->deleteFriend($friend_id, $session_user_id);
                $status['success'] = true;
                echo json_encode($status);
            }
            catch (\PDOException $e){
                $status['err'] = $e->getMessage();
                echo json_encode($status);
            }
        }
    }

    private function validPassLength($value){
        $status = array();
        if(mb_strlen($value) < 3 && mb_strlen($value) > 40){
            $status['error'] = 'Cannot be less than 3 or 40 characters';
            return $status;
        }
        else{
            return true;
        }
    }

    public function addNotificationOnLike() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_id = htmlentities($_SESSION['logged']->getId());
            $post_id = htmlentities($_POST['post_id']);
            $description = 'liked';
            try {
                $dao->addNotification($post_id, $user_id, $description);
                $status['success'] = true;
                echo json_encode($status);
            }catch (\PDOException $e) {
                $status['err'] = $e->getMessage();
                echo json_encode($status);
            }
        }
    }

    public function addNotificationOnDislike() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_id = htmlentities($_SESSION['logged']->getId());
            $post_id = htmlentities($_POST['post_id']);
            $description = 'disliked';
            try {
                $dao->addNotification($post_id, $user_id, $description);
                $status['success'] = true;
                echo json_encode($status);
            }catch (\PDOException $e) {
                $status['err'] = $e->getMessage();
                echo json_encode($status);
            }
        }
    }

    public function addNotificationOnComment() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_id = htmlentities($_SESSION['logged']->getId());
            $post_id = htmlentities($_POST['post_id']);
            $description = 'commented';
            try {
                $dao->addNotification($post_id, $user_id, $description);
                $status['success'] = true;
                echo json_encode($status);
            }catch (\PDOException $e) {
                $status['err'] = $e->getMessage();
                echo json_encode($status);
            }
        }
    }

    public function getAllNotifications() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $user_id = htmlentities($_SESSION['logged']->getId());
            try {
                echo json_encode($dao->getAllNotifications($user_id));
            }catch (\PDOException $e) {
                $status['err'] = $e->getMessage();
                echo json_encode($status);
            }
        }
    }

    public function checkForNotifications() {
        $dao = UserDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['user_id'])) {
            $user_id = htmlentities($_GET['user_id']);;
            echo $dao->checkForNotifications($user_id);
        }
    }

}