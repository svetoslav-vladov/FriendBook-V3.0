<?php

require_once '../include/session.php';
require_once "../include/pagelock.php";
$logged_user_id = $_SESSION['logged']['id'];
// header.php is head tag, meta, link etc.
require_once "../include/header.php";
//mainHeader is after login, top navigation
require_once  "../include/mainHeader.php";