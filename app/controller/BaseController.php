<?php

namespace controller;

use model\Dao\UserDao;
use model\Dao\PostDao;
use \model\User;

class BaseController {

    public function __construct() {

    }

    public function loadData($file, $array = []){

        $logged = false;

        $userPhoto = null;
        $userId = null;
        $logged = null;

        $profile_pic = null;
        $profile_cover = null;

        $firstName = null;
        $lastName = null;
        $fullName = null;

        $followers = null;
        $friends = null;

        $user_feed = null;
        $user_posts = null;

        $userDao = UserDao::getInstance();

        if (isset($_SESSION['logged'])) {
            /* @var $user User */
//            $user = $_SESSION['logged'];
//            $logged = true;
//
//            $userId = $user->getId();
//            $profile_pic = $user->getProfilePic();
//            $profile_cover = $user->getProfileCover();
//
//            $firstName = $user->getFirstName();
//            $lastName = $user->getFirstLast();
//
//            $fullName = $firstName . " " . $lastName;
//
//            $followers = $userDao->getFollowers($userId);
//            $friends = $userDao->getFriends($userId);
//
//            $user_feed = $user->getNewsFeed();
//            $user_posts = $user->getPosts();


        }

        $userData['user_id'] = $userId;
        $userData['first_name'] = $firstName;
        $userData['last_name'] = $lastName;
        $userData['full_name'] = $fullName;

        $userData['profile_pic'] = $profile_pic;
        $userData['profile_cover'] = $profile_cover;

        $userData['profile_cover'] = $profile_cover;
        $userData['profile_cover'] = $profile_cover;

        $userData['followers'] = $followers;
        $userData['friends'] = $friends;

        $userData['user_feed'] = $user_feed;
        $userData['user_feed'] = $user_posts;

        require_once '../app/include/header.php';
        if(isset($_SESSION['logged'])){
            require_once "../app/include/nav.php";
        }
        require_once '../app/view/' . $file . '.php';
        require_once '../app/include/footer.php';
    }

}