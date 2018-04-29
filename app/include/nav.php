<nav class="navbar navbar-expand-md navbar-light fixed-top bg-success">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URL_ROOT; ?>"><img src="<?php echo URL_ROOT . '/assets/images/mini-logo.png' ?>" alt="FriendBook logo" class="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <div class="col-lg-6">
                <div class="input-group">
                    <form class="form-inline mr-auto">
                        <input type="text" class="search_input form-control" placeholder="Search for..." onkeyup="searchUser(this.value)">
                        <span class="input-group-btn">
                            <button type="button" class="search_button btn btn-light"><i class="fa fa-search"></i> search</button>
                        </span>
                    </form>
                </div>
                <div class="users-result"><ul class="list-group list-group-flush users-list"></div>
            </div>
            <ul class="navbar-nav my-2 my-lg-0">
                <li class="nav-item profile_btn_top">
                    <a class="nav-link" href="<?php echo URL_ROOT; ?>/index/profile">
                        <img class="img-fluid user_profile_pic" src="
                                <?php if(is_null($_SESSION["logged"]->getThumbsProfile()))
                                { echo URL_ROOT . $_SESSION["logged"]->getProfilePic(); } else{ echo URL_ROOT .
                                $_SESSION["logged"]->getThumbsProfile();} ?>"
                             alt="<?php echo $_SESSION['logged']->getFullName();?> profile picture">
                    </a>
                </li>
                <li class="nav-item active profile_btn_top">
                    <a class="nav-link" href="<?php echo URL_ROOT; ?>/index/profile">
                        <?php echo $_SESSION['logged']->getFirstName(); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URL_ROOT; ?>/index/main">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="friendRequests"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i></a>
                    <div class="dropdown-menu" aria-labelledby="friendRequests">
                        No friend requests :(
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="messages"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-envelope"></i></a>
                    <div class="dropdown-menu" aria-labelledby="messages">
                        No messages ;(
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="notifications"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i></a>
                    <div class="dropdown-menu" aria-labelledby="notifications">
                        No notifications :)
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#"><i class="fa fa-cog"></i> Settings</a>
                        <a class="dropdown-item" href="<?php echo URL_ROOT; ?>/user/logout"><i class="fa fa-sign-out-alt"></i> logout</a>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</nav>