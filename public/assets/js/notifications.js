var userNotifications = $(`<span class="friendNotifications"></span>`);

function addNotificationOnLike(post_id) {
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/addNotificationOnLike');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(JSON.parse(this.responseText));
        }
    };
    request.send("post_id="+post_id);
}

function addNotificationOnDislike(post_id) {
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/addNotificationOnDislike');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(JSON.parse(this.responseText));
        }
    };
    request.send("post_id="+post_id);
}

function addNotificationOnComment(post_id) {
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/addNotificationOnComment');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(JSON.parse(this.responseText));
        }
    };
    request.send("post_id="+post_id);
}

function getAllNotifications(user_id) {
    var notificationsList = $('#notifications-list'+user_id);
    notificationsList.empty();
    notificationsList.hide();
    loading_gif.show();
    $('#notificationContainer'+user_id).append(loading_gif);
    var notNotification = $(`<li class="list-group-item">there are not notifications</li>`);
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            var notifications = JSON.parse(this.responseText);
            if (notifications.length === 0) {
                notificationsList.append(notNotification);
                notificationsList.show();
                loading_gif.hide();
                return;
            }
            for(var notification of notifications) {
                var notificationLi = $(`<li class="list-group-item" id="notificationFrom${notification['id']}">
                                    <a class="request-user  ${(notification['gender'] == 'male') ? 'male' : 'female'}" href="${url_root}/index/profile&id=${notification['user_id']}"> 
                                        <img class="mr-3" src=${(notification['thumbs_profile'] == null) ? root+notification['profile_pic'] : root+notification['thumbs_profile']}>
                                    </a>
                                    <div class="media-body requestNavigation" id="notification-navigation${notification['id']}">
                                        <h5 class="mt-0">
                                            <a class="request-friend-name ${(notification['gender'] == 'male') ? 'male' : 'female'}" href="${url_root}/index/profile&id=${notification['user_id']}">
                                                ${(notification['display_name'] == null) ? (notification.notification_firstName + " " + notification.notification_lastName) : notification.display_name}
                                            </a>
                                            <div class="notification-description">
                                                <a id="notification${notification['notification_id']}" 
                                                href="${url_root}/index/post&post_id=${notification['post_id']}"
                                                onclick="viewNotification(${notification['notification_id']})">
                                                    ${notification['notification_description']} 
                                                    your post on ${notification['notification_date']}
                                                </a>
                                            </div>
                                        </h5>
                                    </div>
                                </li>`);
                notificationsList.append(notificationLi);
                notNotification.bind('click', function (e) { e.stopPropagation(); });
                $(`#notificationFrom${notification['id']}`).bind('click', function (e) { e.stopPropagation(); });
            }
            setTimeout(function () {
                loading_gif.hide();
                notificationsList.show();
            }, 500);
        }
    };
    req.open("GET", url_root + "/user/getAllNotifications&user_id="+user_id);
    req.send();
}


function checkForNotifications() {
    userNotifications.empty();
    userNotifications.hide();
    var request = new XMLHttpRequest();
    request.open('GET', url_root+'/user/checkForNotifications');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.responseText == 0) {
            return;
        }
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText != 0) {
                userNotifications.show();
                userNotifications.html(this.responseText);
                $('#notifications').append(userNotifications);
            }
        }
    };
    request.send();
}

function viewNotification(notification_id) {
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/viewNotification');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
        }
    };
    request.send("notification_id="+notification_id);
}

function getSinglePost(post_id) {
    $('#single-post').empty();
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var single_post = JSON.parse(this.responseText);
            for(var post of single_post) {
                var postContainer = $(`
                <div class="post_card card p-3 mt-3 mb-3" id="post${post['post_id']}">
                    <div class='user_info'> 
                       <div class="icon">
                            <a href="${root}/index/profile&id=${post['user_id']}">
                                <img src=${(post['thumbs_profile'] == null) ? root+post['profile_pic'] : root+post['thumbs_profile']}
                                        class="img-fluid">
                             </a>
                         </div>
                         <div class="name"><a href=${root}/index/profile&id=${post['user_id']}
                                         class="${(post['gender'] == 'male') ? 'male' : 'female'}">
                                         ${(post['display_name'] == null) ? (post['first_name'] + " " + post['last_name']) : post['display_name']} 
                                         </a>
                        </div>
                        <div class="date">${post['create_date']}</div>        
                       </div>
                    <div class="description">
                        <p>${post['description']}</p>
                    </div>
                    <div id="post-details${post['post_id']}">
                        <div class="post_navigation">
                            <div class="like-container" id="like-container${post['post_id']}">
                                <script>
                                    $(document).ready(function () {
                                        isLiked(${post['post_id']});
                                    });
                                </script>
                            </div>
                             <div class="like-container" id="dislike-container${post['post_id']}">
                                <script>
                                    $(document).ready(function () {
                                        isDisliked(${post['post_id']});
                                    });
                                </script>
                            </div>
                            <div class="comments-buttons" id=comments-buttons${post['post_id']}">
                                <button name="button" id="comment_btn${post['post_id']}"
                                        onclick="displayComments(${post['post_id']})" type="button" class="btn btn-success">COMMENTS
                                </button>
                                <button name="button" id="comment_btn_close${post['post_id']}"
                                        onclick="hideComments(${post['post_id']})" type="button" class="btn btn-success comment_btn_close">CLOSE
                                </button>
                            </div>
                            <div class="comments_box" id="comment_box${post['post_id']}">
                                <script>
                                    $(document).ready(function () {
                                        /*this function load all comments in current post with AJAX request*/
                                        getComments(${post['post_id']});
                                    });
                                </script>
                                <div class="comments" id="comments${post['post_id']}"></div>
                            </div>
                            <div class="input-group mb-3 add_comment_container">
                                <input type="text" class="form-control comment-textarea${post['post_id']}" name="comment_description" placeholder="Write comment..." aria-label="Write comment" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button onclick="addComment(${post['post_id']})" id="add${post['post_id']}" type="button" class="add-comment-btn btn btn-sm btn-outline-success">add</button>
                                    <input type="hidden" name="post_id" value="${post['post_id']}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
                break;
            }
            $('#single-post').append(postContainer);
        }
    };
    request.open('GET', url_root + "/post/getSinglePost&post_id="+post_id);
    request.send();

}

setInterval(function(){
    checkForNotifications();
}, 300000);
$(document).ready(function () {
    checkForNotifications();
});

$('#notifications').click(function () {
    checkForNotifications();
});