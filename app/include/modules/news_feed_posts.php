<div id="newsfeed">
    <script>
        $(document).ready(function () {
            var limit = 3;
            var offset = 0;
            getAllPosts(limit, offset);
            
            $(window).scroll(function() {
                if($(window).scrollTop() == $(document).height() - ($(window).height())) {
                    offset += 3;
                    $('.loading_posts').show();
                    setTimeout(function () {
                        getAllPosts(limit, offset);
                    },200);
                }
            });
        });
    </script>
</div>
<div class="loading_posts_container">
    <img src="<?php echo URL_ROOT."/assets/images/ajax-loading-c4.gif"?>" class="loading_posts" style="display: none">
</div>
