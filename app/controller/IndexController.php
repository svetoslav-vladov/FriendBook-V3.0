<?php

namespace controller;

use \model\User;
use model\Dao\PostDao;
use Model\Dao\UserDao;

class IndexController extends \controller\BaseController{

    public function login() {
        $this->renderView('login');
    }

    public function profile() {

        if(isset($_GET['id']) && $_GET['id'] !== $_SESSION['logged']->getId() && is_numeric($_GET['id'])){
            $theUser = new User();
            $theUser->setId(htmlentities($_GET['id']));
            $newController = new UserController();
            try{
                $theUser = $newController->getUserInfo($theUser);
            }
            catch (\PDOException $e){
                header('location:'.URL_ROOT.'/index/main&error=' . $e->getMessage());
            }
            if($theUser === false){
                $theUser = $_SESSION["logged"];
            }
        }
        else{
            $theUser = $_SESSION["logged"];
        }

        $this->renderView('profile',$theUser);
    }

    public function register() {
        $this->renderView('register');
    }

    public function settings() {
        $this->renderView('settings');
    }

    public function main() {
        $dao = PostDao::getInstance();
        $userDao = UserDao::getInstance();
        $data = [];
        try {
            $allPosts = $dao->getAllPosts();
            $data['newsFeed'] = $allPosts;
        }
        catch (\PDOException $e) {
            echo $e->getMessage();
        }
        try {
            $suggested_users = $userDao->getSuggestedUsers($_SESSION['logged']->getId());
            $data['suggestedUsers'] = $suggested_users;
        }
        catch (\PDOException $e) {
            echo $e->getMessage();
        }
        $this->renderView('main', $data);
    }

    public function error($err) {
        $this->renderView('error', $err);
    }
}