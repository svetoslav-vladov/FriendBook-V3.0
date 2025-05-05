
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

        </div>
        <!--/row-->
    </div>
    <!--/.fluid-container-->
</div>