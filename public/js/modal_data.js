$(document).ready(function() {
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
    
   
});