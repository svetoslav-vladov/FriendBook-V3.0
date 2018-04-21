<?php

namespace model\Dao;
use \model\User;

class UserDao {
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

    public function register(User $user) {
        $stmt = $this->pdo->prepare("INSERT INTO users (first_name, last_name, email, password, gender, birthday, profile_pic, profile_cover) 
                            VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute(array($user->getFirstName(), $user->getLastName(), $user->getEmail(), $user->getPassword(), $user->getGender(), $user->getBirthday(), $user->getProfilePic(), $user->getCoverPic()
        ));
    }

    public function regUserExist($email) {
        $statement = $this->pdo->prepare("SELECT COUNT(*) AS count FROM users WHERE email = ?");
        $statement->execute(array($email));
        $row = $statement->fetch();
        return $row['count'] > 0;
    }

    public function userPassCheck($email, $password) {
        $statement = $this->pdo->prepare("SELECT COUNT(*) as count FROM users WHERE email = ? AND password = ?");
        $statement->execute(array($email, $password));
        $row = $statement->fetch(); // return first row of table
        return $row['count'] > 0;
    }

    public function loginSession($email, $password) {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $statement->execute(array($email, $password));
        $user = $statement->fetch();
        $logged_user['id'] = $user['id'];
        $logged_user['first_name'] = $user['first_name'];
        $logged_user['last_name'] = $user['last_name'];
        $logged_user['full_name'] = $user['first_name'] . " " . $user['last_name'];
        if(isset($user['display_name'])){
            $logged_user['display_name'] = $user['display_name'];
        }
        $logged_user['email'] = $user['email'];
        $logged_user['reg_date'] = $user['reg_date'];
        $logged_user['gender'] = $user['gender'];
        $logged_user['birthday'] = $user['birthday'];
        $logged_user['relation_status'] = $user['relation_status'];
        $logged_user['reg_date'] = $user['reg_date'];
        $logged_user['profile_pic'] = $user['profile_pic'];
        $logged_user['profile_cover'] = $user['profile_cover'];
        $_SESSION['logged'] = $logged_user;
    }
}