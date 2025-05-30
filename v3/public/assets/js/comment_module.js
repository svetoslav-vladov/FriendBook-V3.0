var root = window.location.origin;
var comment_gif = $("<img class='comments_gif' src="+ root +"/assets/images/ajax-loading-c4.gif>");

function addComment(post_id) {
    addNotificationOnComment(post_id);
    var commentDesc = $('.comment-textarea' + post_id);
    var request = new XMLHttpRequest();
//   validation for text area is empty or contains white spaces
    if (!$.trim($(".comment-textarea" + post_id).val())) {
        alert("You can't create empty comment, Please fill the post!");
    }
    else if (commentDesc.val().length > 1500) {
        alert("Your comment contains too many characters! Please enter no more than 1500 characters.");
    }
    else {
        $("#comments" + post_id).empty();
        request.open('post', url_root + '/comment/addComment');
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                getComments(post_id);
            }
        };
        request.send("comment_description=" + commentDesc.val() + "&post_id=" + post_id);
        commentDesc.val('');
    }
}

function getComments(post_id) {
    var comments = $('#comments'+post_id);
    comments.empty();
    comments.append(comment_gif);
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#comment-counter'+post_id).remove();
            var result = JSON.parse(this.responseText);
            setTimeout(function(){
                for(var comment of result) {
                    var commentDiv = $(`
                    <div class="media comment comment-${post_id}">
                      <div class="media-body">
                        <h5 class="commentParamsFlex">
                                <div class="commentSection">
                                    <a href=${root}/index/profile&id=${comment['owner_id']}>
                                        <img class="user_pic align-self-start mr-3" src=${(comment['thumbs_profile'] == null) ? root+comment['profile_pic'] : root+comment['thumbs_profile']} alt="icon">
                                    </a>
                                    <a href="${root}/index/profile&id=${comment['owner_id']}" class="comment_owner ${(comment['gender'] == 'male') ? 'male' : 'female'}">
                                        ${(comment['display_name'] == null) ? (comment['first_name'] + " " + comment['last_name']) : comment['display_name']}
                                    </a>
                                </div>
                                <div class="commentSection">
                                    <span class="comment_date">${comment['comment_date']}</span>
                                    <span class="like-comment-container" id=like-comment-container${comment['comment_id']}></span>
                                </div>
                        </h5>
                        <span><p class="comment-desc">${comment['description']}</p></span>
                      </div>
                    </div>
                    `);
                    comments.append(commentDiv);
                    isLikedComment(comment['comment_id']);
                }
                var commentCounter = $(`<span class="comment-counter" id="comment-counter${post_id}">${$("#comments"+post_id+" .comment").length}</span>`);
                if($("#comments"+post_id+" .comment").length == 0) {
                    $('#comment_btn'+post_id).attr('disabled', true);
                    $('#comment_btn'+post_id).append(commentCounter);
                }else {
                    $('#comment_btn'+post_id).append(commentCounter);
                    $('#comment_btn'+post_id).attr('disabled', false);
                }
                comment_gif.remove();
            },230);
        }
    };
    request.open("GET", url_root + "/comment/addComment&post_id="+post_id);
    request.send();
}

function displayComments(post_id) {
    var comment_box = document.querySelector('#comment_box'+post_id);
    comment_box.style.height = "350px";
    $('#comment_btn_close'+post_id).show();
    $('#comment_btn'+post_id).hide();
}

function hideComments(post_id) {
    var comment_box = document.querySelector('#comment_box'+post_id);
    comment_box.style.height = "0";
    $('#comment_btn'+post_id).show();
    $('#comment_btn_close'+post_id).hide();
}

function likeComment(comment_id) {
    var request = new XMLHttpRequest();
    request.open('POST', root + '/comment/likeComment');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#like-comment-container'+comment_id).append(comment_gif);
            setTimeout(function(){
                comment_gif.remove();
                isLikedComment(comment_id);
            },250);
        }
    };
    request.send("comment_id=" + comment_id);
}

function unlikeComment(comment_id) {
    var request = new XMLHttpRequest();
    request.open('POST', root + '/comment/unlikeComment');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#like-comment-container'+comment_id).append(comment_gif);
            setTimeout(function(){
                comment_gif.remove();
                isLikedComment(comment_id);
            },250);
        }
    };
    request.send("comment_id=" + comment_id);
}

function isLikedComment(comment_id) {
    var likeCommentButton = $(`<button class="like-comment-button" id="like_comment${comment_id}"><i class="fas fa-thumbs-up"></i></button>`);
    var unlikeCommentButton = $(`<button class="unlike-comment-button" id="unlike_comment${comment_id}"><i class="fa fa-thumbs-up"></i></button>`);
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            likeCommentButton.click(function () {
                likeComment(comment_id);
                $('#comment_likes_counter'+comment_id).remove();
                $(this).remove();
            });
            unlikeCommentButton.click(function () {
                unlikeComment(comment_id);
                $('#comment_likes_counter'+comment_id).remove();
                $(this).remove();
            });
            getCountCommentLikes(comment_id);
            if (this.responseText == 1) {
                $('#like-comment-container'+comment_id).append(unlikeCommentButton);
            }
            else {
                $('#like-comment-container'+comment_id).append(likeCommentButton);
            }
        }
    };
    req.open("GET", root + "/comment/likeComment&comment_id="+comment_id);
    req.send();
}

function getCountCommentLikes(comment_id) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var likeCounter = $(`<span class="likes_counter" id="comment_likes_counter${comment_id}">${this.responseText}</span>`);
            $('#like_comment'+comment_id).append(likeCounter);
            $('#unlike_comment'+comment_id).append(likeCounter);
        }
    };
    req.open("GET", url_root + "/comment/likeCounter&comment_id="+comment_id);
    req.send();
}