<?php
namespace model\Dao;

class CommentDao {
    private function __construct() {
        $this->pdo = DBconnect::getInstance()->dbConnect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new CommentDao();
        }
        return self::$instance;
    }

    private $pdo;
    private static $instance;

    public function addComment($description, $post_id, $owner_id) {
        $statement = $this->pdo->prepare("INSERT INTO comments (description, post_id, owner_id) 
                                VALUES (?,?,?)");
        return $statement->execute(array($description, $post_id, $owner_id));
    }

    public function getAllCommentsForCurrentPost($post_id) {
        $statement = $this->pdo->prepare("SELECT comments.id AS comment_id , comments.description, comment_date, post_id, owner_id, profile_pic, first_name, last_name, users.gender, display_name
                                FROM comments
                                JOIN users ON users.id = comments.owner_id
                                JOIN posts ON posts.id = comments.post_id
                                WHERE posts.id = ?
                                ORDER BY comments.comment_date DESC;");
        $statement->execute(array($post_id));
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}