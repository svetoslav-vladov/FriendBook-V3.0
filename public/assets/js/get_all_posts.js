// function getAllPosts() {
//     var req = new XMLHttpRequest();
//     req.onreadystatechange = function () {
//         if (this.readyState == 4 && this.status == 200) {
//             var posts = JSON.parse(this.responseText);
//             console.log(posts);
//             for(var post of posts) {
//                 console.log(post);
//             }
//         }
//     };
//     req.open("GET", url_root + "/post/getAllPosts");
//     req.send();
// }
