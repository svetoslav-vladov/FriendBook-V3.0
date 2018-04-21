<?php
use \model\Dao\PostDao;
require_once '../include/session.php';
function __autoload($class) {
    $class = "..\\" . $class;
    require_once str_replace("\\", "/", $class) . ".php";
}
$pdo = new PostDao();
$status = 1;
//AJAX REQUEST for like a post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_SESSION['logged']['id'];
    $post_id = htmlentities($_POST['post_id']);
    $pdo->likePost($post_id, $user_id, $status);
}
//function for like post
if (isset($_GET['post_id'])) {
    $user_id = $_SESSION['logged']['id'];
    $post_id = htmlentities($_GET['post_id']);
    $pdo->isLiked($post_id, $user_id);
}