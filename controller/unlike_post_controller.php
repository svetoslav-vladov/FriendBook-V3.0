<?php
use \model\Dao\PostDao;
require_once '../include/session.php';
function __autoload($class) {
    $class = "..\\" . $class;
    require_once str_replace("\\", "/", $class) . ".php";
}
$pdo = new PostDao();

if (isset($_POST['post_id'])) {
    $user_id = $_SESSION['logged']['id'];
    $post_id = htmlentities($_POST['post_id']);
    $pdo->unlikePost($post_id, $user_id);
}