//    fetch data in div called show comments
$(document).ready(function()
{

        // 1 show post comments

    $('.show_comments').on('click',function(e)
    {
        const post_id=e.target.id;
        // split the post id from div id
        let post_number = post_id.slice(13);
        // get_post_comments(post_number);
        $('#post_comments'+post_number).toggle();


        });


        //2 show form for add comment
        $('.show_comment_form').on('click',function(e){
            const post_id=e.target.id;
            let post_number = post_id.slice(17);

            $('#div_comment_form'+post_number).toggle();

        });



        // 3 add comment to database
        $('.add_comment').on('submit',function(e){

            e.preventDefault();
            const post_id=$(this).attr('data-postId');


            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });



            $.ajax({

                method: 'POST',

                url: '/comments',
                data:{
                    'comment':$('#comment_input'+post_id).val(),
                    'post_id':post_id
                },
                dataType:'json',

                success:  (response)=> {
                    $('#comment_input'+post_id).val('');
                    // show success message for 5 seconds
                    $('#success_message'+post_id).removeClass('visually-hidden');
                    setTimeout(function(){
                        $('#success_message'+post_id).hide();// or fade, css display however you'd like.
                     }, 5000);

                     get_post_comments(post_id);
                     location.reload();



                    if(response.status=="success")
                    {


                    }


                }
            , error: function (reject) {
                console.log(reject);

                if (reject.status===422){
                    // save_button.html('save');
                    $('#success_message'+post_id).addClass('visually-hidden');
                    // show error message for 5 seconds
                    const message= reject.responseJSON?reject.responseJSON.errors? reject.responseJSON.errors.comment?reject.responseJSON.errors.comment[0]:'':'':'';

                    $('#comment_error'+post_id).text(message);
                    setTimeout(function(){
                        $('#comment_error'+post_id).hide();// or fade, css display however you'd like.
                     }, 5000);


                }
                }
            });
        });

             // 4 show form for edit comment
        $('.commentsEdit').on('click',function(){


            const comment_id=$(this).data("commentId");
            const post_id=$(this).data("postId");
                $('#div_comment_form'+post_id+'-'+comment_id).toggle();


            } );
            // 5 update comment
            $('.update_comment_form').on('submit',function(e){

                e.preventDefault();
                const post_id=$(this).data('postId');
                const comment_id=$(this).data('commentId');



                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });



                $.ajax({

                    method: 'PATCH',

                    url: '/comments/'+comment_id,
                    data:{
                        'comment_edit':$('#updated_comment'+post_id+'-'+comment_id).val(),

                        'comment_id':comment_id,
                    },
                    dataType:'json',

                    success:  (response)=> {
                        console.log(response);
                        $('#updated_comment'+post_id+'-'+comment_id).val('');
                        location.reload();
                        // show success message for 5 seconds
                        $('#success_message'+post_id).removeClass('visually-hidden');
                        setTimeout(function(){
                            $('#success_message'+post_id).hide();// or fade, css display however you'd like.
                         }, 5000);







                    }
                , error: function (reject) {

                    if (reject.status===422){
                        // save_button.html('save');
                        $('#success_message'+post_id).addClass('visually-hidden');
                        // show error message for 5 seconds
                        const message= reject.responseJSON?reject.responseJSON.errors? reject.responseJSON.errors.comment?reject.responseJSON.errors.comment[0]:'':'':'';

                        $('#comment_error'+post_id).text(message);
                        setTimeout(function(){
                            $('#comment_error'+post_id).hide();// or fade, css display however you'd like.
                         }, 5000);


                    }
                    }
                });
            });










            //  End save comment to database



// function to get data

function get_post_comments(comment){

$.ajax({
    method: 'GET',
    enctype: 'multipart/form-data',
    url: '/comments/'+comment,
    success:  (response)=> {

        $('#post_comments'+comment).html(response);
        $('#post_comments'+comment).toggle();




    }
, error: function (error) {
        // alert('some thing else occured');
    }
});

//   End function to get data

}

});

