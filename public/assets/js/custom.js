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

    // form upload images
    var multiImageUpload = document.querySelector('#multiImageUpload');

    upload_image_btn.addEventListener('click',function () {
        upload_photos.click();
    });
    upload_photos.addEventListener('change', addUserPhotos);
}

// get Images with no album on click from db
function getAllPhotos(e) {
    e.preventDefault();

    var xhr = new XMLHttpRequest();
    var dir = './uploads/users/photos/';
    // this will get images and albums in future, for now only images
    xhr.open('get', url_root + '/user/getUserPhotos&user_id='+user_id_nav.value);

    timeline.style.display = 'none';
    about.style.display = 'none';
    photos.style.display = 'block';
    friends.style.display = 'none';
    xhr.onload = function () {
        image_list_box.innerHTML = "";
        res = JSON.parse(this.responseText);
        for(var i = 0; i < res.length; i++){
            var img = document.createElement('img');
            img.setAttribute('class','img_100');
            var big_img = document.createElement('img');
            var link = document.createElement('a');
            img.classList.add('img-thumbnail');
            img.classList.add('img_100');

            var urlChunks = res[i]['img_url'].split('/');
            img.src = url_root + dir + 'thumbs/' + urlChunks[urlChunks.length-1];

            big_img = url_root + res[i]['img_url'];

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

// Add photos no album --- start
function addUserPhotos() {

    var requestXhr = new XMLHttpRequest();

    // form data object js
    var form = new FormData(multiImageUpload);

    // .onload <-- status 200 / readyState 4
    requestXhr.onload = function () {

        var res = JSON.parse(this.responseText);
        var dir = './uploads/users/photos/';
        if(res.hasOwnProperty('uplod_max')){
            var err = document.querySelector('#ajax_error');
            err.innerHTML =  res['uplod_max'];
            err.style.display =  "block";
            document.querySelector('#ajax_success').style.display =  "none";
        }
        else {

            for(var i = 0; i < res.length; i++){
                var img = document.createElement('img');
                var urlChunks = res[i].split('/');
                img.src = url_root + dir + 'thumbs/' + urlChunks[urlChunks.length-1];
                img.classList.add('img-thumbnail');
                img.classList.add('img_100');

                var link = document.createElement('a');

                link.setAttribute('data-toggle', 'lightbox');
                link.setAttribute('data-gallery', 'single-images');
                link.setAttribute('class', 'col-sm-3');


                link.href = url_root + res[i];
                link.appendChild(img);

                image_list_box.appendChild(link);
            }

            var success = document.querySelector('#ajax_success');
            success.innerHTML = "Successfully uploaded image";
            success.style.display = "block";
            document.querySelector('#ajax_error').style.display = "none";

        }

    };

    requestXhr.open('POST',url_root + '/user/uploadProfilePhotos',true);

    // send form data, this will send all the form like normal post form
    requestXhr.send(form);

}
// Add photos no album --- end

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

// PROFILE PAGE UNDER COVER NAV - end

// CHANGE PROFILE IMAGE - start
var change_profile_pic_btn = document.querySelector('#change_profile_pic');
var profilePicForm = document.querySelector('#upload_left_image');
var profile_image_upload = document.querySelector('#profile_image_upload');

if(change_profile_pic_btn && profilePicForm){
    profile_image_upload.addEventListener('change', uploadProfilePicture);
    change_profile_pic_btn.addEventListener('click', function () {
        profile_image_upload.click();
    });
}

function uploadProfilePicture() {
    var xhr = new XMLHttpRequest();
    var formData = new FormData(profilePicForm);
    xhr.open('post',url_root+'/user/uploadProfilePic');

    xhr.onload = function () {
        var success = document.querySelector('#ajax_success');
        var error = document.querySelector('#ajax_error');
        var title = document.createElement('h3');
        var ul = document.createElement('ul');

        var picFullA = document.getElementById('zoom_profile_pic')
            .getElementsByTagName('a')[0];
        var picThumbImg = document.querySelector('#mini-profile-pic');

        var picThumbTopNav = document.querySelector('#profilTopUserPic');

        success.innerHTML = '';
        error.innerHTML = '';
        title.innerHTML = '';
        ul.innerHTML= '';

        //console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        if(res.hasOwnProperty('img_count_error')){

            var p = document.createElement('p');
            title.innerHTML = 'Error:';
            p.innerHTML = res.img_count_error;

            error.appendChild(title);
            error.appendChild(p);
            error.style.display = 'block';
        }
        else if(res.hasOwnProperty('error')){

            title.innerHTML = res.error;

            for (var i = 0; i < res.info.length; i++){
                var li = document.createElement('li');
                li.innerHTML = 'Errors: ' + res.info[i].errors + '<br> File Name: ' + res.info[i].name;
                ul.appendChild(li);
            }
            error.appendChild(title);
            error.appendChild(ul);

            error.style.display = 'block';
        }
        else if(res.hasOwnProperty('success')){

            title.innerHTML = 'Successfully uploaded images';

            for (var i = 0; i < res.dataNotPassed.length; i++){
                //console.log(res.dataNotPassed);

                var li = document.createElement('li');
                li.innerHTML = 'File Name: ' + res.dataNotPassed[i].name + ' ----- Errors: ' + res.dataNotPassed[i].errors[0];
                ul.appendChild(li);

            }

            ul.style.backgroundColor = 'red';
            success.appendChild(title);

            if(res.hasOwnProperty('error')){
                var hr = document.createElement('hr');
                success.appendChild(hr);
                var notUploaded = document.createElement('notUploaded');
                notUploaded.innerHTML = 'Files not Uploaded:';
                notUploaded.style.fontWeight = 'bold';
                success.appendChild(notUploaded);
            }
            success.appendChild(ul);
            success.style.display = 'block';

            //console.log(res.images);

            picFullA.href = url_root + res.images.full;
            picThumbImg.src = url_root + res.images.thumb;
            picThumbTopNav.src = url_root + res.images.thumb;

        }


    };

    xhr.send(formData);

}
// CHANGE PROFILE IMAGE - end

// CHANGE PROFILE COVER - start
var change_profile_cover_btn = document.querySelector('#change_profile_cover');
var upload_cover_form = document.querySelector('#upload_cover_form');
var cover_image_input = document.querySelector('#cover_image_input');

if(change_profile_cover_btn && upload_cover_form){
    // input event listener send data
    cover_image_input.addEventListener('change', uploadProfileCover);
    // div btn listener
    change_profile_cover_btn.addEventListener('click', function () {
        // trigger input file selector
        cover_image_input.click();
    });
}

function uploadProfileCover() {
    var xhr = new XMLHttpRequest();
    var formData = new FormData(upload_cover_form);
    xhr.open('post',url_root+'/user/uploadProfileCover');

    xhr.onload = function () {
        var success = document.querySelector('#ajax_success');
        var error = document.querySelector('#ajax_error');
        var title = document.createElement('h3');
        var ul = document.createElement('ul');

        var picFullA = document.querySelector('#cover_link');
        var picThumb = document.querySelector('#profileCover');

        success.innerHTML = '';
        error.innerHTML = '';
        title.innerHTML = '';
        ul.innerHTML= '';

        console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        if(res.hasOwnProperty('img_count_error')){

            var p = document.createElement('p');
            title.innerHTML = 'Error:';
            p.innerHTML = res.img_count_error;

            error.appendChild(title);
            error.appendChild(p);
            error.style.display = 'block';
        }
        else if(res.hasOwnProperty('error')){

            title.innerHTML = res.error;

            for (var i = 0; i < res.info.length; i++){
                var li = document.createElement('li');
                li.innerHTML = 'Errors: ' + res.info[i].errors + '<br> File Name: ' + res.info[i].name;
                ul.appendChild(li);
            }
            error.appendChild(title);
            error.appendChild(ul);

            error.style.display = 'block';
        }
        else if(res.hasOwnProperty('success')){

            title.innerHTML = 'Successfully uploaded images';

            for (var i = 0; i < res.dataNotPassed.length; i++){
                //console.log(res.dataNotPassed);

                var li = document.createElement('li');
                li.innerHTML = 'File Name: ' + res.dataNotPassed[i].name + ' ----- Errors: ' + res.dataNotPassed[i].errors[0];
                ul.appendChild(li);

            }

            ul.style.backgroundColor = 'red';
            success.appendChild(title);

            if(res.hasOwnProperty('error')){
                var hr = document.createElement('hr');
                success.appendChild(hr);
                var notUploaded = document.createElement('notUploaded');
                notUploaded.innerHTML = 'Files not Uploaded:';
                notUploaded.style.fontWeight = 'bold';
                success.appendChild(notUploaded);
            }
            success.appendChild(ul);
            success.style.display = 'block';

            //console.log(res.images);

            picFullA.href = url_root + res.images.full;
            picThumb.style.backgroundImage = "url('" + url_root + res.images.thumb + "')";

        }


    };

    xhr.send(formData);

}
// CHANGE profile COVER - end