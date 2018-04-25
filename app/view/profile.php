
<?php
    use \model\User;
    use Controller\UserController;

    if(isset($_GET['id']) && $_GET['id'] !== $_SESSION['logged']->getId()){
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
                <div class="jumbotron profile-cover" style="background-image: url('<?php echo URL_ROOT . $theUser->getProfileCover(); ?>')">
                    <?php
                        if($theUser->getId() === $_SESSION['logged']->getId()){

                        }
                        else {
                            ?>
                            <div class="card coverProfilePic text-center p-1">
                                <img src="<?php echo URL_ROOT . $theUser->getProfilePic(); ?>" alt="<?php
                                echo URL_ROOT . $theUser->getFirstName() . 'profile picture'; ?>">
                                <div class="font-weight-bold py-1 small">
                                    <?php echo ucwords($theUser->getFullName()); ?>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <hr>
                <div class="post_modal mt-4 mb-4">
                    <?php require_once '../app/include/modules/post-mod.php';?>
                </div>
                <hr>
                <h2>Your Posts:</h2>
                <div class="card p-3 mt-3 mb-3">
                    <h3>Session</h3>
                    <p>
                        <?php var_dump($_SESSION); ?>
                    </p>
                </div>
                <div class="card p-3 mt-3 mb-3">
                    <h3>Var object $theUser</h3>
                    <p>
                        <?php var_dump($theUser); ?>
                    </p>
                </div>
            </div>

        </div>
        <!--/row-->
    </div>
    <!--/.fluid-container-->
</div>