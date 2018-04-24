<div id="newsfeed">
    <?php
    use model\Dao\PostDao;
    $dao = PostDao::getInstance();
    $allPosts = $dao->getAllPosts();
    foreach ($allPosts as $post) {?>
        <div class="card p-3 mt-3 mb-3">
            <div class="user_info">
                <div class="icon"><a href="<?php echo URL_ROOT; ?>/index/profile?id=<?php echo $post['user_id']?>"><img src="<?php echo $post['profile_pic']; ?>" alt="icon" title="<?php echo $post["first_name"] . " " . $post["last_name"]; ?>" class="img-rounded center-block"></a></div>
                <div class="name"><a href="<?php echo URL_ROOT; ?>/index/profile?id=<?php echo $post['user_id']?>" class="<?php echo ($post['gender'] == 'female') ? "female" : "male"?>"><?php echo $post["first_name"] . " " . $post["last_name"]; ?></a></div>
                <div class="date"><?php echo $post['create_date']; ?></div>
            </div>
            <div class="description">
                <p><?php echo $post["description"]; ?></p>
            </div>
        </div>
        <?php }?>
</div>