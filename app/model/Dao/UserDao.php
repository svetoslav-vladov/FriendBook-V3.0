<?php

namespace model\Dao;

use model\Picture;
use \model\User;
use function Sodium\add;

class UserDao
{

    private $pdo;
    private static $instance;

    const INSERT_USER = "INSERT INTO users (first_name, last_name, email, password, 
                    gender,birthday,profile_pic,profile_cover) VALUES (?, ?, ?, ?, ?, ?, ?,?)";

    const INSERT_SINGLE_PHOTO = "INSERT INTO user_photos (user_id, img_url) VALUES (?,?)";

    const CHECK_FOR_EMAIL = "SELECT COUNT(*) as row FROM users WHERE email = ?";

    const GET_PROFILE_IMAGES = "SELECT img_url FROM user_photos WHERE user_id = ? AND album_id IS NULL LIMIT 16;";

    const GET_PROFILE_ALBUMS = "SELECT * FROM photo_albums WHERE user_id = ? LIMIT 4;";

    const GET_PROFILE_ALBUMS_LIMIT_50 = "SELECT * FROM photo_albums WHERE user_id = ? LIMIT 50;";

    const GET_PROFILE_ALBUM_PHOTOS = "SELECT * FROM photo_albums WHERE user_id = ? LIMIT 4;";

    const LOGIN_CHECK_WITH_FULL_USER_DETAILS = "SELECT u.* , c.country_name, r.status_name as relationship_tag
                        FROM users as u
                        LEFT OUTER JOIN countries as c ON (u.country_id = c.id) 
                        LEFT OUTER JOIN relationship as r ON (u.relationship_id = r.id)
                        WHERE u.email = ? AND u.password = ?";

    const GET_USER_FULL_DETAILS_BY_ID = "SELECT u.* , c.country_name, r.status_name as relationship_tag
                        FROM users as u
                        LEFT OUTER JOIN countries as c ON (u.country_id = c.id) 
                        LEFT OUTER JOIN relationship as r ON (u.relationship_id = r.id)
                        WHERE u.id = ?";

    const GET_COUNTRIES_LIST = "SELECT * FROM countries";

    const GET_RELATIONSHIPS_LIST = "SELECT * FROM relationship ORDER BY id";

    const GET_INFO_BY_EMAIL = "SELECT * FROM users WHERE email = ?";

    const GET_INFO_BY_ID = "SELECT * FROM users WHERE id = ?";

    const UPDATE_USER_PICTURE = "UPDATE users SET profile_pic = ?, thumbs_profile = ? WHERE id = ?";

    const UPDATE_USER_COVER = "UPDATE users SET profile_cover = ?, thumbs_cover = ? WHERE id = ?";

    const INSERT_USER_PHOTOS = "INSERT INTO user_photos (user_id,img_url,thumb_url) values (?,?,?)";

    const INSERT_USER_ALBUM = "INSERT INTO photo_albums (name, user_id, album_thumb) values (?,?,?)";
    const INSERT_USER_ALBUM_PHOTOS = "INSERT INTO user_photos (user_id, img_url, album_id, thumb_url) values (?,?,?,?)";

    const GET_PROFILE_ALBUM_PHOTOS_BY_IDS = "SELECT up.*, pa.name as album_name FROM user_photos as up 
                                            JOIN photo_albums as pa ON up.album_id = pa.id
                                            WHERE up.user_id = ? AND up.album_id = ?";

    // SETTINGS PAGE QUERY's

    const UPDATE_USER_DESCRIPTION_INFO = "UPDATE users SET description = ? WHERE id = ?";

    const UPDATE_USER_FIRST_NAME = "UPDATE users SET first_name = ? WHERE id = ?";

    const UPDATE_USER_LAST_NAME = "UPDATE users SET first_name = ? WHERE id = ?";

    const UPDATE_USER_GENDER = "UPDATE users SET gender = ? WHERE id = ?";

    const UPDATE_USER_BIRTHDAY = "UPDATE users SET birthday = ? WHERE id = ?";

    const UPDATE_USER_DISPLAY_NAME = "UPDATE users SET display_name = ? WHERE id = ?";

    const UPDATE_USER_MOBILE_NUMBER = "UPDATE users SET mobile_number = ? WHERE id = ?";

    const UPDATE_USER_WEBSITE = "UPDATE users SET www = ? WHERE id = ?";

    const UPDATE_USER_SKYPE_NAME = "UPDATE users SET skype = ? WHERE id = ?";

    const UPDATE_USER_EMAIL = "UPDATE users SET email = ? WHERE id = ? AND password = ?";

    const UPDATE_USER_PASSWORD = "UPDATE users SET password = ? WHERE id = ? AND password = ?";

    const GET_USER_RELATIONSHIP_STATUS_NAME = "SELECT r.status_name
                                            FROM relationship as r
                                            JOIN users as u ON u.relationship_id = r.id
                                            WHERE u.id = ?";

    const UPDATE_USER_RELATIONSHIP_ID = "UPDATE users as u,
                                            relationship as r
                                            SET
                                            u.relationship_id = r.id
                                            WHERE
                                            u.id = ? AND r.id = ?";

    const UPDATE_USER_COUNTRY_ID = "UPDATE users as u,
                                            countries as c
                                            SET
                                            u.country_id = c.id
                                            WHERE
                                            u.id = ? AND c.id = ?";

    const GET_USER_COUNTRY_NAME = "SELECT c.country_name
                                            FROM countries as c
                                            JOIN users as u ON u.country_id = c.id
                                            WHERE u.id = ?";

    // getting static connection from DBconnect file
    private function __construct()
    {
        $this->pdo = DBconnect::getInstance()->dbConnect();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new UserDao();
        }
        return self::$instance;
    }

    public function saveUserProfilePic(User $user) {
        $statement = $this->pdo->prepare(self::UPDATE_USER_PICTURE);
        return $statement->execute(array(
            $user->getProfilePic(),
            $user->getThumbsProfile(),
            $user->getId(),
        ));
    }

    public function insertUserDb(User $user){
        $statement = $this->pdo->prepare(self::INSERT_USER);
        return $statement->execute(array($user->getFirstName(), $user->getLastName(), $user->getEmail(), $user->getPassword(), $user->getGender(), $user->getBirthday(), $user->getProfilePic(), $user->getProfileCover(),));
    }

// SETTINGS PAGE dao functions
    // GENERAL SETTINGS
    public function saveFirstName($id, $firstName){
        $statement = $this->pdo->prepare(self::UPDATE_USER_FIRST_NAME);
        $statement->execute(array($firstName, $id));
        return $statement->rowCount();
    }
    public function saveLastName($id, $lastName){
        $statement = $this->pdo->prepare(self::UPDATE_USER_LAST_NAME);
        $statement->execute(array($lastName, $id));
        return $statement->rowCount();
    }
    public function saveDisplayName($id, $displayName){
        $statement = $this->pdo->prepare(self::UPDATE_USER_DISPLAY_NAME);
        $statement->execute(array($displayName, $id));
        return $statement->rowCount();
    }

    public function saveGender($id, $gender){
        $statement = $this->pdo->prepare(self::UPDATE_USER_GENDER);
        $statement->execute(array($gender, $id));
        return $statement->rowCount();
    }
    public function saveBirthday($id, $birthday){
        $statement = $this->pdo->prepare(self::UPDATE_USER_BIRTHDAY);
        $statement->execute(array($birthday, $id));
        return $statement->rowCount();
    }

    public function saveRelationshipId($id, $relationshipId){

        $statement = $this->pdo->prepare(self::UPDATE_USER_RELATIONSHIP_ID);
        $statement->execute(array($id, $relationshipId));
        return $statement->rowCount();
    }
    public function getRelationshipStatus($id){

        $statement = $this->pdo->prepare(self::GET_USER_RELATIONSHIP_STATUS_NAME);
        $statement->execute(array($id));
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function saveCountryId($id, $countryId){

        $statement = $this->pdo->prepare(self::UPDATE_USER_COUNTRY_ID);
        $statement->execute(array($id, $countryId));
        return $statement->rowCount();
    }
    public function getCountryName($id){

        $statement = $this->pdo->prepare(self::GET_USER_COUNTRY_NAME);
        $statement->execute(array($id));
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function saveMobileNumber($id, $mobileNumber){
        $statement = $this->pdo->prepare(self::UPDATE_USER_MOBILE_NUMBER);
        $statement->execute(array($mobileNumber, $id));
        return $statement->rowCount();
    }
    public function saveWebsite($id, $websiteUrl){
        $statement = $this->pdo->prepare(self::UPDATE_USER_WEBSITE);
        $statement->execute(array($websiteUrl, $id));
        return $statement->rowCount();
    }
    public function saveSkypeName($id, $skypeName){
        $statement = $this->pdo->prepare(self::UPDATE_USER_SKYPE_NAME);
        $statement->execute(array($skypeName, $id));
        return $statement->rowCount();
    }

    // DESCRIPTION SETTINGS
    public function saveUserDescriptionSettings(User $user){
        $statement = $this->pdo->prepare(self::UPDATE_USER_DESCRIPTION_INFO);
        return $statement->execute(array($user->getDescription(),$user->getId()));
    }

    // SECURITY SETTINGS
    public function saveEmail($id, $email, $password){
        $statement = $this->pdo->prepare(self::UPDATE_USER_EMAIL);
        $statement->execute(array($email, $id, $password));
        return $statement->rowCount();
    }

    public function savePassword($id, $oldPassword, $password){
        $statement = $this->pdo->prepare(self::UPDATE_USER_PASSWORD);
        $statement->execute(array($password, $id, $oldPassword));
        return $statement->rowCount();
    }

    // UPLOAD IMAGES
    public function saveUserProfileInfo(User $user)
    {
        $statement = $this->pdo->prepare(self::UPDATE_USER_PICTURE);
        return $statement->execute(array($user->getProfilePic(), $user->getThumbsProfile(), $user->getId(),));
    }

    public function saveUserProfileCover(User $user)
    {
        $statement = $this->pdo->prepare(self::UPDATE_USER_COVER);
        return $statement->execute(array($user->getProfileCover(), $user->getThumbsCover(), $user->getId(),));
    }

    // $imagesList is object but in array...
    public function saveUserProfilePhotos(User $user, $imagesList)
    {

        $stmt = $this->pdo->prepare(self::INSERT_USER_PHOTOS);

        foreach ($imagesList as $pic_obj) {
            if (!$stmt->execute(array($user->getId(), $pic_obj->getUrlOnDiskPicture(), $pic_obj->getUrlOnDiskThumb()))) {
                throw new \PDOException('failed');
            }
        }

        return true;
    }

    public function saveUserAlbumAndPhotos($userId, $albumName, $imagesList)
    {
        $album = $this->pdo->prepare(self::INSERT_USER_ALBUM);

        $albumPhotos = $this->pdo->prepare(self::INSERT_USER_ALBUM_PHOTOS);

        try{
            $this->pdo->beginTransaction();
            // first image will be thumb for album
            $album->execute(array($albumName,$userId,$imagesList[0]->getUrlOnDiskThumb()));
            $albumId = $this->pdo->lastInsertId();

            foreach ($imagesList as $pic_obj) {
                $albumPhotos->execute(array($userId, $pic_obj->getUrlOnDiskPicture(), $albumId, $pic_obj->getUrlOnDiskThumb()));
            }

            $this->pdo->commit();
        }
        catch (\PDOException $e){
            $this->pdo->rollBack();
            throw new \PDOException($e->getMessage());
        }
//        $stmt = $this->pdo->prepare(self::INSERT_USER_PHOTOS);
//
//        foreach ($imagesList as $pic_obj) {
//            if (!$stmt->execute(array($userId, $pic_obj->getUrlOnDiskPicture(), $pic_obj->getUrlOnDiskThumb()))) {
//                throw new \PDOException('failed');
//            }
//        }

        return true;
    }

    public function loginCheck(User $user)
    {

        $statement = $this->pdo->prepare(self::LOGIN_CHECK_WITH_FULL_USER_DETAILS);
        $statement->execute(array($user->getEmail(), $user->getPassword()));
        return $statement->fetch(\PDO::FETCH_OBJ);

    }

    public function checkIfExistsEmail($email)
    {
        $statement = $this->pdo->prepare(self::CHECK_FOR_EMAIL);
        $statement->execute(array($email));
        return $statement->fetch(\PDO::FETCH_ASSOC)['row'] > 0;
    }

    public function getCountriesList()
    {
        $statement = $this->pdo->prepare(self::GET_COUNTRIES_LIST);
        $statement->execute(array());
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getRelationshipList()
    {
        $statement = $this->pdo->prepare(self::GET_RELATIONSHIPS_LIST);
        $statement->execute(array());
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getFullUserInfoById($userId)
    {
        $statement = $this->pdo->prepare(self::GET_USER_FULL_DETAILS_BY_ID);
        $statement->execute(array($userId));
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function getUserInfoById($userId)
    {
        $statement = $this->pdo->prepare(self::GET_INFO_BY_ID);
        $statement->execute(array($userId));
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function getUserPhotos(User $user)
    {
        $statement = $this->pdo->prepare(self::GET_PROFILE_IMAGES);
        $statement->execute(array($user->getId()));
        return $statement->fetchALL(\PDO::FETCH_ASSOC);
    }

    public function getUserAlbums($userId)
    {
        $statement = $this->pdo->prepare(self::GET_PROFILE_ALBUMS);
        $statement->execute(array($userId));
        return $statement->fetchALL(\PDO::FETCH_ASSOC);
    }

    public function getUserAlbumsBigLimit($userId)
    {
        $statement = $this->pdo->prepare(self::GET_PROFILE_ALBUMS_LIMIT_50);
        $statement->execute(array($userId));
        return $statement->fetchALL(\PDO::FETCH_OBJ);
    }

    public function getUserAlbumPhotosById($userId, $albumId)
    {
        $statement = $this->pdo->prepare(self::GET_PROFILE_ALBUM_PHOTOS_BY_IDS);
        $statement->execute(array($userId,$albumId));
        return $statement->fetchALL(\PDO::FETCH_OBJ);
    }

    public function getAllUsers($logged_user_id)
    {
        $statement = $this->pdo->prepare("SELECT id, first_name, last_name, gender, profile_pic, thumbs_profile
                                                    FROM users 
                                                    WHERE id != ?");
        $statement->execute(array($logged_user_id));
        $result = $statement->fetchAll();
        return $result;
    }

    function getSuggestedUsers($user_id)
    {
        $id = $user_id;
        // for suggested users are displayed all
        // without users who have sent an invitation to me
        // and users to whom I have sent an invitation
        $statement = $this->pdo->prepare("SELECT id, first_name, last_name, gender, profile_pic, thumbs_profile, reg_date, display_name
                                                    FROM users 
                                                    WHERE users.id 
                                                    NOT IN (SELECT friend_requests.requested_by 
                                                    FROM friend_requests 
                                                    WHERE friend_requests.requester_id = ?
                                                    UNION
                                                    SELECT friend_requests.requester_id 
                                                    FROM friend_requests 
                                                    WHERE friend_requests.requested_by = ?) 
                                                    AND users.id != $id ORDER BY RAND()
                                                    LIMIT 6;");
        $statement->execute(array($user_id, $user_id));
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    function sendFriendRequest($requested_by, $requester_id, $approved) {
        $statement = $this->pdo->prepare("INSERT INTO friend_requests (requested_by, requester_id, approved) 
                                VALUES (?,?,?)");
        return $statement->execute(array($requested_by, $requester_id, $approved));
    }

    function cancelFriendRequest($requested_by, $requester_id) {
        $statement = $this->pdo->prepare("DELETE FROM friend_requests WHERE requested_by = ? AND requester_id = ?");
        return $statement->execute(array($requested_by, $requester_id));
    }

    function acceptFriendRequest($requested_by, $requester_id) {
            $ids = [$requested_by, $requester_id];
            $insertIds = [$requester_id, $requested_by];
            $transaction = $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare("UPDATE friend_requests 
                                                        SET approved = 1
                                                        WHERE requested_by = ? AND requester_id = ?");
            $statement->execute($ids);

            $addFriend = $this->pdo->prepare("INSERT INTO friends (user_id, friend_id) VALUES (?,?)");
            $addFriend->execute($insertIds);

            $addFr = $this->pdo->prepare("INSERT INTO friends (friend_id, user_id) VALUES (?,?)");
            $addFr->execute($insertIds);
            $transaction = $this->pdo->commit();
    }

    function getAllFriendRequests($user_id) {
        $statement = $this->pdo->prepare("SELECT * FROM users 
                                                    JOIN friend_requests 
                                                    ON friend_requests.requested_by = users.id 
                                                    WHERE friend_requests.requester_id = ? AND friend_requests.approved = 0");
        $statement->execute(array($user_id));
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    function checkForFriendRequests($user_id) {
        $statement = $this->pdo->prepare("SELECT COUNT(*) as check_request 
                                                FROM friend_requests 
                                                WHERE friend_requests.requester_id = ? AND friend_requests.approved = 0");
        $statement->execute(array($user_id));
        return $statement->fetch()['check_request'];
    }

    function getFriends($user_id) {
        $statement = $this->pdo->prepare("SELECT id, first_name, last_name, gender, profile_pic, thumbs_profile, reg_date, display_name
                                                    FROM users 
                                                    JOIN friends 
                                                    ON friends.friend_id = users.id 
                                                    WHERE friends.user_id = ?");
        $statement->execute(array($user_id));
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    function getOwnFriends() {
        $user_id = $_SESSION['logged']->getId();
        $statement = $this->pdo->prepare("SELECT id, first_name, last_name, gender, profile_pic, thumbs_profile, reg_date, display_name
                                                    FROM users 
                                                    JOIN friends 
                                                    ON friends.friend_id = users.id 
                                                    WHERE friends.user_id = ?");
        $statement->execute(array($user_id));
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    function deleteFriend($friend_id, $logged_user_id) {
        try {
            $transaction = $this->pdo->beginTransaction();
            $deleteFromRequest = $this->pdo->prepare("DELETE FROM friend_requests 
                                                                WHERE (requested_by = ? AND requester_id = ?) 
                                                                OR (requested_by = ? AND requester_id = ?)");
            $deleteFromRequest->execute(array($logged_user_id, $friend_id, $friend_id, $logged_user_id));

            $deleteFromFriends = $this->pdo->prepare("DELETE FROM friends 
                                                                WHERE (user_id = ? AND friend_id = ?) 
                                                                OR (user_id = ? AND friend_id = ?)");
            $deleteFromFriends->execute(array($logged_user_id, $friend_id, $friend_id, $logged_user_id));
            $transaction = $this->pdo->commit();
            return true;
        }catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    function addNotification($post_id, $user_id, $description) {
        $statement = $this->pdo->prepare("INSERT INTO notifications (post_id, user_id, description) 
                                VALUES (?, ?, ?)");
        return $statement->execute(array($post_id, $user_id, $description));
    }

    function getAllNotifications($logged_user_id) {
        $id = $logged_user_id;
        $statement = $this->pdo->prepare("SELECT users.first_name AS notification_firstName, 
                                                    users.last_name AS notification_lastName,
                                                    users.thumbs_profile, users.profile_pic,
                                                    notifications.description AS notification_description, notifications.post_id, 
                                                    notification_date, posts.description AS post_description, users.gender,
                                                    users.display_name, notifications.notification_date
                                                    FROM notifications
                                                    JOIN posts ON posts.id = notifications.post_id
                                                    JOIN users ON notifications.user_id = users.id
                                                    WHERE notifications.post_id IN 
                                                    (SELECT posts.id 
                                                    FROM posts 
                                                    WHERE posts.user_id = ?) 
                                                    AND notifications.user_id != $id
                                                    ORDER BY notifications.notification_date DESC
                                                    LIMIT 15");
        $statement->execute(array($logged_user_id));
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    function checkForNotifications($logged_user_id) {
        $id = $logged_user_id;
        $statement = $this->pdo->prepare("SELECT COUNT(*) as check_notifications 
                                                    FROM notifications
                                                    JOIN posts ON posts.id = notifications.post_id
                                                    WHERE notifications.post_id IN 
                                                    (SELECT posts.id FROM posts WHERE posts.user_id = ?) 
                                                    AND notifications.user_id != $id");
        $statement->execute(array($logged_user_id));
        return $statement->fetch()['check_notifications'];
    }
}