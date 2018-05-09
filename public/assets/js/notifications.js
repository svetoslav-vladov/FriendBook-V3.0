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
            var notification = JSON.parse(this.responseText);
            if (notification.length === 0) {
                notificationsList.append(notNotification);
                notificationsList.show();
                loading_gif.hide();
                return;
            }
            for(var notification of notification) {
                var notificationLi = $(`<li class="list-group-item" id="notificationFrom${notification['id']}">
                                    <a class="request-user  ${(notification['gender'] == 'male') ? 'male' : 'female'}" href="${url_root}/index/profile&id=${notification['id']}"> 
                                        <img class="mr-3" src=${(notification['thumbs_profile'] == null) ? root+notification['profile_pic'] : root+notification['thumbs_profile']}>
                                    </a>
                                    <div class="media-body requestNavigation" id="notification-navigation${notification['id']}">
                                        <h5 class="mt-0">
                                            <a class="request-friend-name ${(notification['gender'] == 'male') ? 'male' : 'female'}" href="${url_root}/index/profile&id=${notification['user_id']}">
                                                ${(notification['display_name'] == null) ? (notification['first_name'] + " " + notification['last_name']) : notification['display_name']}
                                            </a>
                                            <span class="notification-description">${notification['notification_description']} your post on ${notification['notification_date']}</span>
                                        </h5>
                                        <div>
                                            <button type="button" class="view-notification-button btn btn-success btn-sm">
                                            <a href="${url_root}/index/post&post_id=${notification['post_id']}">view</a>
                                            </button>
                                        </div>
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

}