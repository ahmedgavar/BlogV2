$(document).ready(function() {

// first task change picture show


            // Multiple images preview with JavaScript

    $(function() {
        var multiImgPreview = function(input, imgPreviewPlaceholder) {
            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {

                        $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);

                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };

            //end  Multiple images preview with JavaScript
            // call this function for create modal

        $('#image_name').on('change', function() {
            // remove old images not to be shown
            $('div.imgPreview img').remove();
            multiImgPreview(this, 'div.imgPreview');
            // End call this function for create modal

        });
            //  call this function for edit modal

        $('#images_edit').on('change', function() {
            $('div.imgEditPreview img').remove();

            multiImgPreview(this, 'div.imgEditPreview');
            // End call this function for edit modal

        });

    });

// End first task change picture show

    // delete post
    $('#deleteModal').on('show.bs.modal',function(event){
        $('#editPostModal').hide();
        $('#createPostModal').hide();


        $(this).appendTo("body");


        var button=$(event.relatedTarget);

        var postDeleteId=button.data('delete_id');

       $('#delete_name').val(postDeleteId);


        } );

        // delete comment
        $('#deleteCommentModal').on('show.bs.modal',function(event){


            $(this).appendTo("body");



        var current_button=$(event.relatedTarget);
        // console.log(current_button);

        var comment_id=current_button.data('delete-com-id');

       $('#delete_comment').val(comment_id);

            } );

        // end delete comment


    $('#editPostModal').on('show.bs.modal',function(event){

        $('#deletePostModal').hide();
        $('#createPostModal').hide();

        // this following line solved problem gray background when opening modal
        $(this).appendTo("body");
        //  End solve gray background when opening modal

        var button=$(event.relatedTarget);
        var title=button.data('title');
        var content=button.data('content');
        var postEditId=button.data('id');

        $('#title_edit').val(title);
        $('#content_edit').val(content);
        $('#postId').val(postEditId);


    });
    $('#createPostModal').on('show.bs.modal',function(event){

        $('#deletePostModal').hide();
        $('#editPostModal').hide();



    });
    // show flash message on create and update
    setTimeout(function(){
        $('#success_create_update_msg').hide();// or fade, css display however you'd like.
     }, 5000);
    // show flash message on delete

     setTimeout(function(){
        $('#success_delete_msg').hide();// or fade, css display however you'd like.
     }, 5000);


});
