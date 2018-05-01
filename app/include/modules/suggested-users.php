<?php
use Model\Dao\UserDao;
$dao = UserDao::getInstance();
?>

<div class="proposed-container">
    <h3>Suggested for you</h3>
    <div class="proposed-users">
        <?php
        $suggested_users = $dao->getSuggestedUsers($_SESSION['logged']->getId());
        foreach ($suggested_users as $user) { ?>
            <div class="media suggested-user-container">
                <a class="user_pic  <?php echo ($user['gender'] == 'male') ? 'male' : 'female' ?>" href="<?php echo URL_ROOT ?>/index/profile&id=<?=$user['id']?>">
                    <img class="mr-3 suggested-user-img" src="<?php if(is_null($user['thumbs_profile']))
                    { echo URL_ROOT . $user['profile_pic']; } else{ echo URL_ROOT .
                        $user['thumbs_profile'];} ?>">
                </a>
                <div class="media-body" id="friendNavigation<?php echo $user['id']?>">
                    <h5 class="mt-0">
                        <a class="<?php echo ($user['gender'] == 'male') ? 'male' : 'female' ?>" href="<?php echo URL_ROOT ?>/index/profile&id=<?=$user['id']?>">
                            <?php echo $user['first_name'] . " " . $user['last_name']?>
                        </a>
                    </h5>
                    <small><i>Registered on: <?php echo $user['reg_date']?></i></small>
                    <button onclick="sendFriendRequest(<?php echo $user['id']; ?>)" class="add-friend-button btn btn-primary btn-xs" id="sendFriendRequest<?php echo $user['id']?>"><i class="fas fa-user-plus"></i> add friend</button>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

