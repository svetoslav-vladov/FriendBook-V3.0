function getAllPosts(limit,offset) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        posts = JSON.parse(this.responseText);
        if (posts.length == 0) {
            $('.loading_posts').remove();
            return;
        }
        if (this.readyState === 4 && this.status === 200) {
            for(var post of posts) {
                var postCard = $(`
                <div class="card p-3 mt-3 mb-3" id="post${post['post_id']}">
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
                        ${(post['isMyPost'] == 1) ? `<button data-toggle="modal" data-target=".bd-example-modal-sm" id="${post['post_id']}" type="button" class="close delete-post-button" aria-label="Close">
                                <span aria-hidden="true">&#10008;delete</span>
                            </button>
                            <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to delete the post?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="deletePost(${post['post_id']})">Yes</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>` : ''}
                       </div>
                    <div class="description">
                        <p>${post['description']}</p>
                    </div>
                    <div id="post-details${post['post_id']}">
                        <div class="post_navigation">
                            <div class="like-container" id="like-container${post['post_id']}">
                                <script>
                                    isLiked(${post['post_id']});
                                </script>
                            </div>
                             <div class="like-container" id="dislike-container${post['post_id']}">
                                <script>
                                    isDisliked(${post['post_id']});
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
                $('#newsfeed').append(postCard);
            }
        }
    };
    request.open('GET', url_root + "/post/getAllPosts&limit="+limit+"&offset="+offset);
    request.send();

}

function getAllPostsByLike() {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var posts = JSON.parse(this.responseText);
            for(var post of posts) {
                var postCard = $(`
                <div class="card p-3 mt-3 mb-3" id="post${post['post_id']}">
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
                        ${(post['isMyPost'] == 1) ? `<button data-toggle="modal" data-target=".bd-example-modal-sm" id="${post['post_id']}" type="button" class="close delete-post-button" aria-label="Close">
                                <span aria-hidden="true">&#10008;delete</span>
                            </button>
                            <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to delete the post?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="deletePost(${post['post_id']})">Yes</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>` : ''}
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

                $('#newsfeed').append(postCard);
            }
        }
    };
    req.open("GET", url_root + "/post/getAllPostsByLike");
    req.send();
}