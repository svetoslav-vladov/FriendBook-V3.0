<?php

use \model\Dao\PostDao;
require_once '../include/session.php';
function __autoload($class) {
    $class = "..\\" . $class;
    require_once str_replace("\\", "/", $class) . ".php";
}
$pdo = new PostDao();
$status = 0;
//AJAX REQUEST for dislike a post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_SESSION['logged']['id'];
    $post_id = htmlentities($_POST['post_id']);
    $pdo->unlikePost($post_id, $user_id);
    $pdo->dislikePost($post_id, $user_id, $status);
}
//function for like post
if (isset($_GET['post_id'])) {
    $user_id = $_SESSION['logged']['id'];
    $post_id = htmlentities($_GET['post_id']);
    $pdo->isDisliked($post_id, $user_id);
}