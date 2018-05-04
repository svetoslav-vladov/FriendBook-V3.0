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
            } elseif (isset($validResult['form']) && empty($validResult['form']['name'])) {
                $status = array();
                $status['error'] = 'Failed to upload!';
                $status['info'] = $validResult['err'];
                echo json_encode($status);
            } elseif (isset($validResult['form'])) {
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
            } else {
                echo "Validation Error...";
            }
        }
        else{
            header('location:'.URL_ROOT.'/error/401');
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
            echo json_encode($dao->getSuggestedUsers());
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
                $dao->deleteFriend($friend_id);
                $status['success'] = true;
                echo json_encode($status);
            }
            catch (\PDOException $e){
                $status['err'] = $e->getMessage();
                echo json_encode($status);
            }
        }
    }
}