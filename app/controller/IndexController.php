<?php

namespace controller;

use \model\User;
use model\Dao\PostDao;
use Model\Dao\UserDao;

class IndexController extends \controller\BaseController
{


    public function login(){
        $this->renderView('login');
    }

    public function register(){
        $this->renderView('register');
    }

    public function profile()
    {
        // this will set $theUser to be session info or userInfo by id
        if (isset($_GET['id']) && $_GET['id'] !== $_SESSION['logged']->getId() && is_numeric($_GET['id'])) {

            $dao = UserDao::getInstance();

            $theUser = new User();
            $theUser->setId(htmlentities($_GET['id']));

            try {
                $result = $dao->getUserInfoById($theUser);
                // we can check if id is given to see if that id is a friend, for profile view nav
                //$isFriend = $dao->getUserFriendStatus($theUser);
                if ($result) {
                    cast($theUser, $result);
                    $theUser->setPassword(null);
                    $theUser->setFullName($theUser->getFirstName() . " " . $theUser->getLastName());
                } else {
                    // return false if no user with that id, then set session id to val
                    $theUser = $_SESSION["logged"];
                }
            }
            catch (\PDOException $e) {
                header('location:' . URL_ROOT . '/index/profile&error=' . $e->getMessage());
            }

        }
        else {
            $theUser = $_SESSION["logged"];
        }

        return $this->renderView('profile', $theUser);
    }

    public function postsbylike(){
        $this->renderView('postsbylike');
    }

    public function post(){
        $this->renderView('post');
    }

    public function friends()
    {

        if (isset($_GET['id']) && $_GET['id'] !== $_SESSION['logged']->getId() && is_numeric($_GET['id'])) {
            $theUser = new User();
            $theUser->setId(htmlentities($_GET['id']));
            $newController = new UserController();
            try {
                $theUser = $newController->getUserInfo($theUser);
            } catch (\PDOException $e) {
                header('location:' . URL_ROOT . '/index/main&error=' . $e->getMessage());
            }
            if ($theUser === false) {
                $theUser = $_SESSION["logged"];
            }
        } else {
            $theUser = $_SESSION["logged"];
        }
        $this->renderView('friends', $theUser);
    }

    public function album(){

        // request to db for different cases
        $data = array();
        $dao = UserDao::getInstance();

        if(isset($_GET['id']) && isset($_GET['userId'])){
            $userId = htmlentities($_GET['userId']);
            $albumId = htmlentities($_GET['id']);
            try{
                if(!$dao->getUserAlbumsPhotosByIdAndUser($userId,$albumId)){
                    $data['errors'] = 'User do not own or have album with that id!!!';
                }
                $data['otherView'] = $dao->getUserAlbumsPhotosByIdAndUser($userId,$albumId);
            }
            catch (\PDOException $e){
                $data['errors'] = $e->getMessage();
            }
        }
        elseif (isset($_GET['id'])){
            $albumId = htmlentities($_GET['id']);
            try{
                if(!$dao->getUserAlbumPhotosById($_SESSION['logged']->getId(), $albumId)){
                    $data['errors'] = 'You dont own photo album with that id!!!';
                }
                $data['yourView'] = $dao->getUserAlbumPhotosById($_SESSION['logged']->getId(), $albumId);
            }
            catch (\PDOException $e){
                $data['errors'] = $e->getMessage();
            }
        }
        else{
            try{
                $data['albums'] = $dao->getUserAlbumsBigLimit($_SESSION['logged']->getId());
            }
            catch (\PDOException $e){
                $data['errors'] = $e->getMessage();
            }
        }

        $this->renderView('album', $data);
    }

    public function settings(){
        try {
            $dao = UserDao::getInstance();

            // getting list of countries in db
            $data['countries'] = $dao->getCountriesList();

            $data['relationship'] = $dao->getRelationshipList();

            // render settings view with $data array passed
            $this->renderView('settings', $data);
        } catch (\PDOException $e) {
            // generating error view with the error
            $this->renderView('error', $e->getMessage());
        } catch (\Exception $e) {
            // generating error view with the error
            $this->renderView('error', $e->getMessage());
        }
    }

    public function main(){
        $this->renderView('main');
    }

    public function error($err)
    {
        $this->renderView('error', $err);
    }


}