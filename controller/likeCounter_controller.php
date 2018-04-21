<?php
use \model\Dao\PostDao;
require_once '../include/session.php';
function __autoload($class) {
    $class = "..\\" . $class;
    require_once str_replace("\\", "/", $class) . ".php";
}
$pdo = new PostDao();

if (isset($_GET['post_id'])) {
    $post_id = htmlentities($_GET['post_id']);
    $pdo->getCountLikes($post_id);
}