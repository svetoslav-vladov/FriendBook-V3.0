<div id="wrap" class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar-nav-fixed affix" id="sidemenu">
                    <div class="well">
                       <h1>Left Sidebar</h1>
                    </div>
                    <!--/.well -->
                </div>
                <!--/sidebar-nav-fixed -->
            </div>
            <!--/span-->
            <div class="col-md-6" id="#main">
                <h1>Main</h1>
                <div class="card p-3 mt-3 mb-3">
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Open modal
                    </button>

                    <!-- The Modal -->
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Modal Heading</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Modal body..
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card p-3 mt-3 mb-3">
                    <h2>Post</h2>
                    <p>
                        <?php var_dump($_SESSION); ?>
                    </p>
                </div>
                <div class="card p-3 mt-3 mb-3">
                    <h2>Post</h2>
                    <p>
                        <?php var_dump($_SESSION); ?>
                    </p>
                </div>
                <div class="card p-3 mt-3 mb-3">
                    <h2>Post</h2>
                    <p>
                        <?php var_dump($_SESSION); ?>
                    </p>
                </div>

            </div>
            <!--/span-->
            <div class="col-md-3">
                <div class="sidebar-nav-fixed pull-right affix" id="sidemenu">
                    <div class="well">
                        <h1>Right Sidebar</h1>
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
