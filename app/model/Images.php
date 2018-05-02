<?php

    namespace model;

   abstract class Images{

        protected $name;
        protected $type;
        protected $tmpFileUrl;
        protected $size;

        protected $height;
        protected $width;
        protected $urlOnDiskPicture;
        protected $urlOnDiskThumb;
        protected $newName;
        protected $extension;

       /**
        * Images constructor.
        * @param $name
        * @param $type
        * @param $tmpFileUrl
        * @param $size
        * @param null $height
        * @param null $width
        * @param null $urlOnDisk
        * @param null $newName
        * @param null $extension
        */
       public function __construct($name=null, $type=null, $tmpFileUrl=null, $size=null,
                                   $height=null, $width=null, $urlOnDiskPicture=null, $urlOnDiskThumb =null,
                                   $newName=null, $extension=null)
       {
           $this->name = $name;
           $this->type = $type;
           $this->tmpFileUrl = $tmpFileUrl;
           $this->size = $size;
           $this->height = $height;
           $this->width = $width;
           $this->urlOnDiskPicture = $urlOnDiskPicture;
           $this->urlOnDiskThumb = $urlOnDiskThumb;
           $this->newName = $newName;
           $this->extension = $extension;
       }
        public function jsonSerialize()
        {

        }

       public function object_to_array($data)
       {

           if(is_array($data) || is_object($data))

           {
               $result = array();

               foreach($data as $key => $value) {
                   $result[$key] = $this->object_to_array($value);
               }

               return $result;
           }

           return $data;
       }
   }