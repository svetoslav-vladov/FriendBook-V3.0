<div id="newsfeed">
    <?php

    use model\Dao\PostDao;

    $dao = PostDao::getInstance();
    $allPosts = $dao->getAllPosts();

    foreach ($allPosts as $post) { ?>
        <div class="card p-3 mt-3 mb-3">
            <div class="user_info">
                <div class="icon"><a href="<?php echo URL_ROOT; ?>/index/profile?id=<?php echo $post['user_id'] ?>"><img
                                src="<?php echo URL_ROOT . $post['profile_pic']; ?>" alt="icon"
                                title="<?php echo $post["first_name"] . " " . $post["last_name"]; ?>"
                                class="img-rounded center-block"></a></div>
                <div class="name"><a href="<?php echo URL_ROOT; ?>/index/profile?id=<?php echo $post['user_id'] ?>"
                                     class="<?php echo ($post['gender'] == 'female') ? "female" : "male" ?>"><?php echo $post["first_name"] . " " . $post["last_name"]; ?></a>
                </div>
                <div class="date"><?php echo $post['create_date']; ?></div>
            </div>
            <div class="description">
                <p><?php echo $post["description"]; ?></p>
            </div>
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
            </div>
            <div class="comments_box" id="comment_box<?php echo $post['post_id'] ?>">
                <script>
                    $(document).ready(function () {
                        /*this function load all comments in current post with AJAX request*/
                        getComments(<?php echo $post['post_id'] ?>);
                    });
                </script>
                <div class="comments" id="comments<?php echo $post['post_id'] ?>">
                    <script>
                        $(document).ready(function () {
                            var url_root = window.location.origin + '/projects/FriendBook-v3.0/';
                            var postId = "<?php echo $post['post_id'] ?>";
                            var addButton = $('#add' + postId);
                            var commentDesc = $('.comment-textarea' + postId);
                            var request = new XMLHttpRequest();
                            addButton.click(function () {
//                            validation for text area is empty or contains white spaces
                                if (!$.trim($(".comment-textarea" + postId).val())) {
                                    alert("You can't create empty comment, Please fill the post!");
                                }
                                else if (commentDesc.val().length > 1500) {
                                    alert("Your comment contains too many characters! Please enter no more than 1500 characters.");
                                }
                                else {
                                    $("#comments" + postId).empty();
                                    request.open('post', url_root + '/comment/addComment');
                                    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                    request.onreadystatechange = function () {
                                        if (this.readyState === 4 && this.status === 200) {
                                            getComments(postId);
                                        }
                                    };
                                    request.send("comment_description=" + commentDesc.val() + "&post_id=" + postId);
                                    commentDesc.val('');
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="add-comment-div">




            </div>

            <div class="input-group mb-3 add_comment_container">
                <span class="user_pic_add_comment">
                    <img src="<?php echo URL_ROOT . $_SESSION['logged']->getProfilePic(); ?>" alt="icon"
                         class="img-rounded center-block">
                </span>
                <input type="text" class="form-control comment-textarea<?= $post['post_id'] ?>" name="comment_description" placeholder="Write comment..." aria-label="Write comment" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button id="add<?php echo $post['post_id'] ?>" type="button" class="btn btn-sm btn-outline-success">add</button>
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id'] ?>">
                </div>
            </div>
        </div>
    <?php } ?>
</div>