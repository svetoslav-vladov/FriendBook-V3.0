var friendReqNotifications = $(`<span class="friendNotifications"></span>`);

function sendFriendRequest(requester_id) {
    var cancelRequestBtn = $(`<button class="add-friend-button btn btn-danger" id="cancelFriendRequest${requester_id}"><i class="fas fa-times"></i> cancel request</button>`);
    $('#sendFriendRequest'+requester_id).remove();
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/sendFriendRequest');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#add-cancel-container'+requester_id).append(cancelRequestBtn);
        }
    };

    cancelRequestBtn.click(function () {
        cancelFriendRequest(requester_id);
    });
    request.send("requester_id="+requester_id);
}

function cancelFriendRequest(requester_id) {
    var sendRequestBtn = $(`<button class="add-friend-button btn btn-success" id="sendFriendRequest${requester_id}"><i class="fas fa-user-plus"></i> add friend</button>`);
    $('#cancelFriendRequest'+requester_id).remove();
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/cancelFriendRequest');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#add-cancel-container'+requester_id).append(sendRequestBtn);
        }
    };
    sendRequestBtn.click(function (e) {
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
    var noRequests = $(`<li class="list-group-item">there are no friend requests</li>`);
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var friendRequests = JSON.parse(this.responseText);
            if (friendRequests.length === 0) {
                friendRequestsList.append(noRequests);
                friendRequestsList.show();
                loading_gif.hide();
                return;
            }
            for(var request of friendRequests) {
                var friendRequest = $(`<li class="list-group-item" id="requestFrom${request['id']}">
                                    <a class="request-user  ${(request['gender'] == 'male') ? 'male' : 'female'}" href="${url_root}/index/profile&id=${request['id']}"> 
                                        <img class="mr-3" src=${(request['thumbs_profile'] == null) ? root+request['profile_pic'] : root+request['thumbs_profile']}>
                                    </a>
                                    <div class="media-body requestNavigation" id="request-navigation${request['id']}">
                                        <h5 class="mt-0">
                                            <a class="request-friend-name ${(request['gender'] == 'male') ? 'male' : 'female'}" href="${url_root}/index/profile&id=${request['id']}">
                                                ${(request['display_name'] == null) ? (request['first_name'] + " " + request['last_name']) : request['display_name']}
                                            </a>
                                        </h5>
                                        <div id="accept-decline-container${request['id']}">
                                            <button id="acceptButton${request['id']}" class="accept-request-button" onclick="acceptRequest(${request['id']})">accept</button>
                                            <button id="declineButton${request['id']}" class="decline-request-button" onclick="declineRequest(${request['id']})">decline</button>
                                        </div>
                                    </div>
                                </li>`);
                friendRequestsList.append(friendRequest);
                noRequests.bind('click', function (e) { e.stopPropagation(); });
                $(`#requestFrom${request['id']}`).bind('click', function (e) { e.stopPropagation(); });
            }
            setTimeout(function () {
                loading_gif.hide();
                friendRequestsList.show();
            }, 500);
        }
    };
    req.open("GET", url_root + "/user/getFriendRequests&user_id="+user_id);
    req.send();
}

function acceptRequest(requested_by) {
    var message = $('<p class="message">You are already friends</p>');
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/acceptFriendRequest');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#acceptButton'+requested_by).remove();
            $('#declineButton'+requested_by).remove();
            $('#accept-decline-container'+requested_by).append(message);
            checkForRequests();
        }
    };
    request.send("requested_by="+requested_by);
}

function deleteFriend(friend_id) {
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/deleteFriend');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
        }
    };
    request.send("friend_id="+friend_id);
}

function declineRequest(requester_id) {
    var request = new XMLHttpRequest();
    request.open('post', url_root+'/user/declineFriendRequest');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#requestFrom'+requester_id).fadeOut(500);
            setTimeout(function () {
                $('#requestFrom'+requester_id).remove();
            },1000);
            checkForRequests();
        }
    };
    request.send("requester_id="+requester_id);
}

function checkForRequests() {
    friendReqNotifications.empty();
    friendReqNotifications.hide();
    var request = new XMLHttpRequest();
    request.open('GET', url_root+'/user/checkForRequests');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.responseText == 0) {
            return;
        }
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText != 0) {
                friendReqNotifications.show();
                console.log(this.responseText);
                friendReqNotifications.html(this.responseText);
                $('#friendRequests').append(friendReqNotifications);
            }
        }
    };
    request.send();
}

function getSuggestedUsers() {
    var request = new XMLHttpRequest();
    request.open('GET', url_root+'/user/getSuggestedUsers');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    $('.proposed-users').empty();
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var suggestedd_users = JSON.parse(this.responseText);
            for(var user of suggestedd_users) {
                var suggested_user = $(`<div class="media suggested-user-container">
                <a class="user_pic" href=${root}/index/profile&id=${user['id']}>
                    <img class="mr-3 suggested-user-img" src=${(user['thumbs_profile'] == null) ? root+user['profile_pic'] : root+user['thumbs_profile']}>
                </a>
                <div class="media-body" id="friendNavigation${user['id']}">
                    <h5 class="mt-0">
                        <a class="${(user['gender'] == 'male') ? 'male' : 'female'}" href=${root}/index/profile&id=${user['id']}>
                            ${(user['display_name'] == null) ? (user['first_name'] + " " + user['last_name']) : user['display_name']}
                        </a>
                    </h5>
                    <small><i>Registered on: ${user['reg_date']}</i></small>
                    <div class="add-cancel-buttons-container" id="add-cancel-container${user['id']}">
                        <button onclick="sendFriendRequest(${user['id']})" class="add-friend-button btn btn-success btn-xs" id="sendFriendRequest${user['id']}"><i class="fas fa-user-plus"></i> add friend</button>
                    </div>
                </div>
            </div>`);
                $('.proposed-users').append(suggested_user);
            }
        }
    };
    request.send();
}

function getFriends(user_id) {
    var friendsContainer = $('#friendsContainer'+user_id);
    friendsContainer.empty();
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var friends = JSON.parse(this.responseText);
            for(var user of friends) {

                var friendCard = $(`<div class="media friend-card">
                                        <a class="user_pic" href=${root}/index/profile&id=${user['id']}>
                                            <img class="mr-3 suggested-user-img" src=${(user['thumbs_profile'] == null) ? root+user['profile_pic'] : root+user['thumbs_profile']}>
                                        </a>
                                        <div class="media-body" id="friendNavigation${user['id']}">
                                            <h5 class="mt-0">
                                                <a class="${(user['gender'] == 'male') ? 'male' : 'female'}" href=${root}/index/profile&id=${user['id']}>
                                                    ${(user['display_name'] == null) ? (user['first_name'] + " " + user['last_name']) : user['display_name']}
                                                </a>
                                            </h5>
                                            <small><i>Registered on: ${user['reg_date']}</i></small>
                                        </div>
                                    </div>`);
                friendsContainer.append(friendCard);
            }
            $('#friends_btn').append($(`<span class="friends-counter">${friends.length}</span>`));
        }
    };
    req.open("GET", url_root + "/user/getFriends&user_id="+user_id);
    req.send();
}

function  getOwnFriends(session_id) {
    var friendsContainer = $('#friendsContainer'+session_id);
    friendsContainer.empty();
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var friends = JSON.parse(this.responseText);
            for(var user of friends) {
                var friendCard = $(`<div class="media friend-card" id="friend-card${user['id']}">
                                        <a class="user_pic" href=${root}/index/profile&id=${user['id']}>
                                            <img class="mr-3 suggested-user-img" src=${(user['thumbs_profile'] == null) ? root+user['profile_pic'] : root+user['thumbs_profile']}>
                                        </a>
                                        <div class="media-body" id="friendNavigation${user['id']}">
                                            <h5 class="mt-0">
                                                <a class="${(user['gender'] == 'male') ? 'male' : 'female'}" href=${root}/index/profile&id=${user['id']}>
                                                    ${(user['display_name'] == null) ? (user['first_name'] + " " + user['last_name']) : user['display_name']}
                                                </a>
                                            </h5>
                                            <small><i>Registered on: ${user['reg_date']}</i></small>
                                            <button onclick="deleteFriend(${user['id']})" class="delete-friend-button btn btn-danger btn-sm" id="deleteFriend${user['id']}"><i class="fas fa-user-plus"></i>delete friend</button>
                                        </div>
                                    </div>`);
                friendsContainer.append(friendCard);
                $('#deleteFriend'+user['id']).click(function () {
                    $('#friend-card'+user['id']).fadeOut(400);
                    setTimeout(function () {
                        $('#friend-card'+user['id']).remove();
                    },500)
                });
            }

            $('#friends_btn').append($(`<span class="friends-counter">${friends.length}</span>`));
        }
    };
    req.open("GET", url_root + "/user/getOwnFriends");
    req.send();
}
// function that checks on database server within 10 seconds if an invitation to friendship has been sent to me
setInterval(function(){
    checkForRequests();
    getSuggestedUsers();
}, 10000);
$(document).ready(function () {
    checkForRequests();
    getSuggestedUsers();
});

$('#friendRequests').click(function () {
    checkForRequests();
    getSuggestedUsers();
});



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
