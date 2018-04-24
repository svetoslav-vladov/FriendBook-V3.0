<?php

namespace controller;

class IndexController extends \controller\BaseController{

    public function login() {
        $this->renderView('login');
    }

    public function profile() {
        $this->renderView('profile');
    }

    public function register() {
        $this->renderView('register');
    }

    public function main() {
        $this->renderView('main');
    }

    public function error($err) {
        $this->renderView('error', $err);
    }
}