// GLOBAL VARS - start

var url_root = window.location.origin + '/projects/FriendBook-v3.0/';

// GLOBAL VARS - end

// GLOBAL FUNCTIONS - start
    // lightbox gallery popup request
    $(document).on("click", '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
// GLOBAL FUNCTIONS - end

// PROFILE PAGE UNDER COVER NAV - start

var timeline = document.querySelector('#timeline');
var about = document.querySelector('#about');
var friends = document.querySelector('#friends');
var photos = document.querySelector('#photos');
var image_list_box = document.querySelector('#image_list');

var photos_btn = document.querySelector('#pictures_btn');
var about_btn = document.querySelector('#about_btn');
var timeline_btn = document.querySelector('#myPosts_btn');
var friends_btn = document.querySelector('#friends_btn');

var upload_photos = document.querySelector('#upload_photos');
var upload_image_btn = document.querySelector('#imageUploadBtn');

var user_id_nav = document.querySelector('#user_nav_id');

if(document.querySelector('#photos')){
    photos_btn.addEventListener('click', getAllPhotos);
}

if(document.querySelector('#about')){
    about_btn.addEventListener('click', get_about_info);
}
if(document.querySelector('#friends')){
    friends_btn.addEventListener('click', show_friends);
}

if(document.querySelector('#timeline')){
    timeline_btn.addEventListener('click', show_feed);
}

if(document.querySelector('#photos') && document.querySelector('#upload_photos')){
    upload_image_btn.addEventListener('click',function () {
        upload_photos.click();
    });
    upload_photos.addEventListener('change', addUserPhotos);
}

function getAllPhotos(e) {
    e.preventDefault();

    var xhr = new XMLHttpRequest();
    // this will get images and albums in future, for now only images
    xhr.open('get', url_root + '/user/getUserPhotos&user_id='+user_id_nav.value);

    timeline.style.display = 'none';
    about.style.display = 'none';
    photos.style.display = 'block';
    friends.style.display = 'none';
    xhr.onload = function () {
        image_list_box.innerHTML = "";
        console.log(this.responseText);
        $res = JSON.parse(this.responseText);
        for(var i = 0; i < $res.length; i++){
            var img = document.createElement('img');
            img.setAttribute('class','img_100');
            var big_img = document.createElement('img');
            var link = document.createElement('a');
            img.classList.add('img-thumbnail');
            img.classList.add('img_100');
            img.src = url_root + $res[i]['img_url'];
            big_img = url_root + $res[i]['img_url'];

            link.setAttribute('data-toggle','lightbox');
            link.setAttribute('data-gallery','single-images');
            link.setAttribute('class','col-sm-3');
            link.href = big_img;
            link.appendChild(img);

            image_list_box.appendChild(link);
        }

    };


    xhr.send();
}

function addUserPhotos() {


    var file_data = $('#upload_photos').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);

    $.ajax({
        url: url_root + '/user/addOnlyImage', // point to server-side PHP script
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (response) {

            var res = JSON.parse(response);
            if(res.hasOwnProperty('uplod_max')){
                var err = document.querySelector('#ajax_error');
                err.innerHTML =  res['uplod_max'];
                err.style.display =  "block";
                document.querySelector('#ajax_success').style.display =  "none";
            }
            else {
                var img = document.createElement('img');
                img.src = url_root + res['img_url'];
                img.classList.add('img-thumbnail');
                img.classList.add('img_100');

                var link = document.createElement('a');

                link.setAttribute('data-toggle','lightbox');
                link.setAttribute('data-gallery','single-images');
                link.setAttribute('class','col-sm-3');
                link.href = url_root + res['img_url'];
                link.appendChild(img);

                image_list_box.appendChild(link);
                var success = document.querySelector('#ajax_success');
                success.innerHTML =  "Successfuly uploaded image";
                success.style.display =  "block";
                document.querySelector('#ajax_error').style.display =  "none";
            }
        }

    });

}

function show_feed() {
    timeline.style.display = 'block';
    about.style.display = 'none';
    photos.style.display = 'none';
    friends.style.display = 'none';
}

function show_friends() {
    timeline.style.display = 'none';
    about.style.display = 'none';
    photos.style.display = 'none';
    friends.style.display = 'block';
}

function get_about_info() {

    timeline.style.display = 'none';
    about.style.display = 'block';
    photos.style.display = 'none';
    friends.style.display = 'none';

}

// PROFILE PAGE UNDER COVER NAV - END