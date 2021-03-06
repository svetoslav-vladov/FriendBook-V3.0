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
                <div class="post_modal mb-5" id="post-panel">
                    <?php require_once '../app/include/modules/post-mod.php';?>
                </div>
                <div>
                    <?php require_once '../app/include/modules/share-photos-mod.php';?>
                </div>
                <hr>
                <h2>News Feed:</h2>
                <a href="<?php echo URL_ROOT; ?>/index/postsbylike">Sort posts by like</a>
                <div class="news_feed_posts">
                    <?php require_once '../app/include/modules/news_feed_posts.php'; ?>
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
