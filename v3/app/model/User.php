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

        private $relationship_id;
        private $profile_pic;
        private $profile_cover;
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

        private $thumbs_profile;
        private $thumbs_cover;

        private $relationship_tag;
        private $country_name;

        /**
         * User constructor.
         * @param $id
         * @param $email
         * @param $first_name
         * @param $last_name
         * @param $full_name
         * @param $password
         * @param $reg_date
         * @param $gender
         * @param $birthday
         * @param $relationship_id
         * @param $profile_pic
         * @param $profile_cover
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
         * @param $thumbs_profile
         * @param $thumbs_cover
         * @param $relationship_tag
         * @param $country_name
         */
        public function __construct(
            $id=null, $email=null, $first_name=null, $last_name=null,
            $full_name=null, $password=null, $reg_date=null, $gender=null,
            $birthday=null, $relationship_id=null, $profile_pic=null,
            $profile_cover=null, $description=null, $display_name=null,
            $country_id=null, $mobile_number=null, $www=null, $skype=null, $friends=null,
            $followers=null, $albums=null, $photos=null, $thumbs_profile=null, $thumbs_cover=null,
            $relationship_tag=null, $country_name=null){

                $this->id = $id;
                $this->email = $email;
                $this->first_name = $first_name;
                $this->last_name = $last_name;
                $this->full_name = $full_name;
                $this->password = $password;
                $this->reg_date = $reg_date;
                $this->gender = $gender;
                $this->birthday = $birthday;
                $this->relationship_id = $relationship_id;
                $this->profile_pic = $profile_pic;
                $this->profile_cover = $profile_cover;
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
                $this->thumbs_profile = $thumbs_profile;
                $this->thumbs_cover = $thumbs_cover;
                $this->relationship_tag = $relationship_tag;
                $this->country_name = $country_name;
        }

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
        public function getEmail()
        {
            return $this->email;
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
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * @return mixed
         */
        public function getRegDate()
        {
            return $this->reg_date;
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
        public function getRelationshipId()
        {
            return $this->relationship_id;
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
        public function getProfileCover()
        {
            return $this->profile_cover;
        }

        /**
         * @return mixed
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * @return mixed
         */
        public function getDisplayName()
        {
            return $this->display_name;
        }

        /**
         * @return mixed
         */
        public function getCountryId()
        {
            return $this->country_id;
        }

        /**
         * @return mixed
         */
        public function getMobileNumber()
        {
            return $this->mobile_number;
        }

        /**
         * @return mixed
         */
        public function getWww()
        {
            return $this->www;
        }

        /**
         * @return mixed
         */
        public function getSkype()
        {
            return $this->skype;
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
        public function getThumbsProfile()
        {
            return $this->thumbs_profile;
        }

        /**
         * @return mixed
         */
        public function getThumbsCover()
        {
            return $this->thumbs_cover;
        }

        /**
         * @return mixed
         */
        public function getRelationshipTag()
        {
            return $this->relationship_tag;
        }

        /**
         * @return mixed
         */
        public function getCountryName()
        {
            return $this->country_name;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @param mixed $email
         */
        public function setEmail($email)
        {
            $this->email = $email;
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
         * @param mixed $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }

        /**
         * @param mixed $reg_date
         */
        public function setRegDate($reg_date)
        {
            $this->reg_date = $reg_date;
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
         * @param mixed $relationship_id
         */
        public function setRelationshipId($relationship_id)
        {
            $this->relationship_id = $relationship_id;
        }

        /**
         * @param mixed $profile_pic
         */
        public function setProfilePic($profile_pic)
        {
            $this->profile_pic = $profile_pic;
        }

        /**
         * @param mixed $profile_cover
         */
        public function setProfileCover($profile_cover)
        {
            $this->profile_cover = $profile_cover;
        }

        /**
         * @param mixed $description
         */
        public function setDescription($description)
        {
            $this->description = $description;
        }

        /**
         * @param mixed $display_name
         */
        public function setDisplayName($display_name)
        {
            $this->display_name = $display_name;
        }

        /**
         * @param mixed $country_id
         */
        public function setCountryId($country_id)
        {
            $this->country_id = $country_id;
        }

        /**
         * @param mixed $mobile_number
         */
        public function setMobileNumber($mobile_number)
        {
            $this->mobile_number = $mobile_number;
        }

        /**
         * @param mixed $www
         */
        public function setWww($www)
        {
            $this->www = $www;
        }

        /**
         * @param mixed $skype
         */
        public function setSkype($skype)
        {
            $this->skype = $skype;
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

        /**
         * @param mixed $thumbs_profile
         */
        public function setThumbsProfile($thumbs_profile)
        {
            $this->thumbs_profile = $thumbs_profile;
        }

        /**
         * @param mixed $thumbs_cover
         */
        public function setThumbsCover($thumbs_cover)
        {
            $this->thumbs_cover = $thumbs_cover;
        }

        /**
         * @param mixed $relationship_tag
         */
        public function setRelationshipTag($relationship_tag)
        {
            $this->relationship_tag = $relationship_tag;
        }

        /**
         * @param mixed $country_name
         */
        public function setCountryName($country_name)
        {
            $this->country_name = $country_name;
        }


    }