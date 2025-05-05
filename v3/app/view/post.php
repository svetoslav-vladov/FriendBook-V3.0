<?php
    $post_id = htmlentities($_GET['post_id'])
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
            <div class="col-md-6" id="#main">
                <h2>Post:</h2>
                <div id="single-post">
                    <script>
                        $(document).ready(function () {
                            getSinglePost(<?php echo $post_id; ?>);
                        });
                    </script>
                </div>
            </div>
            <!--/span-->
            <div class="col-md-3 col-lg-3">
                <div class="sidebar-nav-fixed pull-right affix" id="sidemenu">
                    <div class="well">
                        <?php require_once '../app/include/modules/suggested-users.php'; ?>
                    </div>
                    <!--/.well -->
                </div>
                <!--/sidebar-nav-fixed -->
            </div>
            <!--/span-->
        </div>
        <!--/row-->
    </div>
    <!--/.fluid-container-->
</div>
