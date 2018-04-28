<div id="profile-pic" class="text-center">
    <a href="<?php echo URL_ROOT; ?>/index/profile">
        <img id="mini-profile-pic" class="img-fluid rounded" src="<?php if(isset($_SESSION["logged"])){ echo URL_ROOT . $_SESSION["logged"]->getProfilePic();} ?>"
             alt="profile_pic" title="<?php if(isset($_SESSION["logged"])){ echo URL_ROOT . $_SESSION["logged"]->getFullName();} ?>">
    </a>
    <div class="" id="change_profile_pic">
        <i class="fas fa-edit"></i>
    </div>
    <form id="upload_left_image" class="d-none" action="<?php echo URL_ROOT . "/user/changeProfilePic" ?>" method="post" enctype="multipart/form-data">
        <label for="profile_image_upload"></label>
        <input type="file" id="profile_image_upload" name="images[]" multiple accept="image/*">
        <button type="submit"></button>
    </form>
</div>

<div id="userNameTag" class="text-center mt-3 mb-3 font-weight-bold">
<?php

    if(isset($_SESSION['logged'])){

        if(isset($_SESSION['logged']->getDisplayName) && strlen(trim($_SESSION['logged']->getDisplayName()," ")) > 0){

            echo $_SESSION['logged']->getDisplayName();
            echo "<div class='small_fullname'>(" . $_SESSION['logged']->getFullName() .")</div>";
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
        <li><a class="text-success list-group-item list-group-item-action mt-2" href="<?php echo URL_ROOT; ?>/index/messages"><span class="nav-icon"><i class="fas fa-envelope nav-icon"></i></span>Messages</a></li>
        <li><a class="text-success list-group-item list-group-item-action mt-2" href="<?php echo URL_ROOT; ?>/index/settings"><span class="nav-icon"><i class="fas fa-cog nav-icon"></i></span>Settings</a></li>
        <li><a class="text-success list-group-item list-group-item-action mt-2" href="<?php echo URL_ROOT; ?>/index/friends"><span class="nav-icon"><i class="fas fa-users nav-icon"></i></span>Friends</a></li>
        <li><a class="text-success list-group-item list-group-item-action mt-2" href="<?php echo URL_ROOT; ?>/index/followed"><span class="nav-icon"><i class="fas fa-eye nav-icon"></i></span>Followed</a></li>
    </ul>
</div>
