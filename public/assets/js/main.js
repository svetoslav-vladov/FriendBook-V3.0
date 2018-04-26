function getLikedPost() {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var result = JSON.parse(this.responseText);

        }
    };
    req.open("GET", "../controller/get_liked_posts_controller.php");
    req.send();
}