

// $('.reactions').on('click',function(){


//     const _likeid=$(this).data('likeid');
//     const _button_type=$(this).data('type');


//     $.ajaxSetup({
//         headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//         }
//     });



//     $.ajax({

//         method: 'POST',

//         url: "{{ url('/likes') }}",
//         data:{
//             likeid:_likeid,
//             type:_button_type,
//         },
//         dataType:'json',

//         success:  (response)=> {
//             var _prev_count=$('.'+_button_type+'_count').text();
//             _prev_count++;
//             $('.'+_button_type+'_count').text(_prev_count)
//             // show success message for 5 seconds
//             $('#success_message'+post_id).removeClass('visually-hidden');
//             setTimeout(function(){
//                 $('#success_message'+post_id).hide();// or fade, css display however you'd like.
//              }, 5000);

//              get_post_comments(post_id);


//             if(response.status=="success")
//             {


//             }


//         }
//     , error: function (reject) {
//         console.log(reject);

//         if (reject.status===422){
//             // save_button.html('save');
//             $('#success_message'+post_id).addClass('visually-hidden');
//             // show error message for 5 seconds
//             const message= reject.responseJSON?reject.responseJSON.errors? reject.responseJSON.errors.comment?reject.responseJSON.errors.comment[0]:'':'':'';

//             $('#comment_error'+post_id).text(message);
//             setTimeout(function(){
//                 $('#comment_error'+post_id).hide();// or fade, css display however you'd like.
//              }, 5000);


//         }
//         }
//     });



// });
