<?php

    namespace Controller;
    use Model\Dao\UserDao;
    use Model\Picture;
    use model\Thumbnail;

    class TestController extends BaseController{

        // create and validates picture and thumb for user profile - MAIN CALL #0
        public function uploadProfilePic(){

            if(isset($_POST['profilePicUpload'])) {


                // section -> photos, profile, cover, albums, posts
                // this control if you are allowed to send single or many
                $section = 'profile';
                $formImages = $_FILES['images'];

                // validation
                // returns assoc array -> form key , status key , err key
                $validResult = self::imageValidation($formImages, $section);
                var_dump($validResult);

                // if validation err or true / NOTE: wrong files or images wont stop
                if (isset($validResult['count_err'])) {
                    echo $validResult['count_err'];
                } elseif (isset($validResult['form']) && empty($validResult['form']['name'])) {
                    $status = array();
                    $status['error'] = 'Failed to upload!';
                    $status['info'] = $validResult['err'];
                    echo json_encode($status);
                } elseif (isset($validResult['form'])) {
                    $formImages = $validResult['form'];
                    $imgObjects = self::generateImagesList($formImages, $section);

                    // if img list generated
                    if ($imgObjects) {

                        // if thumbnail generated

                        self::generateThumbnailsList($imgObjects, $section);

                        try {
                            echo "pic send to upload";
                        } catch (\PDOException $e) {
                            echo $e->getMessage();
                        } catch (\Exception $e) {
                            echo $e->getMessage();
                        }

                    } else {
                        echo "images not created";
                    }
                } else {
                    echo "Validation Error...";
                }
            }
            else{

                header('location:'.URL_ROOT.'/error/401');
            }
        }


        // this functions work for single or multi upload;

        // validate images - no direct call  !!! Depends on other function - #1
        public function imageValidation($formImages,$section){

            if(!isset($formImages)){
                header('location:'.URL_ROOT.'/index/main&error=' . $msg);
            }
            else {

                // folder validation create folder if not found folders // photos// fullsize/ thumbs
                if (!file_exists(UPLOAD_PHOTOS)) {
                    if (mkdir(UPLOAD_PHOTOS)) {
                        if (!file_exists(UPLOAD_FULL_SIZE)) {
                            if (mkdir(UPLOAD_FULL_SIZE)) {

                            } else {
                                $msg = "fullsize folder fail";
                                header('location:' . URL_ROOT . '/index/profile&error=' . $msg);
                            }
                        }
                        if (!file_exists(UPLOAD_THUMBS)) {
                            if (mkdir(UPLOAD_THUMBS)) {

                            } else {
                                $msg = "Thumb folder failed";
                                header('location:' . URL_ROOT . '/index/profile&error=' . $msg);
                            }
                        }
                    } else {
                        $msg = "photos folder error";
                        header('location:' . URL_ROOT . '/index/profile&error=' . $msg);
                    }
                } else {
                    if (!file_exists(UPLOAD_FULL_SIZE)) {
                        if (mkdir(UPLOAD_FULL_SIZE)) {

                        } else {
                            $msg = "fullsize folder fail";
                            header('location:' . URL_ROOT . '/index/profile&error=' . $msg);
                        }
                    }
                    if (!file_exists(UPLOAD_THUMBS)) {
                        if (mkdir(UPLOAD_THUMBS)) {

                        } else {
                            $msg = "Thumb folder failed";
                            header('location:' . URL_ROOT . '/index/profile&error=' . $msg);
                        }
                    }
                }

                // count how many files are send, MAX 15 with -> type many
                // for profile and cover limit one

                switch ($section) {
                    case 'profile':
                    case 'cover':
                        $maxQuantity = 1;
                        $countFormImages = count($formImages['name']);
                        if ($countFormImages > $maxQuantity) {
                            $err['count_err'] = 'Profile and Cover picture upload limit is 1';
                            return $err;
                        }
                        break;
                    case 'photos';
                    case 'albums';
                    case 'posts';
                        $maxQuantity = MAX_IMG_UPLOAD_PHOTOS;
                        $countFormImages = count($formImages['name']);
                        if ($countFormImages > $maxQuantity) {
                            $err['count_err'] = 'Too many files, maximum images upload at once is ' . MAX_IMG_UPLOAD_PHOTOS;
                            return $err;
                        }
                        break;

                }

                // marking which files are not the one allowed
                $blackList = array();
                $num = 0;
                foreach ($formImages['type'] as $idx => $mime) {
                    if ($mime !== 'image/jpeg' && $mime !== 'image/png' && $mime !== 'image/gif') {

                        $blackList[$num]['idx'] = $idx;
                        $blackList[$num]['name'] = $formImages['name'][$idx];
                        $blackList[$num]['error'][] = 'File type not allowed';
                        $num++;
                    }

                }

                // check size for image
                $oldnum = 0;
                foreach ($formImages['size'] as $idx => $size) {
                    if ($size > MAX_IMG_UPLOAD_PHOTO_SIZE) {


                        if (isset($blackList[$oldnum]) && $idx === $blackList[$oldnum]['idx']) {
                            $blackList[$num]['size'] = $formImages['name'][$idx];
                            $blackList[$num]['errors'][] = 'File too large, max ' . MAX_IMG_UPLOAD_PHOTO_SIZE . ' each photo';
                        } else {
                            $num = count($blackList);
                            $blackList[$num]['idx'] = $idx;
                            $blackList[$num]['name'] = $formImages['name'][$idx];
                            $blackList[$num]['errors'][] = 'File too large, max ' . MAX_IMG_UPLOAD_PHOTO_SIZE . ' each photo';

                        }
                    }
                    $oldnum++;
                }

                // unset not allowed files from original


                foreach ($formImages as &$item) {
                    $count = 0;
                    foreach ($item as $idx => $param) {
                        if ($idx > count($blackList) - 1) {
                            break;
                        }

                        unset($item[$blackList[$count]['idx']]);
                        $count++;

                    }
                    // reset array indexes
                    $item = array_merge($item);
                }

                $data['status'] = true;
                $data['form'] = $formImages;
                $data['err'] = $blackList;

                return $data;
            }


        }

        // creates picture objects fill data and save to disk !!! Depends on other function - #2
        public function generateImagesList($imgList,$section)
        {
            if(!isset($imgList)){
                header('location:'.URL_ROOT.'/error/401');
            }
            else {


                $createdPics = array();

                $imgCount = count($imgList['name']);

                //creating empty pictures list
                for ($i = 0; $i < $imgCount; $i++) {
                    $createdPics[] = new Picture();
                }

                // setting pictures properties from form
                foreach ($imgList as $key => $prop) {
                    for ($x = 0; $x < count($prop); $x++) {
                        switch ($key) {
                            case "name":
                                $createdPics[$x]->setName($prop[$x]);
                                break;
                            case "type":
                                $createdPics[$x]->setType($prop[$x]);
                                break;
                            case "tmp_name":
                                $createdPics[$x]->setTmpFileUrl($prop[$x]);
                                break;
                            case "size":
                                $createdPics[$x]->setSize($prop[$x]);
                                break;
                        }
                    }
                }

                // set other properties based on whats given + write img on disk
                foreach ($createdPics as $img) {
                    // set picure mew name, !!! no extention onlu name
                    $img->setNewName($_SESSION['logged']->getFirstName() . '-' . time() . '-' . uniqid() . '-' . $section);

                    // set ext of the file only
                    $splitFile = explode(".", $img->getName());
                    $img->setExtension($splitFile[count($splitFile) - 1]);

                    // set path, check and move new file on disk
                    if (is_uploaded_file($img->getTmpFileUrl())) {
                        $pathfile = UPLOAD_FULL_SIZE . '/' . $img->getNewName() . "." . $img->getExtension();
                        if (move_uploaded_file($img->getTmpFileUrl(), $pathfile)) {
                            $img->setUrlOnDiskPicture($pathfile);
                        } else {
                            $error[] = "Files not moved!!!";
                        }
                    } else {
                        $error[] = 'files not uploaded!!!';
                    }
                    //set dimensions
                    $dim = getimagesize($img->getUrlOnDiskPicture());
                    $img->setWidth($dim[0]);
                    $img->setHeight($dim[1]);

                }

                if (!isset($error)) {
                    return $createdPics;
                } else {
                    return false;
                }
            }
        }

        // create thumb object fill data from picture object, !!! Depends on other function #3
        // save small pic to db - insert url to thumbs in picture object
        public function generateThumbnailsList($picObjects){
            if(!isset($imgList)){
                header('location:'.URL_ROOT.'/error/401');
            }
            else {

                $createdThumbs = array();

                $imgCount = count($picObjects);

                //creating empty pictures list
                for ($i = 0; $i < $imgCount; $i++) {
                    $createdThumbs[] = new Thumbnail();
                }

                $objectIndex = 0;
                // array for imagecreatefrom function
                $ims = array();
                // array for imagecreatetruecolor function
                $nms = array();
                foreach ($createdThumbs as $thumb) {
                    // set thumb mew name, !!! no extention onlu name
                    $thumb->setNewName($picObjects[$objectIndex]->getNewName());

                    // set ext of the file only
                    $thumb->setExtension($picObjects[$objectIndex]->getExtension());


                    if ($picObjects[$objectIndex]->getExtension() === 'jpg') {
                        $ims[$objectIndex] = imagecreatefromjpeg($picObjects[$objectIndex]->getUrlOnDiskPicture());
                    } elseif ($picObjects[$objectIndex]->getExtension() === 'gif') {
                        $ims[$objectIndex] = imagecreatefromgif($picObjects[$objectIndex]->getUrlOnDiskPicture());

                    } elseif ($picObjects[$objectIndex]->getExtension() === 'png') {
                        $ims[$objectIndex] = imagecreatefrompng($picObjects[$objectIndex]->getUrlOnDiskPicture());
                    }

                    // setHeight
                    $thumb->setHeight(THUMB_SIZE);
                    // setWidth
                    $thumb->setWidth(floor($picObjects[$objectIndex]->getWidth() * ($thumb->getHeight() / $picObjects[$objectIndex]->getHeight())));
                    $nms[$objectIndex] = imagecreatetruecolor($thumb->getWidth(), $thumb->getHeight());

                    imagecopyresized($nms[$objectIndex], $ims[$objectIndex], 0, 0, 0, 0, $thumb->getWidth(), $thumb->getHeight(), $picObjects[$objectIndex]->getWidth(), $picObjects[$objectIndex]->getHeight());

                    if ($thumb->getExtension() === 'jpg') {
                        imagejpeg($nms[$objectIndex], UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());

                        $thumb->setUrlOnDiskPicture(UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());
                    } elseif ($thumb->getExtension() === 'gif') {
                        imagegif($nms[$objectIndex], UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());
                        $thumb->setUrlOnDiskPicture(UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());
                    } elseif ($thumb->getExtension() === 'png') {
                        imagepng($nms[$objectIndex], UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());
                        $thumb->setUrlOnDiskPicture(UPLOAD_THUMBS . '/' . $thumb->getNewName() . '.' . $thumb->getExtension());
                    }

                    $picObjects[$objectIndex]->setUrlOnDiskThumb($thumb->getUrlOnDiskPicture());

                    $objectIndex++;
                }
            }

        }


    }