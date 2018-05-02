<?php

namespace controller;


class BaseController implements \JsonSerializable {

    public function jsonSerialize(){}

    public function renderView($file, $array = []){

        require_once '../app/include/header.php';

        if(isset($_SESSION['logged'])){
            require_once "../app/include/nav.php";
        }

        require_once '../app/view/' . $file . '.php';

        require_once '../app/include/footer.php';
    }

}