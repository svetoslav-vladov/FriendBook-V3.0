function sendFriendRequest(requester_id) {
    var cancelRequestBtn = $(`<button class="add-friend-button btn btn-primary btn-xs" id="cancelFriendRequest${requester_id}"><i class="fas fa-times"></i> cancel request</button>`);
    var request = new XMLHttpRequest();
    request.open('post', url_root+'user/sendFriendRequest');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#friendNavigation'+requester_id).append(cancelRequestBtn);
            $('#sendFriendRequest'+requester_id).remove();
            console.log('sent request: requester_id = '+requester_id);
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
    request.open('post', url_root+'user/cancelFriendRequest');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            $('#friendNavigation'+requester_id).append(sendRequestBtn);
            $('#cancelFriendRequest'+requester_id).remove();
            console.log('canceled request: requester_id = '+requester_id);
        }
    };
    sendRequestBtn.click(function () {
        sendFriendRequest(requester_id);
    });
    request.send("requester_id="+requester_id);
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
