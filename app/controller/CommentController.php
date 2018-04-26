<?php
namespace Controller;
use Model\Dao\CommentDao;
use Model\Comment;

class CommentController extends BaseController {
    public function addComment() {
        $dao = CommentDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_id = $_SESSION['logged']->getId();
            $post_id = htmlentities($_POST['post_id']);
            $comment_desc = htmlentities($_POST['comment_description']);
            $comment_desc = trim($comment_desc);
            if (isset($_POST['user_id'])) {
                $id = htmlentities($_POST['user_id']);
                $dao->addComment($comment_desc, $post_id, $user_id);
                header("location: ../view/profile.php?id=" . $id);
            }else {
                $dao->addComment($comment_desc, $post_id, $user_id);
                header('location:'.URL_ROOT.'/index/main');
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $post_id = $_GET['post_id'];
            $result = $dao->getAllCommentsForCurrentPost($post_id);
            echo json_encode($result);
        }
    }
}