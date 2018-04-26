
<?php
    use \model\User;
    use Controller\UserController;

    if(isset($_GET['id']) && $_GET['id'] !== $_SESSION['logged']->getId() && is_numeric($_GET['id'])){
        $theUser = new User();
        $theUser->setId(htmlentities($_GET['id']));
        $newController = new UserController();
        $theUser = $newController->getUserInfo($theUser);
        if($theUser === false){
            $theUser = $_SESSION["logged"];
        }
    }
    else{
        $theUser = $_SESSION["logged"];
    }
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
                <div id="profileCover" class="jumbotron profile-cover border border-secondary" style="background-image: url('<?php echo URL_ROOT . $theUser->getProfileCover(); ?>')">
                    <?php
                        if($theUser->getId() === $_SESSION['logged']->getId()){

                        }
                        else {
                            ?>
                            <div class="card coverProfilePic text-center p-1">
                                <img src="<?php echo URL_ROOT . $theUser->getProfilePic(); ?>" alt="<?php
                                echo URL_ROOT . $theUser->getFirstName() . 'profile picture'; ?>">
                                <div class="font-weight-bold py-1 small block-inline">
                                    <?php echo ucwords($theUser->getFullName()); ?>
                                </div>
                                <ul class="navbar-nav small block-inline">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" id="friendRequests"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users text-dark"></i></a>
                                        <div class="dropdown-menu text-white" aria-labelledby="friendRequests">
                                           <a class="dropdown-item" href="#">Add Friend</a>
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
                    <?php var_dump($theUser); ?>
                </div>
                <div id="about" class="card">
                    <h1>About</h1>

                </div>
                <div id="friends" class="card">
                    <h1>Friend list</h1>
                </div>
                <div id="photos" class="card">
                    <h1>Albums</h1>

                    <div class="holder p-3">
                        <?php
                        if (isset($_GET['id']) && $_GET['id'] !== $_SESSION['logged']->getId()) {

                        }
                        else{
                            ?>
                            <span id="albumAdd">
                                <img class="img-thumbnail img_100" src="<?php echo URL_ROOT . '/assets/images/add_album_photos.png' ?>" alt="">
                            </span>
                            <?php
                        }
                        ?>
                        <span id="albumList"></span>
                    </div>
                    <hr>
                    <h1>Photos</h1>
                    <div class="holder p-3">
                    <?php
                    if (isset($_GET['id']) && $_GET['id'] !== $_SESSION['logged']->getId()) {

                    }
                    else{
                        ?>
                        <div id="input_holder">
                            <input type="file" id="upload_photos" class="btn-input" accept="image/*">
                        </div>
                        <span id="albumAdd">
                            <img class="img-thumbnail img_100" src="<?php echo URL_ROOT . '/assets/images/add_img.png' ?>" alt="">
                        </span>
                        <?php
                    }
                    ?>
                    <span id="image_list"></span>
                    </div>
                </div>
            </div>

        </div>
        <!--/row-->
    </div>
    <!--/.fluid-container-->
</div>