<?php

namespace model;

class Picture extends Images
{

   public function __construct($name = null, $type = null,
                               $tmpFileUrl = null, $size = null,
                               $height = null, $width = null,
                               $urlOnDiskPicture = null, $urlOnDiskThumb = null,
                               $newName = null, $extension = null)
   {
       parent::__construct($name, $type, $tmpFileUrl, $size, $height
           , $width, $urlOnDiskPicture, $urlOnDiskThumb, $newName, $extension);
   }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return null
     */
    public function getTmpFileUrl()
    {
        return $this->tmpFileUrl;
    }

    /**
     * @return null
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return null
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return null
     */
    public function getUrlOnDiskPicture()
    {
        return $this->urlOnDiskPicture;
    }

    /**
     * @return null
     */
    public function getUrlOnDiskThumb()
    {
        return $this->urlOnDiskThumb;
    }

    /**
     * @return null
     */
    public function getNewName()
    {
        return $this->newName;
    }

    /**
     * @return null
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param null $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param null $tmpFileUrl
     */
    public function setTmpFileUrl($tmpFileUrl)
    {
        $this->tmpFileUrl = $tmpFileUrl;
    }

    /**
     * @param null $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @param null $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @param null $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @param null $urlOnDiskPicture
     */
    public function setUrlOnDiskPicture($urlOnDiskPicture)
    {
        $this->urlOnDiskPicture = $urlOnDiskPicture;
    }

    /**
     * @param null $urlOnDiskThumb
     */
    public function setUrlOnDiskThumb($urlOnDiskThumb)
    {
        $this->urlOnDiskThumb = $urlOnDiskThumb;
    }

    /**
     * @param null $newName
     */
    public function setNewName($newName)
    {
        $this->newName = $newName;
    }

    /**
     * @param null $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

}