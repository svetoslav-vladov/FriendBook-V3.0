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
}