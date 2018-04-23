<?php

namespace controller;

use model\Dao\UserDao;
use model\Dao\PostDao;

use model\User;
use model\Post;
use model\Comment;

class IndexController extends \controller\BaseController{

    public function login() {

        $this->loadData('login');

    }
    public function profile() {

        $this->loadData('profile');

    }
    public function register() {

        $this->loadData('register');

    }
    public function main() {

        $this->loadData('main');

    }
    public function error($err) {

        $this->loadData('error', $err);

    }
}