// GLOBAL VARS - start

var url_root = window.location.origin + '/projects/FriendBook-v3.0';
var loading_gif_anim = url_root + '/assets/images/ajax-loading-c4.gif';
var successMark = url_root + '/assets/images/Yes_Check_Circle.svg.png';
var attention = url_root + '/assets/images/attention.png';
var denied = url_root + '/assets/images/denied.png';

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

// ADD PROFILE PHOTOS

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

// SETTINGS PAGE -start

// Left menu buttons
var general_btn = document.querySelector('#general');
var security_btn = document.querySelector('#security');
var description_btn = document.querySelector('#description');

// getting submit btn's
var description_submit = document.querySelector('#description_submit');

// div boxes
var general_box = document.querySelector('#general_box');
var security_box = document.querySelector('#security_box');
var desc_box = document.querySelector('#desc_box');

// status box for loading image and success icon
var statusBox = document.querySelector("#settingsStatus");

// check if element is on page
if(statusBox){
    statusBox.style.display = "none";
}

if(general_btn || security_btn || general_box || security_box){

    general_btn.addEventListener('click', showGeneralBox);
    security_btn.addEventListener('click', showSecurityBox);
    description_btn.addEventListener('click', showDescriptionBox);

    function showGeneralBox(){
        statusBox.innerHTML = '';
        general_btn.classList.toggle("active_btn");
        general_box.style.display = 'block';

        security_box.style.display = 'none';
        desc_box.style.display = 'none';



        if(document.querySelector('.success')){
            general_box.removeChild(document.querySelector('.success'));
        }
        if(document.querySelector('.error')){
            general_box.removeChild(document.querySelector('.error'));
        }

    }

    function showSecurityBox(){
        statusBox.innerHTML = '';

        security_btn.classList.toggle("active_btn");
        security_box.style.display = 'block';

        general_box.style.display = 'none';
        desc_box.style.display = 'none';


        if(document.querySelector('.success')){
            general_box.removeChild(document.querySelector('.success'));
        }
        if(document.querySelector('.error')){
            general_box.removeChild(document.querySelector('.error'));
        }
    }

    function showDescriptionBox(){
        statusBox.innerHTML = '';

        security_btn.classList.toggle("active_btn");
        desc_box.style.display = 'block';

        general_box.style.display = 'none';
        security_box.style.display = 'none';


        if(document.querySelector('.success')){
            general_box.removeChild(document.querySelector('.success'));
        }
        if(document.querySelector('.error')){
            general_box.removeChild(document.querySelector('.error'));
        }
    }
}

// description settings save
if(desc_box){
    description_submit.addEventListener('click', saveDescriptionSettings);
}
// CHANGE description
function saveDescriptionSettings(e) {
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/saveDescriptionSettings');
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // .onload is status 200 / ready 4

    var descText = document.querySelector('#descText');

    var data = {
        'description': descText.value
    };

    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(document.querySelector('#descText').value.length > 1500){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Length Limit max 1500 char!';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else if(document.querySelector('#descText').value.trim().length === 0){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Empty field';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{
        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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

            xhr.send('description' + '&data=' + JSON.stringify(data));
        },500);
    }



}

// CHANGE First Name
    // this is in modal
var firstNameInput = document.querySelector("#firstName");
var userFirstNameForm = document.querySelector("#userFirstNameForm");
var firstNameSubmit = document.querySelector("#firstNameSubmit");
    //this is in general settings
var lableValueFirstName = document.querySelector("#lableValueFirstName");

if(firstNameSubmit){
    firstNameSubmit.addEventListener('click',changeFirstName);
}
function changeFirstName(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeFirstName');

    var formData = new FormData(userFirstNameForm);

    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(firstNameInput.value.length > 15 || firstNameInput.value.length === 0){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Length Limit, cannot be empty or more than 15 char!';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{

        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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
                    lableValueFirstName.innerHTML = firstNameInput.value;
                }
            };
            xhr.send(formData);
        },500);

    }
}

// CHANGE Last Name
    // this is in modal
var lastNameInput = document.querySelector("#lastName");
var userLastNameForm = document.querySelector("#userLastNameForm");
var lastNameSubmit = document.querySelector("#lastNameSubmit");
    //this is in general settings
var lableValueLastName = document.querySelector("#lableValueLastName");

if(lastNameSubmit){
    lastNameSubmit.addEventListener('click',changeLastName);
}
function changeLastName(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeLastName');
    var formData = new FormData(userLastNameForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(lastNameInput.value.length > 15 || lastNameInput.value.length === 0){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Length Limit, cannot be empty or more than 15 char!';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{

        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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
                    lableValueLastName.innerHTML = lastNameInput.value;
                }
            };
            xhr.send(formData);
        },500);

    }
}

// CHANGE Last Name
    // this is in modal
var displayNameInput = document.querySelector("#displayName");
var userDisplayNameForm = document.querySelector("#userDisplayNameForm");
var displayNameSubmit = document.querySelector("#displayNameSubmit");
    //this is in general settings
var lableValueDisplayName = document.querySelector("#lableValueDisplayName");

if(displayNameSubmit){
    displayNameSubmit.addEventListener('click', changeDisplayName);
}
function changeDisplayName(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeDisplayName');
    var formData = new FormData(userDisplayNameForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(displayNameInput.value.length > 20 || displayNameInput.value.length === 0){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Length Limit, cannot be empty or more than 20 char!';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{

        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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
                    lableValueDisplayName.innerHTML = displayNameInput.value;
                }
            };
            xhr.send(formData);
        },500);

    }
}

// CHANGE Relationship
    // this is in modal
var relationStatusInput = document.querySelector("#relationStatus");
var userRelationshipForm = document.querySelector("#userRelationshipForm");
var relationSubmit = document.querySelector("#relationSubmit");
    //this is in general settings
var lableValueRelationship = document.querySelector("#lableValueRelationship");
var currentStateRelationship = document.querySelector("#currentStateRelationship");

if(relationSubmit){
    relationSubmit.addEventListener('click', changeRelationship);
}

function changeRelationship(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeRelationship');
    var formData = new FormData(userRelationshipForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(relationStatusInput.value.length > 2 || relationStatusInput.value.length === 0){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Length Limit, cannot be empty or more than 2 char!';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{

        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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
                    lableValueRelationship.innerHTML = relationStatusInput.options[relationStatusInput.value].text;
                    currentStateRelationship.innerHTML = relationStatusInput.options[relationStatusInput.value].text;
                }
            };
            xhr.send(formData);
        },500);

    }
}

// CHANGE gender
    // this is in modal
var genderInput = document.querySelector("#gender");
var userGenderForm = document.querySelector("#userGenderForm");
var genderSubmit = document.querySelector("#genderSubmit");
    //this is in general settings
var lableValueGender = document.querySelector("#lableValueGender");
var currentStateGender = document.querySelector("#currentStateGender");

if(genderSubmit){
    genderSubmit.addEventListener('click', changeGender);
}

function changeGender(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeGender');
    var formData = new FormData(userGenderForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(!(genderInput.value === 'male') && !(genderInput.value === 'female')){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Value must be male or female!';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{

        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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
                    lableValueGender.innerHTML = genderInput.value;
                    currentStateGender.innerHTML = genderInput.value;
                }
            };
            xhr.send(formData);
        },500);

    }
}

// CHANGE gender
// this is in modal
var birthdayInput = document.querySelector("#birthday");
var userBirthdayForm = document.querySelector("#userBirthdayForm");
var birthdaySubmit = document.querySelector("#birthdaySubmit");
//this is in general settings
var lableValueBirthday = document.querySelector("#lableValueBirthday");
var currentStateBirthday = document.querySelector("#currentStateBirthday");

if(birthdaySubmit){
    birthdaySubmit.addEventListener('click', changeBirthday);
}

function changeBirthday(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeBirthday');
    var formData = new FormData(userBirthdayForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    setTimeout(function(){
        xhr.onload = function() {

            statusBox.innerHTML = '';
            statusBox.style.display = 'block';

            var res = JSON.parse(this.responseText);
            if(res.denied){
                var p = document.createElement('p');
                p.innerHTML = res.denied;
                img.src = denied;
                statusBox.appendChild(img);
                statusBox.appendChild(p);
            }
            else if(res.errors){
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
                lableValueBirthday.innerHTML = birthdayInput.value;
                currentStateBirthday.innerHTML = birthdayInput.value;
            }
        };
        xhr.send(formData);
    },500);
}

// CHANGE Contry
    // this is in modal
var countryInput = document.querySelector("#country");
var userCountryForm = document.querySelector("#userCountryForm");
var countrySubmit = document.querySelector("#countrySubmit");
    //this is in general settings
var lableValueCountry = document.querySelector("#lableValueCountry");
var currentStateCountry = document.querySelector("#currentStateCountry");

if(countrySubmit){
    countrySubmit.addEventListener('click', changeCountry);
}

function changeCountry(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeCountry');
    var formData = new FormData(userCountryForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    setTimeout(function(){
        xhr.onload = function() {

            statusBox.innerHTML = '';
            statusBox.style.display = 'block';

            var res = JSON.parse(this.responseText);
            if(res.denied){
                var p = document.createElement('p');
                p.innerHTML = res.denied;
                img.src = denied;
                statusBox.appendChild(img);
                statusBox.appendChild(p);
            }
            else if(res.errors){
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
                lableValueCountry.innerHTML = countryInput.options[countryInput.value].text;
                currentStateCountry.innerHTML = countryInput.options[countryInput.value].text;
            }
        };
        xhr.send(formData);
    },500);

}

// CHANGE Mobile Number
    // this is in modal
var mobileNumberInput = document.querySelector("#mobileNumber");
var userMobileNumberForm = document.querySelector("#userMobileNumberForm");
var mobileNumberSubmit = document.querySelector("#mobileNumberSubmit");
    //this is in general settings
var lableValueMobileNumber = document.querySelector("#lableValueMobileNumber");

if(mobileNumberSubmit){
    mobileNumberSubmit.addEventListener('click', changeMobileNumber);
}
function changeMobileNumber(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeMobileNumber');
    var formData = new FormData(userMobileNumberForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(mobileNumberInput.value.length > 20 || mobileNumberInput.value.length === 0){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Length Limit, cannot be empty or more than 20 digits!';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{

        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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
                    lableValueMobileNumber.innerHTML = mobileNumberInput.value;
                }
            };
            xhr.send(formData);
        },500);

    }
}

// CHANGE user Skype name
    // this is in modal
var skypeNameInput = document.querySelector("#skypeName");
var userSkypeForm = document.querySelector("#userSkypeForm");
var skypeSubmit = document.querySelector("#skypeSubmit");
    //this is in general settings
var lableValueSkype = document.querySelector("#lableValueSkype");

if(skypeSubmit){
    skypeSubmit.addEventListener('click', changeSkypeName);
}
function changeSkypeName(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeSkypeName');
    var formData = new FormData(userSkypeForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(skypeNameInput.value.length > 40 || skypeNameInput.value.length === 0){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Length Limit, cannot be empty or more than 40 digits!';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{

        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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
                    lableValueSkype.innerHTML = skypeNameInput.value;
                }
            };
            xhr.send(formData);
        },500);

    }
}

// CHANGE user website
// this is in modal
var webAddresInput = document.querySelector("#webAddres");
var userWebsiteForm = document.querySelector("#userWebsiteForm");
var websiteSubmit = document.querySelector("#websiteSubmit");
//this is in general settings
var lableValueWebsite = document.querySelector("#lableValueWebsite");

if(websiteSubmit){
    websiteSubmit.addEventListener('click', changeWebsite);
}
function changeWebsite(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeWebsite');
    var formData = new FormData(userWebsiteForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(webAddresInput.value.length > 40 || webAddresInput.value.length === 0){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Length Limit, cannot be empty or more than 40 digits!';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{

        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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
                    lableValueWebsite.innerHTML = webAddresInput.value;
                }
            };
            xhr.send(formData);
        },500);

    }
}

// CHANGE user email / login
    // this is in modal
var emailInput = document.querySelector("#email");
var emailPasswordInput = document.querySelector("#emailPassword");
var changeUserEmailForm = document.querySelector("#changeUserEmailForm");

var emailChangeSubmit = document.querySelector("#emailChangeSubmit");
    //this is in general settings
var labelValueEmail = document.querySelector("#labelValueEmail");
var currentStateEmail = document.querySelector("#currentStateEmail");

if(emailChangeSubmit){
    emailChangeSubmit.addEventListener('click', changeUserEmail);
}
function changeUserEmail(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changeEmail');
    var formData = new FormData(changeUserEmailForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(!validateEmail(emailInput.value)){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML =emailInput.value + ' is not valid email!!!';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else if(emailPasswordInput.value.length > 40 || emailInput.value.length < 2){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'Password cannot be empty or less than 2 symbols, max 40';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{

        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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
                    labelValueEmail.innerHTML = emailInput.value;
                    currentStateEmail.innerHTML = emailInput.value;
                }
            };
            xhr.send(formData);
        },500);

    }
}

// CHANGE user Password
// this is in modal
var oldPassInput = document.querySelector("#oldPass");
var newPassInput = document.querySelector("#newPass");
var newPassValidInput = document.querySelector("#newPassValid");

var changeUserPassForm = document.querySelector("#changeUserPassForm");

var changePasswordSubmit = document.querySelector("#changePasswordSubmit");

if(changePasswordSubmit){
    changePasswordSubmit.addEventListener('click', changeUserPassword);
}
function changeUserPassword(e){
    e.preventDefault();

    statusBox.innerHTML = '';
    statusBox.style.display = 'block';

    // xhr request + formdata
    var xhr = new XMLHttpRequest();
    xhr.open('post', url_root + '/user/changePassword');
    var formData = new FormData(changeUserPassForm);

    // loading gifs
    var img = document.createElement('img');
    img.src = loading_gif_anim;
    img.classList.add('img_100');
    statusBox.appendChild(img);

    if(!oldPassInput.value.length < 3 && oldPassInput.value.length > 40){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML ='Old Password min 3 char max 40 char';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    if(!newPassInput.value.length < 3 && newPassInput.value.length > 40){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML ='New Password min 3 char max 40 char';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    if(!newPassValidInput.value.length < 3 && newPassValidInput.value.length > 40){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML = 'New Password Confirm min 3 char max 40 char';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    if(newPassInput.value !== newPassValidInput.value){
        statusBox.innerHTML = '';
        statusBox.style.display = 'block';
        var p = document.createElement('p');
        p.innerHTML ='New Passwords do not match with password confirm';
        img.src = attention;
        statusBox.appendChild(img);
        statusBox.appendChild(p);
    }
    else{

        setTimeout(function(){
            xhr.onload = function() {

                statusBox.innerHTML = '';
                statusBox.style.display = 'block';

                var res = JSON.parse(this.responseText);
                if(res.denied){
                    var p = document.createElement('p');
                    p.innerHTML = res.denied;
                    img.src = denied;
                    statusBox.appendChild(img);
                    statusBox.appendChild(p);
                }
                else if(res.errors){
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
            xhr.send(formData);
        },500);

    }
}

// prevent enter submit for forms
function stopRKey(evt) {
    var evt = (evt) ? evt : ((event) ? event : null);
    var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
    if ((evt.keyCode == 13) && (node.type=="number"))  {return false;}
}

document.onkeypress = stopRKey;

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}