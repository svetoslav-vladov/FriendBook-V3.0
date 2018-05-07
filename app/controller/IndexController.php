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

    public function postsbylike(){
        $this->renderView('postsbylike');
    }

    public function profile()
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

        $this->renderView('profile', $theUser);
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

    public function register(){
        $this->renderView('register');
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
        $dao = PostDao::getInstance();
        $data = [];
//        try {
//            $allPosts = $dao->getAllPosts($_SESSION['logged']->getId());
//            $data['newsFeed'] = $allPosts;
//        } catch (\PDOException $e) {
//            echo $e->getMessage();
//        }
        $this->renderView('main', $data);
    }

    public function error($err)
    {
        $this->renderView('error', $err);
    }


}