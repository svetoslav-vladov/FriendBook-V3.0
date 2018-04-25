<?php
namespace Controller;
use Model\Dao\PostDao;
use Model\User;

class PostController extends BaseController{
    public function addPost() {
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
                $dao = PostDao::getInstance();
                if (isset($_POST['user_id'])) {
                    $id = htmlentities($_POST['user_id']);
                    $dao->addPost($user_id, $current_post);
                    header('location:'.URL_ROOT.'/index/main');
                }else {
                    $dao->addPost($user_id, $current_post);
                    header('location:'.URL_ROOT.'/index/main');
                }
            }
        }
        else {
            $error = 'Wrong action!';
            header('location:'.URL_ROOT.'/index/main&error=' . $error);
        }
    }
    public function getAllPost() {

    }
}