<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 21.4.2018 г.
 * Time: 12:35
 */

namespace model\Dao;


class PostDao {
    const DB_NAME = 'friendbook_v3';
    const DB_IP = 'localhost';
    const DB_PORT = '3306';
    const DB_USER = 'friendbook';
    const DB_PASS = 'test123';

    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new \PDO("mysql:host=" . self::DB_IP . ":" . self::DB_PORT . ";dbname=" . self::DB_NAME, self::DB_USER, self::DB_PASS);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Problem with db query  - " . $e->getMessage();
        }
    }

    public function addPost($user_id, $description){
        $statement = $this->pdo->prepare("INSERT INTO posts (user_id, description) 
                                VALUES (?,?);");
        $statement->execute(array($user_id, $description));
    }

    public function getAllPosts() {
        $statement = $this->pdo->prepare("SELECT posts.id AS post_id, posts.description, posts.create_date, users.id AS user_id, users.first_name, users.last_name, users.gender ,users.profile_pic, users.profile_cover
                                FROM posts
                                JOIN users ON posts.user_id = users.id WHERE ?
                                ORDER BY posts.create_date DESC ");
        $statement->execute(array(1));
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOwnPosts($user_id) {
        $statement = $this->pdo->prepare("SELECT posts.id AS post_id, posts.description, posts.create_date, users.id AS user_id, users.first_name, users.last_name, users.profile_pic, users.profile_cover,users.gender
                                FROM posts
                                JOIN users ON posts.user_id = users.id 
                                WHERE users.id = ? 
                                ORDER BY posts.create_date DESC;");
        $statement->execute(array($user_id));
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    function likePost($post_id, $user_id, $status) {
        $statement = $this->pdo->prepare("INSERT INTO like_post (post_id, user_id, status) 
                                VALUES (?,?,?)");
        return $statement->execute(array($post_id, $user_id, $status));
    }

    function unlikePost($post_id, $user_id) {
        $statement = $this->pdo->prepare("DELETE FROM like_post WHERE post_id = ? AND user_id = ?");
        return $statement->execute(array($post_id, $user_id));
    }

    function isLiked($post_id, $user_id) {
        $statement = $this->pdo->prepare("SELECT COUNT(*) AS isLike 
                                FROM like_post
                                WHERE post_id = ? AND user_id = ? AND status = 1");
        $statement->execute(array($post_id, $user_id));
//    $result = $statement->fetch(); // return first row of table
        echo $statement->fetch()['isLike'];
    }

    function getCountLikes($post_id) {
        $statement = $this->pdo->prepare("SELECT COUNT(*) AS like_count 
                                FROM like_post
                                WHERE post_id = ? AND status = 1");
        $statement->execute(array($post_id));
        echo $statement->fetch()['like_count'];
    }

    function dislikePost($post_id, $user_id, $status) {
        $statement = $this->pdo->prepare("INSERT INTO like_post (post_id, user_id, status) 
                                VALUES (?,?,?)");
        return $statement->execute(array($post_id, $user_id, $status));
    }

    function unDislikePost($post_id, $user_id) {
        $statement = $this->pdo->prepare("DELETE FROM like_post WHERE post_id = ? AND user_id = ?");
        return $statement->execute(array($post_id, $user_id));
    }

    function isDisliked($post_id, $user_id) {
        $statement = $this->pdo->prepare("SELECT COUNT(*) AS isDislike 
                                FROM like_post
                                WHERE post_id = ? AND user_id = ? AND status = 0");
        $statement->execute(array($post_id, $user_id));
        echo $statement->fetch()['isDislike'];
    }

    function getCountDislikes($post_id) {
        $statement = $this->pdo->prepare("SELECT COUNT(*) AS dislike_count 
                                FROM like_post
                                WHERE post_id = ? AND status = 0");
        $statement->execute(array($post_id));
        echo $statement->fetch()['dislike_count'];
    }
}