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
                                id="description">
                                    <span class="nav-icon"><i class="fas fa-pencil-alt"></i></span>Description
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
                    <h1 class="mb-4">General information:</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">First Name:</span>
                            <span class="labelValue" id="lableValueFirstName">
                                <?php echo $_SESSION['logged']->getFirstName(); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#firstNameChange">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Last Name:</span>
                            <span class="labelValue" id="lableValueLastName">
                                <?php echo $_SESSION['logged']->getLastName(); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#lastNameChange">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Display Name:</span>
                            <span class="labelValue" id="lableValueDisplayName">
                                <?php echo $_SESSION['logged']->getDisplayName(); ?>
                            </span>
                            <div class="small">( This will show instead of Full name, as your tag for others! )</div>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#displayNameChange">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Relationship status:</span>
                            <span class="labelValue" id="lableValueRelationship">
                                <?php echo $_SESSION['logged']->getRelationshipTag(); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#relationshipStatus">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Gender:</span>
                            <span class="labelValue" id="lableValueGender">
                                <?php echo $_SESSION['logged']->getGender(); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#genderChange">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Birthday status:</span>
                            <span class="labelValue" id="lableValueBirthday">
                                <?php echo $_SESSION['logged']->getBirthday(); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#birthdayChange">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Country:</span>
                            <span class="labelValue" id="lableValueCountry">
                                <?php echo $_SESSION['logged']->getCountryName(); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#CountryChange">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Mobile Number:</span>
                            <span class="labelValue" id="lableValueMobileNumber">
                                <?php echo $_SESSION['logged']->getMobileNumber(); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#MobileChange">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Your Website:</span>
                            <span class="labelValue" id="lableValueWebsite">
                                <?php echo $_SESSION['logged']->getWww(); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#websiteChange">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Skype name:</span>
                            <span class="labelValue" id="lableValueSkype">
                                <?php echo $_SESSION['logged']->getSkype(); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#skypeChange">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="card p-3" id="security_box">
                    <h1 class="mb-4">Security information:</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Email:</span>
                            <span class="labelValue">
                                <?php echo $_SESSION['logged']->getEmail(); ?>
                            </span>
                            <div class="small">( This will change your login )</div>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#emailChange">
                                Change
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="labelName">Your Password</span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#passwordChange">
                                Change
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card p-3" id="desc_box">
                    <form id="desc_form" action="<?php echo URL_ROOT . '/user/saveDescriptionSettings'; ?>" method="post">
                        <fieldset>
                            <legend>Description information:</legend>

                            <div class="form-group">
                                <label for="descText">Describe yourself:</label>
                                <br>
                                <textarea name="descText" id="descText" cols="30" rows="10" class="form-control"><?php
                                    if(!is_null($_SESSION['logged']->getDescription()))
                                    { echo $_SESSION['logged']->getDescription();} ?></textarea>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="description_submit" id="description_submit"
                                       class="btn btn-green btn-lg" value="SAVE">
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

<?php
    require_once '../app/view/modalGeneralSettings.php';
    require_once '../app/view/modalSecuritySettigns.php';

?>