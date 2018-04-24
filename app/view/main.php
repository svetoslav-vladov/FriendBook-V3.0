<?php
$logged_user_id = $_SESSION['logged']['id'];
?>

<div id="left-col-grid">
    <div class="left-profile-info">
        left profile information
    </div>
</div>
<div id="content-grid">
    <div class="post-container">
        post module and news feed
        <?php require_once "../app/include/modules/post-mod.php"; ?>
    </div>
</div>

<div id="right-col-grid">
    <div class="suggested-users">
        suggested users
    </div>
</div>
<?php
//footer is end of html parts
?>



