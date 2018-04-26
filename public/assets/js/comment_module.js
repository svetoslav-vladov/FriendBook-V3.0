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
            },200);
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

