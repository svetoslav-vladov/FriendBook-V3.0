<div id="profile-pic" class="text-center">
    <a href="<?php echo URL_ROOT; ?>/index/profile">
        <img id="mini-profile-pic" class="img-fluid rounded" src="<?php if(is_null($_SESSION["logged"]->getThumbsProfile()))
        { echo URL_ROOT . $_SESSION["logged"]->getProfilePic(); } else{ echo URL_ROOT .
            $_SESSION["logged"]->getThumbsProfile();} ?>"
             alt="profile_pic" title="<?php if(isset($_SESSION["logged"]))
             { echo URL_ROOT . $_SESSION["logged"]->getFullName();} ?>">
    </a>
    <div id="change_profile_pic">
        <i class="fas fa-edit"></i>
    </div>
    <div id="zoom_profile_pic">
        <a data-toggle="lightbox" data-gallery="my_profile_pic" href="<?php echo URL_ROOT . $_SESSION["logged"]->getProfilePic(); ?>">
            <i class="fas fa-search-plus"></i>
        </a>
    </div>
    <form id="upload_left_image" class="d-none" action="<?php echo URL_ROOT . "/user/changeProfilePic" ?>" method="post" enctype="multipart/form-data">
        <label for="profile_image_upload"></label>
        <input type="file" id="profile_image_upload" name="images[]" multiple accept="image/*">
    </form>
</div>

<div id="userNameTag" class="text-center mt-3 mb-3 font-weight-bold">
<?php

    if(isset($_SESSION['logged'])){

        if(!is_null($_SESSION['logged']->getDisplayName())){

            echo $_SESSION['logged']->getDisplayName();
            echo "<div class='small'>(" . $_SESSION['logged']->getFullName() .")</div>";
        }
        else{
            echo $_SESSION['logged']->getFullName();
        }
    }

?>
</div>
<div id="user-nav" class="text-success">
    <ul class="list-group">
        <li><a class="text-success list-group-item list-group-item-action" href="<?php echo URL_ROOT; ?>/index/main"><span class="nav-icon"><i class="fas fa-newspaper"></i></span>News Feed</a></li>
        <li><a class="text-success list-group-item list-group-item-action mt-2" href="<?php echo URL_ROOT; ?>/index/profile"><span class="nav-icon"><i class="fas fa-user nav-icon"></i></span>Profile page</a></li>
        <li><a class="text-success list-group-item list-group-item-action mt-2" href="#"><span class="nav-icon"><i class="fas fa-envelope nav-icon"></i></span>Messages</a></li>
        <li><a class="text-success list-group-item list-group-item-action mt-2" href="<?php echo URL_ROOT; ?>/index/settings"><span class="nav-icon"><i class="fas fa-cog nav-icon"></i></span>Settings</a></li>
        <li><a class="text-success list-group-item list-group-item-action mt-2" href="<?php echo URL_ROOT; ?>/index/friends" ><span class="nav-icon"><i class="fas fa-users nav-icon"></i></span>Friends</a></li>
    </ul>
</div>
