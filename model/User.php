<?php
namespace model;

class User implements \JsonSerializable {
    public function jsonSerialize() {
        return get_object_vars($this);
    }
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $gender;
    private $birthday;
    private $profile_pic;
    private $cover_pic;

    /**
     * User constructor.
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $password
     * @param $gender
     * @param $birthday
     * @param $profile_pic
     * @param $cover_pic
     */
    public function __construct($first_name, $last_name, $email, $password, $gender, $birthday, $profile_pic, $cover_pic)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->gender = $gender;
        $this->birthday = $birthday;
        $this->profile_pic = $profile_pic;
        $this->cover_pic = $cover_pic;
    }

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->first_name;
    }
    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->last_name;
    }
    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }
    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }
    /**
     * @return mixed
     */
    public function getGender() {
        return $this->gender;
    }
    /**
     * @return mixed
     */
    public function getBirthday() {
        return $this->birthday;
    }
    /**
     * @return mixed
     */
    public function getProfilePic() {
        return $this->profile_pic;
    }
    /**
     * @return mixed
     */
    public function getCoverPic() {
        return $this->cover_pic;
    }
}