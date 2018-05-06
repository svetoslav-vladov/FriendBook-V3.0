<div id="newsfeed">
<!--    <script>-->
<!--        $(document).ready(function () {-->
<!--            getAllPosts();-->
<!--        });-->
<!--    </script>-->
    <?php
    foreach ($data['newsFeed'] as $post) { ?>
        <div class="card p-3 mt-3 mb-3" id="<?php echo "post".$post['post_id']?>">
            <div class="user_info">
                <div class="icon"><a href="<?php echo URL_ROOT; ?>/index/profile&id=<?php echo $post['user_id'] ?>">
                        <img src="<?php if(is_null($post['thumbs_profile']))
                                { echo URL_ROOT . $post['profile_pic']; } else{ echo URL_ROOT .
                                    $post['thumbs_profile'];} ?>"
                                title="<?php echo $post["first_name"] . " " . $post["last_name"]; ?>"
                                class="img-fluid"></a></div>
                <div class="name"><a href="<?php echo URL_ROOT; ?>/index/profile&id=<?php echo $post['user_id'] ?>"
                                     class="<?php echo ($post['gender'] == 'female') ? "female" : "male" ?>"><?php echo $post["first_name"] . " " . $post["last_name"]; ?></a>
                </div>
                <div class="date"><?php echo $post['create_date']; ?></div>
                <?php  if($post['user_id'] == $_SESSION['logged']->getId()) { ?>
                    <button data-toggle="modal" data-target=".bd-example-modal-sm" id="<?php echo $post['post_id']?>" type="button" class="close delete-post-button" aria-label="Close">
                        <span aria-hidden="true">&#10008;delete</span>
                    </button>
                    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to delete the post?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="deletePost(<?php echo $post['post_id']?>)">Yes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="description">
                <p><?php echo $post["description"]; ?></p>
            </div>
            <div id="post-details<?php echo $post['post_id']?>">
                <div class="post_navigation">
                    <div class="like-container" id="like-container<?php echo $post['post_id'] ?>">
                        <script>
                            $(document).ready(function () {
                                isLiked(<?php echo $post['post_id']?>);
                            });
                        </script>
                    </div>
                    <div class="like-container" id="dislike-container<?php echo $post['post_id'] ?>">
                        <script>
                            $(document).ready(function () {
                                isDisliked(<?php echo $post['post_id'] ?>);
                            });
                        </script>
                    </div>
                    <div class="comments-buttons" id=comments-buttons<?php echo $post['post_id']; ?>">
                        <button name="button" id="comment_btn<?php echo $post['post_id'] ?>"
                                onclick="displayComments(<?php echo $post['post_id'] ?>)" type="button" class="btn btn-success">COMMENTS
                        </button>
                        <button name="button" id="comment_btn_close<?php echo $post['post_id'] ?>"
                                onclick="hideComments(<?php echo $post['post_id'] ?>)" type="button" class="btn btn-success comment_btn_close">CLOSE
                        </button>
                    </div>
                    <div class="comments_box" id="comment_box<?php echo $post['post_id'] ?>">
                        <script>
                            $(document).ready(function () {
                                /*this function load all comments in current post with AJAX request*/
                                getComments(<?php echo $post['post_id'] ?>);
                            });
                        </script>
                        <div class="comments" id="comments<?php echo $post['post_id'] ?>"></div>
                    </div>
                    <div class="input-group mb-3 add_comment_container">
                <span class="user_pic_add_comment">
                    <img src="<?php if(is_null($_SESSION["logged"]->getThumbsProfile()))
                    { echo URL_ROOT . $_SESSION["logged"]->getProfilePic(); } else{ echo URL_ROOT .
                        $_SESSION["logged"]->getThumbsProfile();} ?>"
                         alt="<?php echo $_SESSION['logged']->getFullName();?> profile picture"
                         class="img-rounded center-block">
                </span>
                        <input type="text" class="form-control comment-textarea<?= $post['post_id'] ?>" name="comment_description" placeholder="Write comment..." aria-label="Write comment" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button onclick="addComment(<?php echo $post['post_id']?>)" id="add<?php echo $post['post_id'] ?>" type="button" class="add-comment-btn btn btn-sm btn-outline-success">add</button>
                            <input type="hidden" name="post_id" value="<?php echo $post['post_id'] ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>