<?php
namespace Controller;
use Model\Dao\PostDao;
use Model\Post;

class PostController extends BaseController{

    public function getOwnPosts() {
        $dao = PostDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id'])) {
            try {
                $user_id = htmlentities($_GET['user_id']);
                $logged_user_id = htmlentities($_SESSION['logged']->getId());
                $limit = htmlentities($_GET['limit']);
                $offset = htmlentities($_GET['offset']);
                echo json_encode($dao->getOwnPosts($logged_user_id, $user_id, $limit, $offset));
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function getAllPosts() {
        $dao = PostDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['logged'])) {
            try {
                $limit = htmlentities($_GET['limit']);
                $offset = htmlentities($_GET['offset']);
                echo json_encode($dao->getAllPosts($_SESSION['logged']->getId(), $limit, $offset));
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function getAllPostsByLike() {
        $dao = PostDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['logged'])) {
            try {
                $limit = htmlentities($_GET['limit']);
                $offset = htmlentities($_GET['offset']);
                echo json_encode($dao->getAllPostsByLike($_SESSION['logged']->getId(), $limit, $offset));
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function addPost() {
        $dao = PostDao::getInstance();
        if (isset($_POST['add_post'])) {
            /*
             * @var $_SESSION model\User;
             */
            $user_id = $_SESSION['logged']->getId();
            $current_post = htmlentities($_POST['desc']);
            $current_post = trim($current_post);
            $error = false;

            if (empty($current_post)) {
                $error = "You can't create empty post, Please fill the post!";
                header('location:'.URL_ROOT.'/index/main&error=' . htmlentities($error));
            }
            elseif(mb_strlen($current_post) > 1500) {
                $error = 'Your post contains too many characters! Please enter no more than 1500 characters.';
                header('location:'.URL_ROOT.'/index/main&error=' . htmlentities($error));
            }
            if (!$error) {
                // create new post for added
                $post = new Post($user_id, $current_post);
                try {
                   $dao->addPost($post);
                    header('location:' . URL_ROOT . '/index/main');
                }catch (\PDOException $e) {
                    header('location:' . URL_ROOT . '/index/main&error='.$e->getMessage());
                }
            }
        }
        else {
            $error = 'Wrong action!';
            header('location:'.URL_ROOT.'/index/main&error=' . $error);
        }
    }

    public function likePost() {
        $dao = PostDao::getInstance();
        $status = 1;
        //function for like post
        if (isset($_GET['post_id'])) {
            $user_id = $_SESSION['logged']->getId();
            $post_id = htmlentities($_GET['post_id']);
            echo $dao->isLiked($post_id, $user_id);
        }
            //AJAX REQUEST for like a post
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_id = $_SESSION['logged']->getId();
            $post_id = htmlentities($_POST['post_id']);
            $dao->unDislikePost($post_id,$user_id);
            $dao->likePost($post_id, $user_id, $status);
        }
    }

    public function dislikePost() {
        $dao = PostDao::getInstance();
        $status = 0;
        //AJAX REQUEST for dislike a post
        if (isset($_GET['post_id'])) {
            $user_id = $_SESSION['logged']->getId();
            $post_id = htmlentities($_GET['post_id']);
            echo $dao->isDisliked($post_id, $user_id);
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_id = $_SESSION['logged']->getId();
            $post_id = htmlentities($_POST['post_id']);
            $dao->unlikePost($post_id, $user_id);
            $dao->dislikePost($post_id, $user_id, $status);
        }
    }

    public function unlikePost() {
        if (isset($_POST['post_id'])) {
            $dao = PostDao::getInstance();
            $user_id = $_SESSION['logged']->getId();
            $post_id = htmlentities($_POST['post_id']);
            $dao->unlikePost($post_id, $user_id);
        }
    }

    public function undislikePost() {
        $dao = PostDao::getInstance();
        if (isset($_POST['post_id'])) {
            $user_id = $_SESSION['logged']->getId();
            $post_id = htmlentities($_POST['post_id']);
            $dao->unDislikePost($post_id, $user_id);
        }
    }

    public function likeCounter() {
        if (isset($_GET['post_id'])) {
            $post_id = htmlentities($_GET['post_id']);
            echo PostDao::getInstance()->getCountLikes($post_id);
        }
    }

    public function dislikeCounter() {
        $dao = PostDao::getInstance();
        if (isset($_GET['post_id'])) {
            $post_id = htmlentities($_GET['post_id']);
            echo $dao->getCountDislikes($post_id);
        }
    }

    public function deletePost() {
        $dao = PostDao::getInstance();
        try {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $post_id = $_POST['post_id'];
                $user_id = $_SESSION['logged']->getId();
                $dao->deletePost($post_id, $user_id);
            }
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function sharePhoto() {
        $dao = PostDao::getInstance();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //echo json_encode($_FILES);
            $user_id = $_SESSION['logged']->getId();
            $post = new Post($user_id, 'test');
            try {
                $dao->addPost($post);
                $dao->sharePhoto($post->getPostId(), 'test.url');
                header('location:' . URL_ROOT . '/index/main');
            }catch (\PDOException $e) {
                header('location:' . URL_ROOT . '/index/main&error='.$e->getMessage());
            }
        }
        else {
            $error = 'Wrong action!';
            header('location:'.URL_ROOT.'/index/main&error=' . $error);
        }
    }

    public function getSinglePost() {
        try {
            $dao = PostDao::getInstance();
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $post_id = $_GET['post_id'];
                echo json_encode($dao->getSinglePost($post_id));
            }
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}