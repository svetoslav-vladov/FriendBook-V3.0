<?php
namespace model;

class Post {
    private $post_id;
    private $owner_id;
    private $description;
//    private $post_photos = array();

    /**
     * Post constructor.
     * @param $owner_id
     * @param $description
     * @param array $post_photos
     */
    public function __construct($owner_id, $description) {
        $this->owner_id = $owner_id;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPostId(){
        return $this->post_id;
    }
    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id) {
        $this->post_id = $post_id;
    }
    /**
     * @return mixed
     */
    public function getOwnerId() {
        return $this->owner_id;
    }
    /**
     * @param mixed $owner_id
     */
    public function setOwnerId($owner_id) {
        $this->owner_id = $owner_id;
    }
    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }
    /**
     * @param mixed $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }
}