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

    const GET_PROFILE_IMAGES = "SELECT img_url FROM user_photos WHERE user_id = ? LIMIT 16;";

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

    const GET_RELATIONSHIP_LIST = "SELECT * FROM relationship ORDER BY id";

    const GET_INFO_BY_EMAIL = "SELECT * FROM users WHERE email = ?";

    const GET_INFO_BY_ID = "SELECT * FROM users WHERE id = ?";

    const UPDATE_USER_PICTURE = "UPDATE users SET profile_pic = ?, thumbs_profile = ? WHERE id = ?";

    const UPDATE_USER_COVER = "UPDATE users SET profile_cover = ?, thumbs_cover = ? WHERE id = ?";

    const INSERT_USER_PHOTOS = "INSERT INTO user_photos (user_id,img_url,thumb_url) values (?,?,?)";

    // SETTINGS PAGE QUERY's

    const UPDATE_USER_DESCRIPTION_INFO = "UPDATE users SET description = ? WHERE id = ?";

    const UPDATE_USER_FIRST_NAME = "UPDATE users SET first_name = ? WHERE id = ?";

    const UPDATE_USER_LAST_NAME = "UPDATE users SET first_name = ? WHERE id = ?";

    const UPDATE_USER_DISPLAY_NAME = "UPDATE users SET display_name = ? WHERE id = ?";

    const GET_USER_RELATIONSHIP_STATUS_NAME = "SELECT r.status_name
                                            FROM relationship as r
                                            JOIN users as u ON u.relationship_id = r.id
                                            WHERE u.id = ?";

    const UPDATE_USER_RELATIONSHIP = "UPDATE users as u,
                                            relationship as r
                                            SET
                                            u.relationship_id = r.id
                                            WHERE
                                            u.id = ? AND r.id = ?";

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

    public function saveRelationship($id, $relationshipId){

        $statement = $this->pdo->prepare(self::UPDATE_USER_RELATIONSHIP);
        $statement->execute(array($id, $relationshipId));
        return $statement->rowCount();
    }
    public function getRelationshipStatus($id){

        $statement = $this->pdo->prepare(self::GET_USER_RELATIONSHIP_STATUS_NAME);
        $statement->execute(array($id));
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function saveUserDescriptionSettings(User $user){
        $statement = $this->pdo->prepare(self::UPDATE_USER_DESCRIPTION_INFO);
        return $statement->execute(array($user->getDescription(),$user->getId()));
    }

    public function saveUserSecuritySettings(User $user){

        $statement = $this->pdo->prepare(self::UPDATE_USER_GENERAL_INFO);
        $statement->execute(array($user->getRelationshipId(), $user->getCountryId(),
            $user->getFirstName(), $user->getLastName(), $user->getGender(), $user->getBirthday(),
            $user->getDisplayName(), $user->getMobileNumber(), $user->getWww(), $user->getSkype(), $user->getId()));
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

    public function loginCheck(User $user)
    {

        $statement = $this->pdo->prepare(self::LOGIN_CHECK_WITH_FULL_USER_DETAILS);
        $statement->execute(array($user->getEmail(), $user->getPassword()));
        return $statement->fetch(\PDO::FETCH_OBJ);

    }

    public function checkIfExists(User $user)
    {
        $statement = $this->pdo->prepare(self::CHECK_FOR_EMAIL);
        $statement->execute(array($user->getEmail()));
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
        $statement = $this->pdo->prepare(self::GET_RELATIONSHIP_LIST);
        $statement->execute(array());
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getFullUserInfoById(User $user)
    {
        $statement = $this->pdo->prepare(self::GET_USER_FULL_DETAILS_BY_ID);
        $statement->execute(array($user->getId()));
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function getUserInfoById(User $user)
    {
        $statement = $this->pdo->prepare(self::GET_INFO_BY_ID);
        $statement->execute(array($user->getId()));
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function getUserPhotos(User $user)
    {
        $statement = $this->pdo->prepare(self::GET_PROFILE_IMAGES);
        $statement->execute(array($user->getId()));
        return $statement->fetchALL(\PDO::FETCH_ASSOC);
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

    function deleteFriend($friend_id) {
        try {
            $logged_user_id = $_SESSION['logged']->getId();
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
}