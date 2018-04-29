var root = window.location.origin + '/projects/FriendBook-v3.0';
var comment_gif = $("<img class='comments_gif' src="+ root +"/assets/images/ajax-loading-c4.gif>");
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
                    <span id=like-comment-container${comment['comment_id']}></span>
                    <a href=${root}/index/profile&id=${comment['owner_id']}>
                        <img class="user_pic align-self-start mr-3" src=${root+comment['profile_pic']} alt="icon">
                    </a>
                      <div class="media-body">
                        <h5 class="mt-0"><a href="${root}/index/profile&id=${comment['owner_id']}" class="comment_owner ${(comment['gender'] == 'male') ? 'male' : 'female'}">
                                    ${(comment['display_name'] == null) ? (comment['first_name'] + " " + comment['last_name']) : comment['display_name']}
                                </a>
                                <span class="comment_date">${comment['comment_date']}</span>
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
    request.open('POST', url_root + '/comment/likeComment');
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
    request.send("post_id=" + comment_id);
}

function unlikeComment(comment_id) {
    var request = new XMLHttpRequest();
    request.open('POST', url_root + '/comment/likeComment');
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
    request.send("post_id=" + comment_id);
}

function isLikedComment(comment_id) {
    var likeButton = $(`<button class="like-comment-button" id="like_comment${comment_id}"><i class="fas fa-thumbs-up"></i></button>`);
    var unlikeButton = $(`<button class="unlike-comment-button" id="unlike_comment${comment_id}"><i class="fa fa-thumbs-up"></i></button>`);
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            likeButton.click(function () {
                likeComment(comment_id);
                $('#comment_likes_counter'+comment_id).remove();
                $(this).remove();
            });
            unlikeButton.click(function () {
                unlikeComment(comment_id);
                $('#comment_likes_counter'+comment_id).remove();
                $(this).remove();
            });
            getCountCommentLikes(comment_id);
            if (this.responseText == 1) {
                $('#like-comment-container'+comment_id).append(unlikeButton);
            }
            else {
                $('#like-comment-container'+comment_id).append(likeButton);
            }
        }
    };
    req.open("GET", url_root + "/comment/likeComment&comment_id="+comment_id);
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