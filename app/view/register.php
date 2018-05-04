<div id="guest_wrap">
    <div class="container">
    <div class="row">
        <form class="form-horizontal form-register" method="POST" action="<?php echo URL_ROOT; ?>/user/register">
            <div class="row text-center">
                <div class="col-md-12 padding-top-register">
                    <a href="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                        <img class="mb-4 padding-top-register" src="<?php echo URL_ROOT; ?>./assets/images/friendbook-front-logo.png"
                             alt="friendbook front logo">
                    </a>
                </div>

            </div>

            <div class="row text-center">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h1 class="h3 mb-3 font-weight-normal">Please sign-up</h1>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
            <div class="row">

                <div class="col-md-3 field-label-responsive">
                    <label for="first_name">Name</label>
                    <label for="last_name" class="sr-only">Last Name</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                            <input type="text" id="first_name" name="first_name" class="form-control"
                                   placeholder="First Name" >
                            <input type="text" id="last_name" name="last_name" class="form-control"
                                   placeholder="Last Name">
                        </div>

                    </div>
                </div>
<!--                <div class="col-md-1">-->
<!--                    <div class="form-control-feedback">-->
<!--                    <span class="text-danger align-middle">-->
<!--                        <i class="fa fa-close">Example Error Message</i>-->
<!--                    </span>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="email">E-Mail Address</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                            <input type="text" name="email" class="form-control" id="email"
                                   placeholder="you@example.com" >
                        </div>
                    </div>
                </div>
<!--                <div class="col-md-1">-->
<!--                    <div class="form-control-feedback">-->
<!--                    <span class="text-danger align-middle">-->
<!--                        <i class="fa fa-close">Example Error Message</i>-->
<!--                    </span>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="password">Password</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-danger">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                            <input type="password" name="password" class="form-control" id="password"
                                   placeholder="Password">
                        </div>
                    </div>
                </div>
<!--                <div class="col-md-1">-->
<!--                    <div class="form-control-feedback">-->
<!--                    <span class="text-danger align-middle">-->
<!--                        <i class="fa fa-close">Example Error Message</i>-->
<!--                    </span>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="confirm_pass">Confirm Password</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem">
                                <i class="fa fa-unlock-alt"></i>
                            </div>
                            <input type="password" id="confirm_pass" name="confirm_pass"
                                   class="form-control" placeholder="Password again">
                        </div>
                    </div>
                </div>
<!--                <div class="col-md-1">-->
<!--                    <div class="form-control-feedback">-->
<!--                    <span class="text-danger align-middle">-->
<!--                        <i class="fa fa-close">Example Error Message</i>-->
<!--                    </span>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="gender">Gender</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem">
                                <i class="fa fa-genderless"></i>
                            </div>
                            <select name="gender" id="gender" class="form-control">
                                <option value="" selected>Select option</option>
                                <option value="male">Male</option>
                                <option value="male">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
<!--                <div class="col-md-1">-->
<!--                    <div class="form-control-feedback">-->
<!--                    <span class="text-danger align-middle">-->
<!--                        <i class="fa fa-close">Example Error Message</i>-->
<!--                    </span>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="birthday">Birthday</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem">
                                <i class="fa fa-birthday-cake"></i>
                            </div>
                            <input type="date" id="birthday" name="birthday"
                                   class="form-control">
                        </div>
                    </div>
                </div>
<!--                <div class="col-md-1">-->
<!--                    <div class="form-control-feedback">-->
<!--                    <span class="text-danger align-middle">-->
<!--                        <i class="fa fa-close">Example Error Message</i>-->
<!--                    </span>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-6">
                    <input type="submit" id="register" name="register"
                           class="btn btn-success" value="Register">
                    <a href="<?php echo URL_ROOT; ?>/index/login" class="btn text-success">back to login</a>
                </div>
                <div class="col-md-0">
                </div>
            </div>
            <p class="mt-5 mb-2 text-muted text-center">
                www.FriendBook.bg &copy; 2018 <br> All Rights Reserved <br> Version 3.0
            </p>
        </form>

        </div>
    </div>
</div>
