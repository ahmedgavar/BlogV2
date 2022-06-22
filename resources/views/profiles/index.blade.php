@extends('layouts.app')
   {{-- profile link --}}
@section('right_list')

    <a class="dropdown-item" href="/"><i class="fa fa-btn fa-user"></i>

        {{ __('Posts') }}
    </a>
@endsection
   {{-- End profile link --}}


@section('content')

    <link href="{{ asset('css/profile-style.css') }}" rel="stylesheet">
    {{-- success function --}}
    @if(session()->has('success'))
        <div class="alert-success profile_success">


            {{session()->get('success')}}
        </div>
    @endif

    <div class="container">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                {{----------------------- 1 profile photo and name and edit button ------------------------ --}}
                             {{-- set default photo if no photo --}}
                @if (!$user->profile->avatar)
                    <img  id="profile_image" src="{{ asset('assets/profile_images/default.jpg') }}"  alt="">

                @else
                <img  id="profile_image" src="{{ asset('assets/profile_images/'.$user->profile->avatar) }}"  alt="">

                @endif
                        {{-- End set default photo if no photo --}}


                <h2 id="profile_owner">{{ $user->name }} Profile</h2>
                <a href="{{ route('Profile.edit',[Auth::user()->id]) }}"
                    class="btn btn-success"
                    style="float: right;">
                    Edit Profile
                </a>


            </div>
        </div>
                {{----------------------- 1 End  profile photo and name ------------------------ --}}


                {{--============= 2 show posts [content and title and time] -----------------------}}
            @forelse ($posts as $post  )
                <div class="container">
                    <div class="card post_div" >
                        <div class="card-body" >
                            <h5 id="post_title" class="card-title">{{$post->title}}</h5>
                                <br> <br>
                            <p class="card-text">{!!$post->content!!}</p>

                        </div>


                    </div>
                    <h5 id="post_info_div">
                        <span class="badge badge-info" id="post_time">{{$post->created_at->diffForHumans()}}</span>
                        <span class="badge badge-info" id="post_owner">{{$post->user->name}}</span>


                    </h5>
                    <h3>Images</h3>
                    <br><br>


                        {{--============= 2 End show posts [content and title and time] -----------------------}}



                </div>

                        {{--============= 3  show post images as gallary-----------------------}}
                        {{--  check if there are images not to make big empty div --}}
                 @if (count( $post->post_images))

                    <section class="gallery min-vh-100">
                        <div class="container-lg">
                           <div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3">
                                @foreach ($post->post_images as $images )

                                    <div class="col">
                                        <img class="gallery-item"

                                        src="{{asset('assets/posts_images_thumbs/'. $images->image_path.'/'.$images->image_name.'.'.$images->image_extension)}}">


                                    </div>

                                @endforeach

                           </div>
                        </div>
                     </section>
                     @else
                     <p>No Images for this post</p>
                 @endif


                   <!-- Modal -->
                   <div class="modal fade" id="gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered modal-lg">
                       <div class="modal-content">
                         <div class="modal-header">
                           <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body">
                            <img src="img/1.jpg" class="modal-img" alt="modal img">
                         </div>
                       </div>
                     </div>
                   </div>


                        {{--============= 3  End show post images as gallary-----------------------}}




                <h3>comments</h3>


                        {{--============= 3  End show post images  -----------------------}}



                        {{--============= 4  show post comments [content and time and owner] -----------------------}}

                @forelse ($post->comments as $comments )
                    <div class="container">
                        <div class="card comments_div" >
                            <div class="card-body" >
                                {{ $comments->comment }}

                            </div>

                        </div>
                        <h5 id="comment_info_div">
                            <span class="badge badge-info" id="comment_time">{{$comments->created_at->diffForHumans()}}</span>
                            <span class="badge badge-info" id="comment_owner">{{$comments->user->name}}</span>


                        </h5>


                    </div>


                @empty
                    No comments for post

                @endforelse()

            @empty
            No posts for {{ $user->name }}

            @endforelse
                        {{--============= 4  Endshow post comments [content and time and owner] -----------------------}}
                    </div>



@endsection





@section('list_items')

<a href="/" class="profile_link"><h4>Posts</h4> </a>

@endsection
<script>
// hide suvvess message after 5 seconds
setTimeout(function(){
        $('.profile_success').hide();
                }, 5000);

// show gallary

 document.addEventListener("click",function (e){
   if(e.target.classList.contains("gallery-item")){
   	  const src = e.target.getAttribute("src");
   	  document.querySelector(".modal-img").src = src;
   	  const myModal = new bootstrap.Modal(document.getElementById('gallery-modal'));
   	  myModal.show();
   }
 })
</script>

