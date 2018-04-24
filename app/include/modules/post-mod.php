<div id="small_image">
    <a href="<?php echo URL_ROOT;?>/index/profile">
        <img class="img-rounded" src="<?php echo URL_ROOT . $_SESSION['logged']->getProfilePic();?>" alt="profile_pic">
    </a>
</div>
<!-- div to Open the Modal -->
<div id="post_input_fake" data-toggle="modal" data-target="#exampleModalCenter">
    <p id="post-panel" class="mb-0">What's on your mind, <?php echo $_SESSION['logged']->getFirstName() . ' ' . $_SESSION['logged']->getLastName();?>?</p>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="<?php echo URL_ROOT;?>/index/profile">
                    <img class="img-rounded" src="<?php echo URL_ROOT . $_SESSION['logged']->getProfilePic();?>" alt="profile_pic">
                </a>
                <h5  id="exampleModalLongTitle" class="mb-0">What's on your mind, eray myumyun?</h5>
            </div>
            <div class="modal-body">
                <form method="post" class="post_form" action="<?php echo URL_ROOT?>/post/addPost">
                    <textarea class="form-control" rows="5" id="comment" name="desc"></textarea>
                    <input type="submit" class="btn btn-primary mb-2" name="add_post" value="POST">
                    <input type="button" class="btn btn-danger" data-dismiss="modal" value="CANCEL">
                </form>
            </div>
        </div>
    </div>
</div>