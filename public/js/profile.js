//    fetch data in div called show comments
   $('.show_comments').on('click',function(e){

        const post_id=e.target.id;
        // alert(post_id);
        get_post_comments(post_id);

        });




        // save comment to database
        $('.add_comment_buttons').on('submit',function(e){
            
            e.preventDefault();
            const post_id=$(this).attr('data-postId');
            const user_id=$(this).attr('data-userId');
            const save_button=$('#add_comment_btn'+post_id);
            save_button.html('saving  <i class="fas fa-spinner fa-spin"></i>');
           
            
             $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
              });
              
            
            
            $.ajax({
                
                method: 'POST',
                
                url: '/comments/'+ user_id+'/'+post_id,
                data:{
                    'comment_body':$('.comment_body').val()
                },
                dataType:'json',
                  
                success:  (response)=> {

                    if(response.status=="success"){
                        $('#success_message'+post_id).removeClass('visually-hidden');
                        $('.comments_body').val("");
                        save_button.html('save');

                    }
                    
        
                }
            , error: function (reject) {

                if (reject.status===422){
                    save_button.html('save');
                    $('#success_message'+post_id).addClass('visually-hidden');

                    const message= reject.responseJSON?reject.responseJSON.errors? reject.responseJSON.errors.comment_body?reject.responseJSON.errors.comment_body[0]:'':'':'';

                    $('#comment_error'+post_id).text(message);

                  
                }
                }
            });
           



        });
                //  End save comment to database


    
// function to get data

function get_post_comments(post_id){

    $.ajax({
        method: 'GET',
        enctype: 'multipart/form-data',
        url: '/comments/'+post_id,
        success:  (response)=> {

            $('#post_comments'+post_id).html(response);
            $('#post_comments'+post_id).toggle();


            

        }
    , error: function (error) {
            alert('some thing else occured');
        }
    });

    //   End function to get data

   


}
