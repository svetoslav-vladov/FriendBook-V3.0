// $(document).ready(function () {
//     $('#share-photos-form').on('submit', function(e) {
//         e.preventDefault();
//
//         $.ajax({
//             url: url_root + "post/sharePhoto",
//             type: "POST",
//             data: new FormData(this),
//             contentType: false,
//             cache: false,
//             processData: false,
//             success: function(data) {
//                 console.log(JSON.parse(data));
//                 console.log(data);
//                 $('#validatedCustomFile').val('')
//             }
//         });
//     });
// });