<?php
    
    $httpProtocol = isset($_SERVER['HTTPS']) ? "https" : "http";
    /*
        Example:
            - example.com
            - subdomain.example.com
            - localhost
    */
    $siteUrl = "localhost";
    $hostUrl = $httpProtocol. '://' . $siteUrl;

    //app root
    define('APP_ROOT', dirname(dirname(__FILE__)));
    //url root
    define('URL_ROOT', $hostUrl);

    // thumbs uri
    define('THUMBS_URI', './uploads/users/photos/thumbs/');
    // site name
    define('SITE_NAME', 'FriendBook.bg - Your social network');

    // some stuff
    define('THUMB_SIZE_HEIGHT', 150); // height !!! px
    define('COVER_SIZE_WIDTH', 800); // width !!! px
    define('UPLOAD_PHOTOS', './uploads/users/photos');
    define('UPLOAD_FULL_SIZE', './uploads/users/photos/fullsized');
    define('UPLOAD_THUMBS', './uploads/users/photos/thumbs');

    define('MAX_IMG_UPLOAD_PHOTOS', 15);
    define('MAX_IMG_UPLOAD_PHOTO_SIZE', 2097152);

    $GLOBALS["male_default_picture"] = '/uploads/male_default_picture.png';
    $GLOBALS["female_default_picture"] = '/uploads/female_default_picture.png';
    $GLOBALS["default_cover_pic"] = '/uploads/default_cover.jpg';