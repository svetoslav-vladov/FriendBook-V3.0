<div id="wrap" class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-3">
                <div class="sidebar-nav-fixed affix" id="sidemenu">
                    <div class="well">
                        <div id="user-nav" class="text-success">
                            <ul class="list-group">
                                <li class="text-success list-group-item list-group-item-action"
                                id="general">
                                    <span class="nav-icon"><i class="fas fa-cogs"></i></span>General
                                </li>
                                <li class="text-success list-group-item list-group-item-action"
                                id="security">
                                    <span class="nav-icon"><i class="fas fa-key"></i></span>Security
                                </li>
                            </ul>
                            <div id="settingsStatus" class="text-center mt-3 p-3"></div>
                        </div>
                    </div>
                    <!--/.well -->
                </div>
                <!--/sidebar-nav-fixed -->
            </div>
            <!--/span-->
            <div class="col-md-9" id="#main">
                <div class="card p-3" id="general_box">
                    <form id="general_form" action="<?php echo URL_ROOT . '/users/saveGeneralSettings'; ?>" method="post">
                        <fieldset>
                            <legend>General Settings</legend>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <ul>
                                    <li>If Display name is set, it will show instead of Full name, as your tag for others!</li>
                                </ul>
                                Display Name</label>
                                <input type="text" name="display_name" id="display_name" class="form-control">
                            </div>

                            <div class="form-group">

                                <label for="relation_status">Relationship status</label>
                                <select name="relation_status" id="relation_status" class="form-control">
                                    <option value="" selected>Select option</option>
                                    <?php
                                    foreach ($data['relationship'] as $status){
                                        echo "<option value=\"$status->id\">$status->status_name</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="" selected>Select option</option>
                                    <option value="male">Male</option>
                                    <option value="male">Female</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="birthday">Your BirthDay</label>
                                <input type="date" name="birthday" id="birthday" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="country">Country</label>
                                <select name="country" id="country" class="form-control">
                                    <option value="" selected>Select option</option>
                                    <?php
                                        foreach ($data['countries'] as $country){
                                            echo "<option value=\"$country->id\">$country->country_name</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="web_addres">Website address</label>
                                <input type="text" name="web_addres" id="web_addres" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="mobile_number">Mobile Number</label>
                                <input type="number" name="mobile_number" id="mobile_number" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="skype_name">Skype username</label>
                                <input type="text" name="skype_name" id="skype_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <input type="submit" name="general" id="general_submit" class="btn btn-success btn-lg" value="SAVE">
                            </div>

                        </fieldset>
                    </form>
                </div>
                <div class="card p-3" id="security_box">
                    <h1>Security information:</h1>
                    <form id="security_form" action="<?php echo URL_ROOT . '/user/saveSecuritySettings'; ?>" method="post">
                        <fieldset>
                            <legend>Security Settings</legend>

                            <div class="form-group">
                                <ul>
                                    <li>This will change your login!!!</li>
                                </ul>
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="old_password">Old password</label>
                                <input type="text" name="old_password" id="old_password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="text" name="new_password" id="new_password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="new_password_valid">New Password validation</label>
                                <input type="text" name="new_password_valid" id="new_password_valid" class="form-control">
                            </div>

                            <div class="form-group">
                                <input type="submit" name="security" id="security" class="btn btn-warning btn-lg" value="SAVE">
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>

        </div>
        <!--/row-->
    </div>
    <!--/.fluid-container-->
</div>
