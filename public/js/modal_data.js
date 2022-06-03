$(document).ready(function() {

// first task change picture show
    // Multiple images preview with JavaScript

    $(function() {
        // Multiple images preview with JavaScript
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

// End first task change picture show
    //end  Multiple images preview with JavaScript


        $('#image_name').on('change', function() {
            multiImgPreview(this, 'div.imgPreview');
        });
        });  
    $('#deleteModal').on('show.bs.modal',function(event){
        var button=$(event.relatedTarget);
        
        var postDeleteId=button.data('delete_id');
    
       $('#delete_name').val(postDeleteId);
        
    
        } );
    $('#editPostModal').on('show.bs.modal',function(event){
    var button=$(event.relatedTarget);
    var title=button.data('title');
    var content=button.data('content');
    var postEditId=button.data('id');

    $('#title_edit').val(title);
    $('#content_edit').val(content);
    $('#postId').val(postEditId);
    

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