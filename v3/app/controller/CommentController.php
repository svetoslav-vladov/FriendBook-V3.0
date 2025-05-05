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
            $comment = new Comment($comment_desc, $post_id, $user_id);
            if (isset($_POST['user_id'])) {
                $id = htmlentities($_POST['user_id']);
                $dao->addComment($comment->getDescription(), $comment->getPostId(), $comment->getOwnerId());
                header("location:'.URL_ROOT.'/index/profile.php&id=" . $id);
            }else {
                $dao->addComment($comment->getDescription(), $comment->getPostId(), $comment->getOwnerId());
                header('location:'.URL_ROOT.'/index/main');
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $post_id = $_GET['post_id'];
            $result = $dao->getAllCommentsForCurrentPost($post_id);
            echo json_encode($result);
        }
    }

    public function likeComment() {
        $dao = CommentDao::getInstance();
        // function for check comment if liked
        if (isset($_GET['comment_id'])) {
            $user_id = $_SESSION['logged']->getId();
            $comment_id = $_GET['comment_id'];
            $dao->isLiked($comment_id, $user_id);
        }

        //AJAX REQUEST for like a comment
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_id = $_SESSION['logged']->getId();
            $comment_id = $_POST['comment_id'];
            $dao->likeComment($comment_id, $user_id);
        }
    }

    public  function unlikeComment() {
        $dao = CommentDao::getInstance();
        if (isset($_POST['comment_id'])) {
            $user_id = $_SESSION['logged']->getId();
            $comment_id = $_POST['comment_id'];
            $dao->unlikeComment($comment_id, $user_id);
        }
    }

    public function likeCounter() {
        $dao = CommentDao::getInstance();
        if (isset($_GET['comment_id'])) {
            $comment_id = htmlentities($_GET['comment_id']);
            $dao->getCommentCountLikes($comment_id);
        }
    }
}