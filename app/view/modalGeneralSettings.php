<!-- The change FirstName -->
<div class="modal" id="firstNameChange">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">First Name change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="userFirstNameForm" action="<?php echo URL_ROOT . '/user/changeFirstName' ?>" method="post">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" id="firstName" class="form-control" placeholder="<?php
                        echo $_SESSION['logged']->getFirstName(); ?>">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="firstNameSubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- The change LastName -->
<div class="modal" id="lastNameChange">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Last Name change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="userLastNameForm" action="<?php echo URL_ROOT . '/user/changeLastName' ?>" method="post">
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" id="lastName" class="form-control" placeholder="<?php
                        echo $_SESSION['logged']->getLastName(); ?>">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="lastNameSubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- The change DisplayName -->
<div class="modal" id="displayNameChange">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Display Name change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="userDisplayNameForm" action="<?php echo URL_ROOT . '/user/changeDisplayName' ?>" method="post">
                    <div class="form-group">
                        <label for="displayName">Display Name:</label>
                        <input type="text" name="displayName" id="displayName" class="form-control" placeholder="<?php
                        echo $_SESSION['logged']->getDisplayName(); ?>">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="displayNameSubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- The change Relationship status -->
<div class="modal" id="relationshipStatus">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Relationship status change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="userRelationshipForm" action="<?php echo URL_ROOT . '/user/changeRelationship' ?>" method="post">
                    <div class="form-group">
                        <label for="relationStatus">Relationship status:
                            <span class="currentState" id="currentStateRelationship">
                                <?php
                                    echo $_SESSION['logged']->getRelationshipTag();
                                ?>
                            </span>
                        </label>
                        <select name="relationStatus" id="relationStatus" class="form-control">
                            <option value="" selected>Select option</option>
                            <?php
                                foreach ($data['relationship'] as $status){
                                    echo "<option value=\"$status->id\">$status->status_name</option>\n\r";
                                }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="relationSubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- The change Gender -->
<div class="modal" id="genderChange">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Gender change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="userGenderForm" action="<?php echo URL_ROOT . '/user/changeGender' ?>" method="post">
                    <div class="form-group">
                        <label for="gender">Gender status:
                            <span class="currentState" id="currentStateGender">
                                <?php
                                echo $_SESSION['logged']->getGender();
                                ?>
                            </span>
                        </label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="" selected>Select option</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="genderSubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- The change Birthday -->
<div class="modal" id="birthdayChange">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Birthday change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="userBirthdayForm" action="<?php echo URL_ROOT . '/user/changeBirthday' ?>" method="post">
                    <div class="form-group">
                        <label for="birthday">Your BirthDay:
                            <span class="currentState" id="currentStateBirthday">
                                <?php
                                    echo $_SESSION['logged']->getBirthday();
                                ?>
                            </span>
                        </label>
                        <input type="date" name="birthday" id="birthday" class="form-control">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="birthdaySubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- The change Country -->
<div class="modal" id="CountryChange">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Country change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="userCountryForm" action="<?php echo URL_ROOT . '/user/changeCountry' ?>" method="post">
                    <div class="form-group">
                        <label for="country">Country:
                            <span class="currentState" id="currentStateCountry">
                                <?php
                                    echo $_SESSION['logged']->getCountryName();
                                ?>
                            </span>
                        </label>
                        <select name="country" id="country" class="form-control">
                            <option value="" selected>Select option</option>
                            <?php
                                foreach ($data['countries'] as $country){
                                    echo "<option value=\"$country->id\">$country->country_name</option>";
                                }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="countrySubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- The change Mobile number -->
<div class="modal" id="MobileChange">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Mobile number change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="userMobileNumberForm" action="<?php echo URL_ROOT . '/user/changeMobileNumber' ?>" method="post">
                    <div class="form-group">
                        <label for="mobileNumber">Mobile Number</label>
                        <input type="number" name="mobileNumber" id="mobileNumber" class="form-control" placeholder="<?php
                        echo $_SESSION['logged']->getMobileNumber(); ?>">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="mobileNumberSubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- The change website url -->
<div class="modal" id="websiteChange">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Website change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="userWebsiteForm" action="<?php echo URL_ROOT . '/user/changeWebsiteUrl' ?>" method="post">
                    <div class="form-group">
                        <label for="webAddres">Website address</label>
                        <input type="text" name="webAddres" id="webAddres" class="form-control" placeholder="<?php
                        echo $_SESSION['logged']->getWww();
                        ?>">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="websiteSubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- The change skype name -->
<div class="modal" id="skypeChange">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Skype name change form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="userSkypeForm" action="<?php echo URL_ROOT . '/user/changeSkypeName' ?>" method="post">
                    <div class="form-group">
                        <label for="skypeName">Skype username</label>
                        <input type="text" name="skypeName" id="skypeName" class="form-control" placeholder="<?php
                        echo $_SESSION['logged']->getSkype();
                        ?>">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="skypeSubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>