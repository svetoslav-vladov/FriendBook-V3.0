<!-- The change email modal-->
<div class="modal" id="emailChange">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Email change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="changeUserEmailForm" action="<?php echo URL_ROOT . '/user/changeEmail' ?>" method="post">
                    <div class="form-group">
                        <label for="email">Email:
                            <span class="currentState" id="currentStateEmail">
                                <?php echo $_SESSION['logged']->getEmail(); ?>
                            </span>
                        </label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Type new email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="emailPassword" id="emailPassword" class="form-control" placeholder="Type your current password">
                    </div>

                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id="responseStatusEmail"></div>
                <button type="button" class="btn btn-success" data-dismiss="modal" id="emailChangeSubmit">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- The change password modal-->
<div class="modal" id="passwordChange">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Password change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="changeUserPassForm" action="<?php echo URL_ROOT . '/user/changePassword' ?>" method="post">
                    <div class="form-group">
                        <label for="oldPass">Old Password:</label>
                        <input type="password" name="oldPass" id="oldPass" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="newPass">New Password:</label>
                        <input type="password" name="newPass" id="newPass" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="newPassValid">New Password confirm:</label>
                        <input type="password" name="newPassValid" id="newPassValid" class="form-control">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id="responseStatusPassword"></div>
                <button type="button" class="btn btn-success" data-dismiss="modal" id="changePasswordSubmit">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>