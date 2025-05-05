<?php
    use Model\Dao\UserDao;
    $userDao = UserDao::getInstance();
    $friendRequests = $userDao->getAllFriendRequests($_SESSION['logged']->getId());
?>

<nav class="navbar navbar-expand-md navbar-light fixed-top bg-success">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URL_ROOT; ?>"><img src="<?php echo URL_ROOT . '/assets/images/mini-logo.png' ?>" alt="FriendBook logo" class="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <div class="col-md-7">
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
            <div class="col-md-5">
                <ul class="navbar-nav my-lg-0">
                    <li class="nav-item profile_btn_top">
                        <a class="nav-link" href="<?php echo URL_ROOT; ?>/index/profile">
                            <img id="profilTopUserPic" class="img-fluid user_profile_pic" src="
                                    <?php if(is_null($_SESSION["logged"]->getThumbsProfile()))
                                    { echo URL_ROOT . $_SESSION["logged"]->getProfilePic(); } else{ echo URL_ROOT .
                                    $_SESSION["logged"]->getThumbsProfile();} ?>"
                                 alt="<?php echo $_SESSION['logged']->getFullName();?> profile picture">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL_ROOT; ?>/index/main">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="friendRequests"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="getFriendRequests(<?php echo $_SESSION['logged']->getId();?>)"><i class="fa fa-users"></i></a>
                        <div class="dropdown-menu requestContainer" aria-labelledby="friendRequests" id="requestContainer<?php echo $_SESSION['logged']->getId();?>">
                            <ul class="list-group list-group-flush" id="friend-requests<?php echo $_SESSION['logged']->getId();?>"></ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="messages"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="small label labe-pill label-danger count background-danger" id="msg_count">
                                <?php if(is_array($messages['msgs']) && count($messages['msgs']) !== 0) { echo count($messages['msgs']); }?>
                            </span><i class="fa fa-envelope"></i></a>
                        <ul class="dropdown-menu pm-messages" aria-labelledby="messages">
                            <?php
                            if(!isset($messages['errors']) && is_array($messages['msgs'])) {
                                foreach ($messages['msgs'] as $message) {
                                    $gender = $message->gender . "_default_picture";
                                    $pmProfilePic = is_null($message->thumbs_profile) ? $GLOBALS[$gender] : $message->thumbs_profile;
                                ?>
                                 <li>
                                     <div class="pm-userPic">
                                         <img src="<?php echo URL_ROOT . $pmProfilePic; ?>" alt="<?= $message->first_name . ' ' .$message->last_name ?> profile picture">
                                     </div>
                                     <div class="pm-params">
                                        <a class="pm-user"href="<?php echo URL_ROOT . '/index/profile&id=' . $message->sender_id ?>">
                                            <?= $message->first_name . ' ' .$message->last_name ?>
                                        </a>
                                        <p class="pm-msg"><?php echo $message->message_text; ?></p>
                                     </div>
                                 </li>
                            <?php }
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="http://example.com" id="notifications"
                           onclick="getAllNotifications(<?php echo $_SESSION['logged']->getId();?>)"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i></a>
                        <div class="dropdown-menu requestContainer" aria-labelledby="notifications" id="notificationContainer<?php echo $_SESSION['logged']->getId();?>">
                            <ul class="list-group list-group-flush" id="notifications-list<?php echo $_SESSION['logged']->getId();?>"></ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="<?php echo URL_ROOT . '/index/settings'; ?>"><i class="fa fa-cog"></i> Settings</a>
                            <a class="dropdown-item" href="<?php echo URL_ROOT . '/user/logout'; ?>"><i class="fa fa-sign-out-alt"></i> logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>