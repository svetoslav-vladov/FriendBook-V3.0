
<?php
// data generated from the index:profile view
    $theUser = $data;
?>

<div id="wrap" class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-3">
                <div class="sidebar-nav-fixed affix" id="sidemenu">
                    <div class="well">
                        <?php require_once '../app/include/modules/left_profile_info.php';?>
                    </div>
                    <!--/.well -->
                </div>
                <!--/sidebar-nav-fixed -->
            </div>
            <!--/span-->
            <div class="col-md-9" id="#main">
                <div id="profileCover" class="jumbotron profile-cover border border-secondary" style="background-image: url('<?php
                    if($theUser->getThumbsCover() !== null){
                        echo URL_ROOT . $theUser->getThumbsCover();
                    }
                    else{
                        echo URL_ROOT . $theUser->getProfileCover();
                    }
                ?>')">
                    <a id="cover_link" class="profile_cover_link" data-toggle="lightbox" data-gallery="my_profile_cover"
                       href="<?php echo URL_ROOT . $theUser->getProfileCover(); ?>">
                    </a>
                    <?php
                        // button and form for change cover - start
                        if($theUser->getId() === $_SESSION['logged']->getId()){
                            ?>
                            <div id="change_profile_cover">
                                <i class="fas fa-edit"></i>
                            </div>
                            <form id="upload_cover_form" class="d-none" action="<?php echo URL_ROOT . "/user/changeProfilePic" ?>" method="post" enctype="multipart/form-data">
                                <label for="cover_image_input"></label>
                                <input type="file" id="cover_image_input" name="images[]" multiple accept="image/*">
                            </form>
                        <?php

                        } // button and form for change cover - end

                        if(!($theUser->getId() === $_SESSION['logged']->getId())){
                            ?>
                            <div class="coverProfilePic card text-center p-1">
                                <a data-toggle="lightbox" data-gallery="other_profile_pic" href="<?php echo URL_ROOT . $theUser->getProfilePic(); ?>">
                                    <img src="<?php if(is_null($theUser->getThumbsProfile())){ echo URL_ROOT . $theUser->getProfilePic(); }
                                    else{ echo URL_ROOT . $theUser->getThumbsProfile();} ?>" alt="<?php
                                    echo $theUser->getFullName() . 'profile picture'; ?>">
                                </a>

                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown col-md-12">
                                        <a class="nav-link dropdown-toggle text-dark" id="friendRequests"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php echo ucwords($theUser->getFullName()); ?>
                                            <i class="fa fa-users text-dark"></i></a>
                                        <div class="dropdown-menu text-white" aria-labelledby="friendRequests">
                                            <a class="dropdown-item" onclick="sendFriendRequest(<?php echo $theUser->getId(); ?>)" href="#">Add Friend</a>
                                            <a class="dropdown-item" href="#">Follow</a>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                            <?php
                        }
                    ?>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3"><button id="myPosts_btn" class="list-inline-item btn btn-outline-success btn-block"><span class="nav-icon"><i class="fas fa-clipboard"></i></span>My Posts</button></div>
                        <div class="col-md-3"><button id="about_btn" class="list-inline-item btn btn-outline-success btn-block"><span class="nav-icon"><i class="fas fa-address-card"></i></span>About</button></div>
                        <div class="col-md-3"><button id="friends_btn" class="list-inline-item btn btn-outline-success btn-block"><span class="nav-icon"><i class="fas fa-users"></i></span>Friends</button></div>
                        <div class="col-md-3"><button id="pictures_btn" class="list-inline-item btn btn-outline-success btn-block"><span class="nav-icon"><i class="fas fa-images"></i></span>Pictures</button></div>
                    </div>
                </div>
                <hr>
                <input type="hidden" name="user_id" id="user_nav_id" value="<?php echo $theUser->getId(); ?>">

                <div id="timeline">
                    <h1>Your Posts:</h1>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div id="profile_news_feed" class="col-md-9">
                                <script>
                                    $(document).ready(function () {
                                        var limit = 3;
                                        var offset = 0;
                                        getOwnPosts(<?php echo $theUser->getId(); ?>, limit, offset);

                                        $(window).scroll(function() {
                                            if($(window).scrollTop() == $(document).height() - ($(window).height())) {
                                                offset += 3;
                                                $('.loading_posts').show();
                                                setTimeout(function () {
                                                    getOwnPosts(<?php echo $theUser->getId(); ?>, limit, offset);
                                                },200);
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="loading_posts_container">
                        <img src="<?php echo URL_ROOT."/assets/images/ajax-loading-c4.gif"?>" class="loading_posts" style="display: none">
                    </div>
                </div>
                <div id="about" class="card p-3">
                    <h1>About</h1>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                <div>
                                    <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span>
                                    <span class="aboutTag">Registered on:</span>
                                    <span class="aboutValue"><?php echo $theUser->getRegDate(); ?></span>
                                </div>
                                <div>
                                    <span class="nav-icon"><i class="fas fa-transgender"></i></span>
                                    <span class="aboutTag">Gender:</span>
                                    <span class="aboutValue"><?php echo $theUser->getGender() ?></span>
                                </div>
                                <div>
                                    <span class="nav-icon"><i class="fas fa-birthday-cake"></i></span>
                                    <span class="aboutTag">Birthday on:</span>
                                    <span class="aboutValue"><?php echo $theUser->getBirthday(); ?></span>
                                </div>
                                <div>
                                    <span class="nav-icon"><i class="fas fa-university"></i></span>
                                    <span class="aboutTag">Country on:</span>
                                    <span class="aboutValue"><?php echo $theUser->getCountryName(); ?></span>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div>
                                    <span class="nav-icon"><i class="fas fa-heartbeat"></i></span>
                                    <span class="aboutTag">Relationship:</span>
                                    <span class="aboutValue"><?php echo $theUser->getRelationshipTag(); ?></span>
                                </div>
                                <div>
                                    <span class="nav-icon"><i class="fas fa-mobile-alt"></i></span>
                                    <span class="aboutTag">Phone:</span>
                                    <span class="aboutValue"><?php echo $theUser->getMobileNumber() ?></span>
                                </div>
                                <div>
                                    <span class="nav-icon"><i class="fas fa-globe"></i></span>
                                    <span class="aboutTag">Website:</span>
                                    <span class="aboutValue"><?php echo $theUser->getWww(); ?></span>
                                </div>
                                <div>
                                    <span class="nav-icon"><i class="fab fa-skype"></i></span>
                                    <span class="aboutTag">Skype:</span>
                                    <span class="aboutValue"><?php echo $theUser->getSkype(); ?></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm">
                                <h5>Description</h5>
                                <div><p id="descAboutText"><?php echo $theUser->getDescription(); ?></p></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="friends" class="card">
                    <h1>Friend list</h1>
                    <div class="friendsContainer" id="friendsContainer<?php if(isset($_GET['id'])) { echo $_GET['id'];} else { echo  $_SESSION['logged']->getId();}?>">
                        <?php if ($theUser->getId() == $_SESSION['logged']->getId()) { ?>
                            <script>
                                $(document).ready(function () {
                                    getOwnFriends(<?php echo $_SESSION['logged']->getId();?>);
                                });
                            </script>
                       <?php } else { ?>
                            <script>
                                $(document).ready(function () {
                                    getFriends(<?php echo $theUser->getId();?>);
                                });
                            </script>
                       <?php }?>
                    </div>
                </div>
                <div id="photos" class="card p-3">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card p-3 text-center small" id="albumAdd" data-toggle="modal" data-target="#albumPopupInsert">
                                <?php
                                if (!(isset($_GET['id']) && $_GET['id'] !== $_SESSION['logged']->getId())) {
                                    ?>
                                    <span>
                                        <img class="img-thumbnail" src="<?php echo URL_ROOT . '/assets/images/addAlbum.png' ?>" alt="">
                                    </span>
                                    <?php
                                }
                                ?>
                                <div>Add Album</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 text-center small" id="ImageAdd">
                                <?php
                                if (!(isset($_GET['id']) && $_GET['id'] !== $_SESSION['logged']->getId())) {
                                    ?>
                                    <form id="uploadUserPhotosForm" action="<?php echo URL_ROOT . "/user/uploadProfilePhotos"; ?>" method="post" enctype="multipart/form-data">
                                        <input name="images[]" id="uploadPhotosInput" type="file" multiple accept="image/*"/>
                                    </form>
                                    <span>
                                         <img class="img-thumbnail" id="imageUploadBtn" src="<?php echo URL_ROOT . '/assets/images/addImage.png' ?>" alt="">
                                    </span>
                                    <?php
                                }
                                ?>
                                <div>Add Photos</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 text-center small" id="statusBoxPics">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h1>Albums</h1>

                    <div class="holder p-3">
                        <span id="albumList"></span>
                        <span id="albumPagination"></span>
                    </div>
                    <hr>
                    <h1>Photos</h1>
                    <p>Limit 16 imgs</p>
                    <div class="holder p-3">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="row text-center" id="image_list">
                                    <!-- images generate here !-->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--/row-->
    </div>
    <!--/.fluid-container-->
</div>

<!-- The Modal for album add-->
<div class="modal" id="albumPopupInsert">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create photo album</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="albumInsertForm" action="<?php echo URL_ROOT . '/user/createAlbumUploadPhotos' ?>"
                      method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="albumName">Album Name:</label>
                        <input type="text" name="albumName" id="albumName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="albumName">Upload photos:</label>
                        <input type="file" name="albumFiles[]" id="albumFiles" multiple class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="small">
                                <li>Album name max 30 characters</li>
                                <li>All fileds required, atleast one photo and album name</li>
                                <li>Maximum images for upload at once <?php echo MAX_IMG_UPLOAD_PHOTOS; ?></li>
                                <li>Max image size <?php echo formatBytes(MAX_IMG_UPLOAD_PHOTO_SIZE); ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <button type="button" class="btn btn-success form-control" id="createAlbumSubmit"
                                    data-dismiss="modal">Create</button>
                        </div>
                        <div class="col-md-6 text-center">
                        <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
                    </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>