<?php

    //app root
    define('APP_ROOT', dirname(dirname(__FILE__)));
    //url root
    define('URL_ROOT', 'http://' . $_SERVER['SERVER_NAME'] . '/projects/FriendBook-v3.0');
    // site name
    define('SITE_NAME', 'Friendbook');

    $GLOBALS["male_default_picture"] = '/uploads/male_default_picture.png';
    $GLOBALS["female_default_picture"] = '/uploads/female_default_picture.png';
    $GLOBALS["default_cover_pic"] = '/uploads/default_cover.jpg';