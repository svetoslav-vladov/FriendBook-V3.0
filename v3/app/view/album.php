
<?php
// data generated from the index:profile view
$theUser = $data;
?>

<div id="wrap" class="mt-5">
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

        </div>
    </div>
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
               <?php
                    //var_dump($data);
                    // $data['userInfo'] is stdClass object
                    // $data['otherView'] is stdClass object
                    // $data['yourView'] is stdClass object
                    // $data['albums'] is stdClass object

                    if(isset($data['errors'])){
                        echo '<h2 class="text-center text-danger">' . $data['errors'] . '</h2>';

                    }
                    elseif(isset($data['otherView'])){

                        // this will show if passed userId is not Session id
                        if(isset($data['userInfo']) && ($_SESSION['logged']->getId() !== $data['userInfo']->id)) { // session id check

                            // setting full name var
                            $fullName =  $data['userInfo']->first_name . " " . $data['userInfo']->last_name;

                            // setting user profile pic between thumb or original
                            if(isset($data['userInfo']->thumbs_profile)){
                                $profilePic = $data['userInfo']->thumbs_profile;
                            }
                            else{
                                $profilePic = $data['userInfo']->profile_pic;
                            }

                            ?>

                            <div class="row mb-3">
                                <div class="col-md-3 px-3">
                                    <a href="<?php echo URL_ROOT . '/index/profile&id=' . $data['userInfo']->id ?>"
                                       class="card text-center">
                                        <div class="large py-2">
                                            Album Owner:
                                        </div>
                                        <img class="img_100" src="<?php echo URL_ROOT . $profilePic; ?>"
                                             alt="<?php echo $fullName; ?> profile pic"
                                             title="<?php echo $fullName; ?>">
                                        <div class="large py-2">
                                            <?php echo $fullName; ?>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <?php
                        } // session id check -> end
                        albumPhotoShow($data['otherView']);
                    }
                    elseif(isset($data['yourView'])){
                        // view your photos for album by id
                        albumPhotoShow($data['yourView']);
                    }
                    else{
                        // view your album list
                        echo '<h1>Albums</h1>';
                        albumShow($data['albums']);
                    }
               ?>
            </div>
        </div>
        <!--/row-->
    </div>
    <!--/.fluid-container-->
</div>