<div id="opacity_black_background">
<form id="post-form" class="shadow-box" action="<?php echo URL_ROOT?>/post/addPost" method="post">
    <label for="post_module">Make post</label>
    <div id="add_post_wrap">
        <div id="small_image">
            <a href="<?php echo URL_ROOT?>/index/profile">
                <img src="<?php if(isset($_SESSION["logged"])){ echo URL_ROOT . $_SESSION["logged"]->getProfilePic();}?>" alt="profile_pic">
            </a>
        </div>
        <div id="post_input_fake">
            <p id="post-panel">What's on your mind, <?php if(isset($_SESSION["logged"])){ echo $_SESSION["logged"]->getFirstName() . " " . $_SESSION["logged"]->getLastName() ;} ?>?</p>
        </div>
        <div id="post_add_popup">
            <textarea id="post_module" class="shadow-box" cols="62" rows="10" name="desc"></textarea>
            <input class="mini-btn shadow-box" type="submit" value="post" name="add_post">
            <button class="mini-btn shadow-box" id="cancel_post">CANCEL</button>
        </div>
    </div>
</div>
    <div class="clear"></div>
</form>