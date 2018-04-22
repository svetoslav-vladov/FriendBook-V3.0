var loading_gif = $('<img class="loading-gif" src="../assets/images/ajax-loading-c4.gif">');
function likePost(post_id) {
    var request = new XMLHttpRequest();
    request.open('post', '../controller/like_post_controller.php');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        $('#dislike-container'+post_id).empty();
        if (this.readyState === 4 && this.status === 200) {
            setTimeout(function(){
                isLiked(post_id);
                isDisliked(post_id);
                loading_gif.remove();
            },200);
        }
    };
    request.send("post_id=" + post_id);
}
function unlikePost(post_id) {
    var request = new XMLHttpRequest();
    request.open('post', '../controller/unlike_post_controller.php');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        $('#dislike-container'+post_id).empty();
        $('#like-container'+post_id).append(loading_gif);
        if (this.readyState === 4 && this.status === 200) {
            setTimeout(function(){
                isLiked(post_id);
                isDisliked(post_id);
                loading_gif.remove();
            },200);
        }
    };
    request.send("post_id=" + post_id);
}
function isLiked(post_id) {
    var likeButton = $(`<button class="like-button" id="like${post_id}"><i class="fas fa-thumbs-up"></i></button>`);
    var unlikeButton = $(`<button class="unlike-button" id="unlike${post_id}"><i class="fa fa-thumbs-up"></i></button>`);
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            likeButton.click(function () {
                likePost(post_id);
                $('#like-container'+post_id).append(loading_gif);
                $('#like_counter'+post_id).remove();
                $('#dislike-container'+post_id).empty();
                $(this).remove();
            });
            unlikeButton.click(function () {
                unlikePost(post_id);
                $('#like-container'+post_id).append(loading_gif);
                $('#like_counter'+post_id).remove();
                $('#dislike-container'+post_id).empty();
                $(this).remove();
            });
            getCountLikes(post_id);
            if (this.responseText == 1) {
                $('#like-container'+post_id).append(unlikeButton);
            }
            else {
                $('#like-container'+post_id).append(likeButton);
            }
        }
    };
    req.open("GET", "../controller/like_post_controller.php?post_id="+post_id);
    req.send();
}
function getCountLikes(post_id) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var likeCounter = $(`<span class="likes_counter" id="like_counter${post_id}">${this.responseText}</span>`);
            $('#like'+post_id).append(likeCounter);
            $('#unlike'+post_id).append(likeCounter);
        }
    };
    req.open("GET", "../controller/likeCounter_controller.php?post_id="+post_id);
    req.send();
}

function dislikePost(post_id) {
    var request = new XMLHttpRequest();
    request.open('post', '../controller/dislike_post_controller.php');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        $('#like-container'+post_id).empty();
        if (this.readyState === 4 && this.status === 200) {
            setTimeout(function(){
                isDisliked(post_id);
                isLiked(post_id);
                loading_gif.remove();
            },200);
        }
    };
    request.send("post_id=" + post_id);
}
function undislikePost(post_id) {
    var request = new XMLHttpRequest();
    request.open('post', '../controller/undislike_post_controller.php');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        $('#like-container'+post_id).empty();
        if (this.readyState === 4 && this.status === 200) {
            setTimeout(function(){
                isDisliked(post_id);
                isLiked(post_id);
                loading_gif.remove();
            },200);
        }
    };
    request.send("post_id=" + post_id);
}


function isDisliked(post_id) {
    var dislikeButton = $(`<button class="dislike-button" id="dislike${post_id}"><i class="fa fa-thumbs-down"></i></button>`);
    var undislikeButton = $(`<button class="undislike-button" id="undislike${post_id}"><i class="fa fa-thumbs-down"></i></button>`);
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            dislikeButton.click(function () {
                dislikePost(post_id);
                $('#dislike-container'+post_id).append(loading_gif);
                $('#dislike_counter'+post_id).remove();
                $('#like-container'+post_id).empty();
                $(this).remove();
            });
            undislikeButton.click(function () {
                undislikePost(post_id);
                $('#dislike-container'+post_id).append(loading_gif);
                $('#dislike_counter'+post_id).remove();
                $('#like-container'+post_id).empty();
                $(this).remove();
            });
            getCountDislikes(post_id);
            console.log(this.responseText);
            if (this.responseText == 1) {
                $('#dislike-container'+post_id).append(undislikeButton);
            }
            else {
                $('#dislike-container'+post_id).append(dislikeButton);
            }
        }
    };
    req.open("GET", "../controller/dislike_post_controller.php?post_id="+post_id);
    req.send();
}

function getCountDislikes(post_id) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var dislikeCounter = $(`<span class="likes_counter" id="dislike_counter${post_id}">${this.responseText}</span>`);
            $('#dislike'+post_id).append(dislikeCounter);
            $('#undislike'+post_id).append(dislikeCounter);
        }
    };
    req.open("GET", "../controller/dislikeCounter_controller.php?post_id="+post_id);
    req.send();
}