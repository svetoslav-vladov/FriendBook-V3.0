<?php

namespace model\Dao;

use model\Picture;
use \model\User;

class UserDao {

    private $pdo;
    private static $instance;

    const INSERT_USER = "INSERT INTO users (first_name, last_name, email, password, 
                    gender,birthday,profile_pic,profile_cover) VALUES (?, ?, ?, ?, ?, ?, ?,?)";

    const INSERT_SINGLE_PHOTO = "INSERT INTO user_photos (user_id, img_url) 
                                VALUES (?,?)";

    const CHECK_FOR_EMAIL = "SELECT COUNT(*) as row FROM users WHERE email = ?";

    const GET_PROFILE_IMAGES = "SELECT img_url FROM user_photos WHERE user_id = ?;";

    const LOGIN_CHECK = "SELECT * FROM users WHERE email = ? AND password = ?";

    const GET_INFO_BY_EMAIL = "SELECT * FROM users WHERE email = ?";

    const GET_INFO_BY_ID = "SELECT * FROM users WHERE id = ?";

    const UPDATE_USER_PICTURE = "UPDATE users SET profile_pic = ?, thumbs_profile = ? WHERE id = ?";

    const UPDATE_USER_COVER = "UPDATE users SET profile_cover = ?, thumbs_cover = ? WHERE id = ?";

    const INSERT_USER_PHOTOS = "INSERT INTO user_photos (user_id,img_url,thumb_url) values (?,?,?)";


    // getting static connection from DBconnect file
    private function __construct() {
        $this->pdo = DBconnect::getInstance()->dbConnect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new UserDao();
        }
        return self::$instance;
    }

    public function insertUserDb(User $user) {
        $statement = $this->pdo->prepare(self::INSERT_USER);
        return $statement->execute(array(
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getGender(),
            $user->getBirthday(),
            $user->getProfilePic(),
            $user->getProfileCover(),
        ));
    }

    public function saveUserProfilePic(User $user) {
        $statement = $this->pdo->prepare(self::UPDATE_USER_PICTURE);
        return $statement->execute(array(
            $user->getProfilePic(),
            $user->getThumbsProfile(),
            $user->getId(),
        ));
    }

    public function saveUserProfileCover(User $user) {
        $statement = $this->pdo->prepare(self::UPDATE_USER_COVER);
        return $statement->execute(array(
            $user->getProfileCover(),
            $user->getThumbsCover(),
            $user->getId(),
        ));
    }

    public function loginCheck(User $user){

        $statement = $this->pdo->prepare(self::LOGIN_CHECK);
        $statement->execute(array(
            $user->getEmail(),
            $user->getPassword()
        ));
        return $statement->fetch(\PDO::FETCH_OBJ);

    }

    public function checkIfExists(User $user) {
        $statement = $this->pdo->prepare(self::CHECK_FOR_EMAIL);
        $statement->execute(array($user->getEmail()));
        return $statement->fetch(\PDO::FETCH_ASSOC)['row'] > 0;
    }

    public function getUserInfoById(User $user) {
        $statement = $this->pdo->prepare(self::GET_INFO_BY_ID);
        $statement->execute(array($user->getId()));
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function getUserPhotos(User $user) {
        $statement = $this->pdo->prepare(self::GET_PROFILE_IMAGES);
        $statement->execute(array(
            $user->getId()
        ));
        return $statement->fetchALL(\PDO::FETCH_ASSOC);
    }

    // $imagesList is object but in array...
    public function saveUserProfilePhotos(User $user, $imagesList) {

        $stmt = $this->pdo->prepare(self::INSERT_USER_PHOTOS);

        foreach($imagesList as $pic_obj) {
            if(!$stmt->execute(array($user->getId(),$pic_obj->getUrlOnDiskPicture(),$pic_obj->getUrlOnDiskThumb()))){
                throw new \PDOException('failed');
            }
        }

        return true;
    }

    public function getAllUsers($logged_user_id) {
        $statement = $this->pdo->prepare("SELECT id, first_name, last_name, gender, profile_pic, thumbs_profile
                                FROM users 
                                WHERE id != ?");
        $statement->execute(array($logged_user_id));
        $result = $statement->fetchAll();
        return $result;
    }
}