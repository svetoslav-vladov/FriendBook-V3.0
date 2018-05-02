function sendFriendRequest(requester_id) {
    var cancelRequestBtn = $(`<button class="add-friend-button btn btn-primary btn-xs" id="cancelFriendRequest${requester_id}"><i class="fas fa-times"></i> cancel request</button>`);
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/sendFriendRequest');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#friendNavigation'+requester_id).append(cancelRequestBtn);
            $('#sendFriendRequest'+requester_id).remove();
        }
    };

    cancelRequestBtn.click(function () {
        cancelFriendRequest(requester_id);
    });
    request.send("requester_id="+requester_id);
}

function cancelFriendRequest(requester_id) {
    var sendRequestBtn = $(`<button class="add-friend-button btn btn-primary btn-xs" id="sendFriendRequest${requester_id}"><i class="fas fa-user-plus"></i> add friend</button>`);
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/cancelFriendRequest');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#friendNavigation'+requester_id).append(sendRequestBtn);
            $('#cancelFriendRequest'+requester_id).remove();
        }
    };
    sendRequestBtn.click(function () {
        sendFriendRequest(requester_id);
    });
    request.send("requester_id="+requester_id);
}

function getFriendRequests(user_id) {
    var friendRequestsList = $('#friend-requests'+user_id);
    friendRequestsList.empty();
    friendRequestsList.hide();
    loading_gif.show();
    $('#requestContainer'+user_id).append(loading_gif);
    var noRequests = $(`<li class="list-group-item">not requests</li>`);
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var friendRequests = JSON.parse(this.responseText);
            if (friendRequests.length === 0) {
                friendRequestsList.append(noRequests);
            }
            for(var request of friendRequests) {
                var friendRequest = $(`<li class="list-group-item">
                                    <a class="request-user  ${(request['gender'] == 'male') ? 'male' : 'female'}" href="${url_root}/index/profile&id=${request['id']}"> 
                                        <img class="mr-3" src=${(request['thumbs_profile'] == null) ? root+request['profile_pic'] : root+request['thumbs_profile']}>
                                    </a>
                                    <div class="media-body requestNavigation" id="request-navigation${request['id']}">
                                        <h5 class="mt-0">
                                            <a class="request-friend-name ${(request['gender'] == 'male') ? 'male' : 'female'}" href="${url_root}/index/profile&id=${request['id']}">
                                                ${(request['display_name'] == null) ? (request['first_name'] + " " + request['last_name']) : request['display_name']}
                                            </a>
                                        </h5>
                                        <button class="accept-request-button" onclick="acceptRequest()">accept</button>
                                            <button class="decline-request-button" onclick="declineRequest()">decline</button>
                                    </div>
                                </li>`);
                friendRequestsList.append(friendRequest);
            }
            setTimeout(function () {
                loading_gif.hide();
                friendRequestsList.show();
            }, 800);
        }
    };
    req.open("GET", url_root + "/user/getFriendRequests&user_id="+user_id);
    req.send();
}

function acceptRequest() {
    //TODO
}

function declineRequest() {
    //TODO
}

// function isFriend(friend_id) {
//     var addFriendButton = $(`<button class="add-button" id="add${friend_id}"><i class="fas fa-user-plus"></i> add friend</button>`);
//     var deleteFriendButton = $(`<button class="delete-button" id="delete${friend_id}"><i class="fas fa-ban"></i> delete friend</button>`);
//     var req = new XMLHttpRequest();
//     req.onreadystatechange = function () {
//         if (this.readyState === 4 && this.status === 200) {
//             addFriendButton.click(function () {
//                 addFriend(friend_id);
//                 $(this).remove();
//             });
//             deleteFriendButton.click(function () {
//                 deleteFriend(friend_id);
//                 $(this).remove();
//             });
//             if (this.responseText == 1) {
//                 $('#friend'+friend_id).append(deleteFriendButton);
//             }
//             else {
//                 $('#friend'+friend_id).append(addFriendButton);
//             }
//         }
//     };
//     req.open("GET", "../controller/addFriend_controller.php?friend_id="+friend_id);
//     req.send();
// }
//
// function getAllFriends(user_id, logged_user_id) {
//     var friendsContainer = $('#friends-container'+user_id);
//     friendsContainer.empty();
//     var request = new XMLHttpRequest();
//     request.onreadystatechange = function() {
//         if (this.readyState === 4 && this.status === 200) {
//             getCurrentCountFriends(user_id);
//             var friends = JSON.parse(this.responseText);
//             for (var friend of friends) {
//                 var friendDiv = $(`<div class="friend-div ${(friend['gender'] == 'male') ? 'male-background' : 'female-background'}" id="friend${friend['id']}">
//                                      <a class="${(friend['gender'] == 'male') ? 'male' : 'female'}" href="profile.php?id=${friend['id']}">
//                                      <img src="${friend['profile_pic']}">${friend['first_name']} ${friend['last_name']}</a>
//                                 </div>`);
//                 if (user_id === logged_user_id) {
//                     isFriend(friend['id']);
//                 }
//                 friendsContainer.append(friendDiv);
//             }
//         }
//     };
//     request.open("GET", "../controller/get_all_friends_controller.php?id="+user_id, true);
//     request.send();
// }
//
// getCountFriends();
// function getCountFriends() {
//     $('#friendsCounter').empty();
//     var req = new XMLHttpRequest();
//     req.onreadystatechange = function () {
//         if (this.readyState == 4 && this.status == 200) {
//             $('#friendsCounter').text(this.responseText);
//          }
//     };
//     req.open("GET", "../controller/friendsCounter_controller.php");
//     req.send();
// }
//
// function getCurrentCountFriends(user_id) {
//     $('#profileFriendsCounter'+user_id).empty();
//     var req = new XMLHttpRequest();
//     req.onreadystatechange = function () {
//         if (this.readyState == 4 && this.status == 200) {
//             $('#profileFriendsCounter'+user_id).text(this.responseText);
//         }
//     };
//     req.open("GET", "../controller/get_current_count_fr_controller.php?id="+user_id);
//     req.send();
// }
