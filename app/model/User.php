<?php

    namespace model;

    class User{

        private $id;

        private $first_name;
        private $last_name;
        private $full_name;

        private $email;
        private $password;
        private $gender;
        private $birthday;

        private $profile_pic;
        private $cover_pic;

        private $friends;
        private $followers;

        private $albums;
        private $photos;

        private $reg_date;

        /**
         * User constructor.
         * @param $id
         * @param $first_name
         * @param $last_name
         * @param $full_name
         * @param $email
         * @param $password
         * @param $gender
         * @param $birthday
         * @param $profile_pic
         * @param $cover_pic
         * @param $friends
         * @param $followers
         * @param $albums
         * @param $photos
         * @param $reg_date
         */
//        public function __construct($id = null, $first_name = null, $last_name = null, $full_name = null, $email, $password = null,
//                                    $gender= null, $birthday = null, $profile_pic = null, $cover_pic = null, $friends = null,
//                                    $followers = null, $albums = null, $photos = null, $reg_date = null) {
//            $this->id = $id;
//            $this->first_name = $first_name;
//            $this->last_name = $last_name;
//            $this->full_name = $full_name;
//            $this->email = $email;
//            $this->password = $password;
//            $this->gender = $gender;
//            $this->birthday = $birthday;
//            $this->profile_pic = $profile_pic;
//            $this->cover_pic = $cover_pic;
//            $this->friends = $friends;
//            $this->followers = $followers;
//            $this->albums = $albums;
//            $this->photos = $photos;
//            $this->reg_date = $reg_date;
//        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return mixed
         */
        public function getFirstName()
        {
            return $this->first_name;
        }

        /**
         * @return mixed
         */
        public function getLastName()
        {
            return $this->last_name;
        }

        /**
         * @return mixed
         */
        public function getFullName()
        {
            return $this->full_name;
        }

        /**
         * @return mixed
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * @return mixed
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * @return mixed
         */
        public function getGender()
        {
            return $this->gender;
        }

        /**
         * @return mixed
         */
        public function getBirthday()
        {
            return $this->birthday;
        }

        /**
         * @return mixed
         */
        public function getProfilePic()
        {
            return $this->profile_pic;
        }

        /**
         * @return mixed
         */
        public function getCoverPic()
        {
            return $this->cover_pic;
        }

        /**
         * @return mixed
         */
        public function getFriends()
        {
            return $this->friends;
        }

        /**
         * @return mixed
         */
        public function getFollowers()
        {
            return $this->followers;
        }

        /**
         * @return mixed
         */
        public function getAlbums()
        {
            return $this->albums;
        }

        /**
         * @return mixed
         */
        public function getPhotos()
        {
            return $this->photos;
        }

        /**
         * @return mixed
         */
        public function getRegDate()
        {
            return $this->reg_date;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @param mixed $first_name
         */
        public function setFirstName($first_name)
        {
            $this->first_name = $first_name;
        }

        /**
         * @param mixed $last_name
         */
        public function setLastName($last_name)
        {
            $this->last_name = $last_name;
        }

        /**
         * @param mixed $full_name
         */
        public function setFullName($full_name)
        {
            $this->full_name = $full_name;
        }

        /**
         * @param mixed $email
         */
        public function setEmail($email)
        {
            $this->email = $email;
        }

        /**
         * @param mixed $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }

        /**
         * @param mixed $gender
         */
        public function setGender($gender)
        {
            $this->gender = $gender;
        }

        /**
         * @param mixed $birthday
         */
        public function setBirthday($birthday)
        {
            $this->birthday = $birthday;
        }

        /**
         * @param mixed $profile_pic
         */
        public function setProfilePic($profile_pic)
        {
            $this->profile_pic = $profile_pic;
        }

        /**
         * @param mixed $cover_pic
         */
        public function setCoverPic($cover_pic)
        {
            $this->cover_pic = $cover_pic;
        }

        /**
         * @param mixed $friends
         */
        public function setFriends($friends)
        {
            $this->friends = $friends;
        }

        /**
         * @param mixed $followers
         */
        public function setFollowers($followers)
        {
            $this->followers = $followers;
        }

        /**
         * @param mixed $albums
         */
        public function setAlbums($albums)
        {
            $this->albums = $albums;
        }

        /**
         * @param mixed $photos
         */
        public function setPhotos($photos)
        {
            $this->photos = $photos;
        }




    }