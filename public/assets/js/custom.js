// GLOBAL VARS - start

var url_root = window.location.origin + '/projects/FriendBook-v3.0';
var loading_gif_anim = url_root + '/assets/images/ajax-loading-c4.gif';
var successMark = url_root + '/assets/images/Yes_Check_Circle.svg.png';
var attention = url_root + '/assets/images/attention.png';

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

// CHANGE profile COVER !!! no albums - start

// ADD PROFILE PHOTOS - start

var ImageAdd = document.querySelector('#ImageAdd');
var uploadUserPhotosForm = document.querySelector('#uploadUserPhotosForm');
var uploadPhotosInput = document.querySelector('#uploadPhotosInput');

if(ImageAdd && upload_cover_form){
    // input event listener send data
    uploadPhotosInput.addEventListener('change', uploadProfilePhotos);
    // div btn listener
    ImageAdd.addEventListener('click', function () {
        // trigger input file selector
        uploadPhotosInput.click();
    });
}

function uploadProfilePhotos() {
    var xhr = new XMLHttpRequest();
    var formData = new FormData(uploadUserPhotosForm);
    xhr.open('post',url_root+'/user/uploadProfilePhotos');

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

        var res = JSON.parse(this.responseText);

        if(res.img_count_error){

            var p = document.createElement('p');
            title.innerHTML = 'Error:';
            p.innerHTML = res.img_count_error;

            error.appendChild(title);
            error.appendChild(p);
            error.style.display = 'block';
        }
        else if(res.error){

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
        else if(res.success){

            title.innerHTML = 'Loading...';

            for (var i = 0; i < res.dataNotPassed.length; i++){
                //console.log(res.dataNotPassed);

                var li = document.createElement('li');
                li.innerHTML = 'File Name: ' + res.dataNotPassed[i].name + ' ----- Errors: ' + res.dataNotPassed[i].errors[0];
                ul.appendChild(li);

            }

            ul.style.backgroundColor = 'red';
            success.appendChild(title);


            // appending data after second loop

            success.style.display = 'block';

            success.style.backgroundColor= 'yellow';
            var loading = document.createElement('img');
            loading.src = url_root+loading_gif_anim;
            success.appendChild(loading);

            for (var x = 0; x < res.picture_object_data.length; x++){
                var link_img = document.createElement('a');
                link_img.setAttribute('data-toggle','lightbox');
                link_img.setAttribute('data-gallery','single-images');
                link_img.setAttribute('class','col-sm-3');
                link_img.href = root + res.picture_object_data[x].urlOnDiskPicture;

                var img_photo = document.createElement('img');
                img_photo.src = root + res.picture_object_data[x].urlOnDiskThumb;
                img_photo.classList.add('img_100');
                img_photo.classList.add('img-thumbnail');

                link_img.appendChild(img_photo);
                image_list_box.appendChild(link_img);

            }
            success.innerHTML ='';
            loading.src = successMark;
            loading.style.height = '50px';
            title.innerHTML = 'Succesfully uploaded';
            success.style.backgroundColor= 'green';
            success.appendChild(title);
            if(res.error){
                var hr = document.createElement('hr');
                success.appendChild(hr);
                var notUploaded = document.createElement('notUploaded');
                notUploaded.innerHTML = 'Files not Uploaded:';
                notUploaded.style.fontWeight = 'bold';
                success.appendChild(notUploaded);
            }

            success.appendChild(ul);
            success.appendChild(loading);




            //console.log(res);
           // console.log(res.picture_object_data[0].urlOnDiskPicture);
           // console.log(res.picture_object_data[1].urlOnDiskPicture);


            // picFullA.href = url_root + res.images.full;
            // picThumb.style.backgroundImage = "url('" + url_root + res.images.thumb + "')";

        }


    };

    xhr.send(formData);

}
// ADD PROFILE PHOTOS - end !!! no albums

// SETTINGS PAGE -start

// Left menu buttons
var general_btn = document.querySelector('#general');
var security_btn = document.querySelector('#security');

// getting submit btn's
var general_submit = document.querySelector('#general_submit');
var security_submit = document.querySelector('#security_submit');

// div boxes
var general_box = document.querySelector('#general_box');
var security_box = document.querySelector('#security_box');

// status box for loading image and success icon
var statusBox = document.querySelector("#settingsStatus");
// check if element is on page
if(statusBox){
    statusBox.style.display = "none";
}
if(general_btn || security_btn || general_box || security_box){

    general_btn.addEventListener('click', showGeneralBox);
    security_btn.addEventListener('click', showSecurityBox);

    function showGeneralBox(){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        general_btn.classList.toggle("active_btn");
        general_box.style.display = 'block';

        security_box.style.display = 'none';
        security_btn.classList.toggle("active_btn");

        if(document.querySelector('.success')){
            general_box.removeChild(document.querySelector('.success'));
        }
        if(document.querySelector('.error')){
            general_box.removeChild(document.querySelector('.error'));
        }

    }

    function showSecurityBox(){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        security_btn.classList.toggle("active_btn");
        security_box.style.display = 'block';

        general_box.style.display = 'none';
        general_btn.classList.toggle("active_btn");

        if(document.querySelector('.success')){
            general_box.removeChild(document.querySelector('.success'));
        }
        if(document.querySelector('.error')){
            general_box.removeChild(document.querySelector('.error'));
        }
    }
}

if(document.querySelector('#general_submit')){
    general_submit.addEventListener('click', saveGeneralSettings);
}

function saveGeneralSettings(e) {
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/saveGeneralSettings');
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // .onload is status 200 / ready 4


    //content_box.appendChild(loading_image);

    var first_name = document.querySelector('#first_name');
    var last_name = document.querySelector('#last_name');
    var display_name = document.querySelector('#display_name');
    var relation_status = document.querySelector('#relation_status');
    var gender = document.querySelector('#gender');
    var birthday = document.querySelector('#birthday');
    var country = document.querySelector('#country');
    var website = document.querySelector('#web_addres');
    var mobile_number = document.querySelector('#mobile_number');
    var skype_name = document.querySelector('#skype_name');
    var data = {
        'first_name': first_name.value,
        'last_name': last_name.value,
        'display_name': display_name.value,
        'relation_status': relation_status.value,
        'gender': gender.value,
        'birthday': birthday.value,
        'country': country.value,
        'website': website.value,
        'mobile_number': mobile_number.value,
        'skype_name': skype_name.value
    };

    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    setTimeout(function(){
        xhr.onload = function() {

            statusBox.innerHTML = '';
            statusBox.style.display = 'block';

            var res = JSON.parse(this.responseText);

            if(res.errors){
                var p = document.createElement('p');
                p.innerHTML = res.errors;
                img.src = attention;
                statusBox.appendChild(img);
                statusBox.appendChild(p);
            }
            else{
                var p = document.createElement('p');
                p.innerHTML = "Saved Successfuly";
                img.src = successMark;
                statusBox.appendChild(img);
                statusBox.appendChild(p);
            }
        };

        xhr.send('general' + '&data=' + JSON.stringify(data));
    },500);

}

// SETTINGS PAGE - end