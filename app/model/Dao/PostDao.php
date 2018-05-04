<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 21.4.2018 г.
 * Time: 12:35
 */

namespace model\Dao;

use model\Post;

class PostDao {
    private function __construct() {
        $this->pdo = DBconnect::getInstance()->dbConnect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new PostDao();
        }
        return self::$instance;
    }

    private $pdo;
    private static $instance;

    public function addPost(Post $post){
        try {
            $statement = $this->pdo->prepare("INSERT INTO posts (user_id, description) 
                                                        VALUES (?,?);");
            return $statement->execute(array($post->getOwnerId(), $post->getDescription()));
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function sharePhoto($post_id, $image_url) {
        $statement = $this->pdo->prepare("INSERT INTO post_images (post_id, image_url)
                                                    VALUES (?,?);");
        $statement->execute(array($post_id, $image_url));
    }

    public function getAllPosts() {
        // this function return my posts and my friends posts
        try {
            $logged_user_id = $_SESSION['logged']->getId();
            $statement = $this->pdo->prepare("SELECT posts.id AS post_id, posts.description, posts.create_date, posts.user_id AS user_id, users.first_name, users.last_name, users.gender ,users.profile_pic, users.profile_cover, thumbs_profile 
                                                        FROM posts 
                                                        JOIN users 
                                                        ON users.id = posts.user_id 
                                                        WHERE posts.user_id 
                                                        IN (SELECT friend_id 
                                                        FROM friends 
                                                        WHERE friends.user_id = ?) OR posts.user_id = ?
                                                        ORDER BY posts.create_date DESC");
            $statement->execute(array($logged_user_id, $logged_user_id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getOwnPosts($user_id) {
        try {
            $statement = $this->pdo->prepare("SELECT posts.id AS post_id, posts.description, posts.create_date, users.id AS user_id, users.first_name, users.last_name, users.profile_pic, users.profile_cover,users.gender
                                    FROM posts
                                    JOIN users ON posts.user_id = users.id 
                                    WHERE users.id = ? 
                                    ORDER BY posts.create_date DESC;");
            $statement->execute(array($user_id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function likePost($post_id, $user_id, $status) {
        try {
            $statement = $this->pdo->prepare("INSERT INTO like_post (post_id, user_id, status) 
                                    VALUES (?,?,?)");
            return $statement->execute(array($post_id, $user_id, $status));
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function unlikePost($post_id, $user_id) {
        try {
            $statement = $this->pdo->prepare("DELETE FROM like_post WHERE post_id = ? AND user_id = ?");
            return $statement->execute(array($post_id, $user_id));
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function isLiked($post_id, $user_id) {
        try {
            $statement = $this->pdo->prepare("SELECT COUNT(*) AS isLike 
                                                        FROM like_post
                                                        WHERE post_id = ? AND user_id = ? AND status = 1");
            $statement->execute(array($post_id, $user_id));
            return $statement->fetch()['isLike'];
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function getCountLikes($post_id) {
        try {
            $statement = $this->pdo->prepare("SELECT COUNT(*) AS like_count 
                                    FROM like_post
                                    WHERE post_id = ? AND status = 1");
            $statement->execute(array($post_id));
            return $statement->fetch()['like_count'];
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function dislikePost($post_id, $user_id, $status) {
        try {
            $statement = $this->pdo->prepare("INSERT INTO like_post (post_id, user_id, status) 
                                    VALUES (?,?,?)");
            return $statement->execute(array($post_id, $user_id, $status));
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function unDislikePost($post_id, $user_id) {
        try {
            $statement = $this->pdo->prepare("DELETE FROM like_post WHERE post_id = ? AND user_id = ?");
            return $statement->execute(array($post_id, $user_id));
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function isDisliked($post_id, $user_id) {
        try {
            $statement = $this->pdo->prepare("SELECT COUNT(*) AS isDislike 
                                    FROM like_post
                                    WHERE post_id = ? AND user_id = ? AND status = 0");
            $statement->execute(array($post_id, $user_id));
            return $statement->fetch()['isDislike'];
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function getCountDislikes($post_id) {
        try {
            $statement = $this->pdo->prepare("SELECT COUNT(*) AS dislike_count 
                                    FROM like_post
                                    WHERE post_id = ? AND status = 0");
            $statement->execute(array($post_id));
            return $statement->fetch()['dislike_count'];
        }catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function deletePost($post_id, $user_id) {
        try {
//            $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare("DELETE FROM posts WHERE posts.id = ? AND posts.user_id = ?");
//            $this->pdo->commit();
        }
        catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new \PDOException($e->getMessage());
        }
        return $statement->execute(array($post_id, $user_id));
    }

    function getAllPostsByLike() {

        $logged_user_id = $_SESSION['logged']->getId();
        //database query for get all posts ordering by most likes
        $statement = $this->pdo->prepare("SELECT posts.id AS post_id, posts.description, posts.create_date, posts.user_id AS user_id, users.first_name, users.last_name, users.gender ,users.profile_pic, users.profile_cover, thumbs_profile, COUNT(*) AS most_liked
                                                    FROM posts
                                                    JOIN users ON users.id = posts.user_id
                                                    JOIN like_post ON like_post.post_id = posts.id
                                                    WHERE posts.user_id
                                                    IN (SELECT friend_id
                                                    FROM friends
                                                    WHERE friends.user_id = ?) OR posts.user_id = ?
                                                    GROUP BY like_post.post_id
                                                    ORDER BY most_liked DESC;");
        $statement->execute(array($logged_user_id, $logged_user_id));
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;

    }
}
