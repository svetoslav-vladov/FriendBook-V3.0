function searchUser(str) {
    var userListDiv = $('.users-result');
    var usersList = $('.users-list');
    usersList.empty();
    if (str.length === 0) {
        usersList.empty();
        userListDiv.hide();
        return;
    }
    else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                userListDiv.show();
                if (this.responseText === 'Not found!') {
                    usersList.empty();
                    var notFound = $('<li class="not-found list-group-item">Not found!</li>');
                    usersList.append(notFound);
                    return;
                }
                var users = JSON.parse(this.responseText);
                usersList.empty();
                for (var user of users) {
                    var li = $(`<li class="list-group-item">
                                <a href="${root}/index/profile&id=${user['id']}" class="${(user['gender'] == 'male') ? 'male' : 'female'}">
                                    <img class="img-fluid search_image" src="${(user['thumbs_profile'] == null) ? root+user['profile_pic'] : root+user['thumbs_profile']}">
                                    <span class="search_user">${user['first_name']} ${user['last_name']}</span>
                                </a>
                              </li>`);
                    usersList.append(li);
                    // Code for make bold found string in the searched string
                    $('.search_user:contains('+str+')').each( function(i, element) {
                        var content = $(element).text();
                        content = content.replace(str, `<b>${str}</b>`);
                        $(this).html(content);
                    });
                    userListDiv.append(usersList);
                }
                $('.users-list li a').click(function () {
                    userListDiv.hide();
                });
                $('html').click(function() {
                    userListDiv.hide();
                });
                $(this).click(function () {
                    userListDiv.show();
                });
            }
        };
        xmlhttp.open("GET", url_root + "/user/searchUser&search="+str, true);
        xmlhttp.send();
    }
}