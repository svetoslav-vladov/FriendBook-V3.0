<?php

    namespace model;

    class User{

        private $id;
        private $email;

        private $first_name;
        private $last_name;
        private $full_name;

        private $password;
        private $reg_date;
        private $gender;
        private $birthday;

        private $relation_status;
        private $profile_pic;
        private $cover_pic;
        private $description;
        private $display_name;
        private $country_id;
        private $mobile_number;
        private $www;
        private $skype;

        private $friends;
        private $followers;

        private $albums;
        private $photos;

        /**
         * User constructor.
         * @param $email
         * @param $id
         * @param $first_name
         * @param $last_name
         * @param $full_name
         * @param $password
         * @param $reg_date
         * @param $gender
         * @param $birthday
         * @param $relation_status
         * @param $profile_pic
         * @param $cover_pic
         * @param $description
         * @param $display_name
         * @param $country_id
         * @param $mobile_number
         * @param $www
         * @param $skype
         * @param $friends
         * @param $followers
         * @param $albums
         * @param $photos
         */
        public function __construct($id = null, $email = null, $first_name = null, $last_name = null, $full_name = null,
                                    $password = null, $reg_date = null, $gender = null, $birthday = null,
                                    $relation_status = null, $profile_pic = null, $cover_pic = null,
                                    $description = null, $display_name = null, $country_id = null,
                                    $mobile_number = null, $www = null, $skype = null,
                                    $friends = null, $followers = null, $albums = null, $photos = null)
        {
            $this->id = $id;
            $this->email = $email;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->full_name = $full_name;
            $this->password = $password;
            $this->reg_date = $reg_date;
            $this->gender = $gender;
            $this->birthday = $birthday;
            $this->relation_status = $relation_status;
            $this->profile_pic = $profile_pic;
            $this->cover_pic = $cover_pic;
            $this->description = $description;
            $this->display_name = $display_name;
            $this->country_id = $country_id;
            $this->mobile_number = $mobile_number;
            $this->www = $www;
            $this->skype = $skype;
            $this->friends = $friends;
            $this->followers = $followers;
            $this->albums = $albums;
            $this->photos = $photos;
        }

        /**
         * @return null
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * @return null
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return null
         */
        public function getFirstName()
        {
            return $this->first_name;
        }

        /**
         * @return null
         */
        public function getLastName()
        {
            return $this->last_name;
        }

        /**
         * @return null
         */
        public function getFullName()
        {
            return $this->full_name;
        }

        /**
         * @return null
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * @return null
         */
        public function getRegDate()
        {
            return $this->reg_date;
        }

        /**
         * @return null
         */
        public function getGender()
        {
            return $this->gender;
        }

        /**
         * @return null
         */
        public function getBirthday()
        {
            return $this->birthday;
        }

        /**
         * @return null
         */
        public function getRelationStatus()
        {
            return $this->relation_status;
        }

        /**
         * @return null
         */
        public function getProfilePic()
        {
            return $this->profile_pic;
        }

        /**
         * @return null
         */
        public function getCoverPic()
        {
            return $this->cover_pic;
        }

        /**
         * @return null
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * @return null
         */
        public function getDisplayName()
        {
            return $this->display_name;
        }

        /**
         * @return null
         */
        public function getCountryId()
        {
            return $this->country_id;
        }

        /**
         * @return null
         */
        public function getMobileNumber()
        {
            return $this->mobile_number;
        }

        /**
         * @return null
         */
        public function getWww()
        {
            return $this->www;
        }

        /**
         * @return null
         */
        public function getSkype()
        {
            return $this->skype;
        }

        /**
         * @return null
         */
        public function getFriends()
        {
            return $this->friends;
        }

        /**
         * @return null
         */
        public function getFollowers()
        {
            return $this->followers;
        }

        /**
         * @return null
         */
        public function getAlbums()
        {
            return $this->albums;
        }

        /**
         * @return null
         */
        public function getPhotos()
        {
            return $this->photos;
        }

        /**
         * @param null $email
         */
        public function setEmail($email)
        {
            $this->email = $email;
        }

        /**
         * @param null $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @param null $first_name
         */
        public function setFirstName($first_name)
        {
            $this->first_name = $first_name;
        }

        /**
         * @param null $last_name
         */
        public function setLastName($last_name)
        {
            $this->last_name = $last_name;
        }

        /**
         * @param null $full_name
         */
        public function setFullName($full_name)
        {
            $this->full_name = $full_name;
        }

        /**
         * @param null $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }

        /**
         * @param null $reg_date
         */
        public function setRegDate($reg_date)
        {
            $this->reg_date = $reg_date;
        }

        /**
         * @param null $gender
         */
        public function setGender($gender)
        {
            $this->gender = $gender;
        }

        /**
         * @param null $birthday
         */
        public function setBirthday($birthday)
        {
            $this->birthday = $birthday;
        }

        /**
         * @param null $relation_status
         */
        public function setRelationStatus($relation_status)
        {
            $this->relation_status = $relation_status;
        }

        /**
         * @param null $profile_pic
         */
        public function setProfilePic($profile_pic)
        {
            $this->profile_pic = $profile_pic;
        }

        /**
         * @param null $cover_pic
         */
        public function setCoverPic($cover_pic)
        {
            $this->cover_pic = $cover_pic;
        }

        /**
         * @param null $description
         */
        public function setDescription($description)
        {
            $this->description = $description;
        }

        /**
         * @param null $display_name
         */
        public function setDisplayName($display_name)
        {
            $this->display_name = $display_name;
        }

        /**
         * @param null $country_id
         */
        public function setCountryId($country_id)
        {
            $this->country_id = $country_id;
        }

        /**
         * @param null $mobile_number
         */
        public function setMobileNumber($mobile_number)
        {
            $this->mobile_number = $mobile_number;
        }

        /**
         * @param null $www
         */
        public function setWww($www)
        {
            $this->www = $www;
        }

        /**
         * @param null $skype
         */
        public function setSkype($skype)
        {
            $this->skype = $skype;
        }

        /**
         * @param null $friends
         */
        public function setFriends($friends)
        {
            $this->friends = $friends;
        }

        /**
         * @param null $followers
         */
        public function setFollowers($followers)
        {
            $this->followers = $followers;
        }

        /**
         * @param null $albums
         */
        public function setAlbums($albums)
        {
            $this->albums = $albums;
        }

        /**
         * @param null $photos
         */
        public function setPhotos($photos)
        {
            $this->photos = $photos;
        }


    }