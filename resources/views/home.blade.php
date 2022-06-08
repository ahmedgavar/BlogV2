@extends('layouts.app')
@section('right_list')
{{-- profile --}}
<a class="dropdown-item" href="{{ route('Profile.index') }}"><i class="fa fa-btn fa-user"></i>

    {{ __('Profile') }}
</a>
@endsection

{{-- section for show profile in login list --}}
@section('list_items')
<a href="/Profile" class="profile_link"><h4>Profile</h4> </a>

@endsection

@section('content')

<link href="{{ asset('css/home-style.css') }}" rel="stylesheet">

{{-- show success message when creating post --}}
@if (session('status'))
    <div class="alert alert-success" id="success_create_update_msg">
        {{ session('status') }}
    </div>
@endif
@if (session('delete'))
    <div class="alert alert-danger" id="success_delete_msg">
        {{ session('delete') }}
    </div>
@endif
{{-- End show success message when creating post --}}



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Latest Posts') }}

                     @auth

                    <button
                        type="button"
                        id="create_post_link"
                        class="btn btn-primary crud_action"
                         data-bs-toggle="modal"
                         data-bs-target="#createPostModal"
                         data-action="create"
                         >create Post

                    </button>
                    @endauth



                </div>

                <div class="card-body">

                    <!-- Start  show my posts -->

                    @forelse ($posts as $post)

                            <div class="container post_card">
                                @if($loop->even)


                                    <div class="card posts_div" style="background-color: #f77f7a;margin-top: 20px">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$post->title}}</h5>
                                            <p class="card-text">{{Str::limit ($post->content,180)}}</p>
                                        </div>
                                    </div>

                                @else
                                    <div class="card posts_div" style="background-color: #8b4;">
                                        <div class="card-body">
                                             <h5 class="card-title">{{$post->title}}</h5>
                                             <p class="card-text">{{Str::limit ($post->content,180)}}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @auth
                             <div  id="post_info">
                                <span class="badge bg-secondary">{{$post->created_at->diffForHumans()}}</span>
                                <span class="badge bg-info">{{$post->user->name}}</span>
                                <span class="show_comment_form" id="show_comment_form{{ $post->id }}" style="cursor: pointer;">comment</span>
                                <span>
                                    <a class="btn btn-primary btn-sm" href="{{route('posts.show',$post->slug)}}" >View</a>
                                    <button

                                        data-bs-toggle="modal"
                                        class="btn btn-primary btn-sm crud_action"
                                        data-bs-target="#editPostModal"
                                        data-id="{{$post->id}}"
                                        data-title="{{$post->title}}"
                                        data-content="{{$post->content}}"

                                            >Edit
                                    </button>
                                    <button
                                        class="btn btn-danger btn-sm deleteBtn crud_action"
                                        style="margin: 0px;"
                                        data-bs-toggle="modal"

                                        data-bs-target="#deleteModal"
                                        data-delete_id="{{$post->id}}"


                                        >Delete
                                    </button>
                                </span>

                              </div>


                                {{-- add comment --}}

                                {{-- success message --}}

                                <div class="alert alert-success visually-hidden" id="success_message{{$post->id}}">
                                    Comment saved successfully
                                </div>

                                {{-- End success message --}}

                                <h4 id="show_comment_{{ $post->id }}" class="show_comments"
                                    style="padding: 20px 10px;cursor: pointer;">Comments
                                </h4>
                                <div id="post_comments{{$post->id}}">

                                   {{-- here all comments are shown --}}

                                </div>

                                <div  id="div_comment_form{{ $post->id }}" style="display: none">

                                    <form  class="add_comment" method="POST"
                                        data-postId="{{$post->id}}">
                                        @csrf
                                        <div style="margin-left: 50px">

                                            <textarea style="text-align: center" name="comment" id="comment_input{{ $post->id }}" cols="60" rows="3" placeholder="add your comment"></textarea>
                                            <button  style="margin: 20px 150px" type="submit" id="add_comment_btn{{$post->id}}">save</button>
                                            <div id="comment_error{{$post->id}}" class="text-danger"></div>
                                        </div>


                                    </form>
                                </div>



                            {{-- End form for adding comment --}}

                                {{-- End add comment --}}

                            @endauth
                            @guest
                                <div  id="post_info">
                                    <button class="btn btn-primary btn-sm">View</button>

                                </div>
                            @endguest



                        @empty
                            not posts yet
                    @endforelse



                </div>

                @include('posts.create')

                @include('posts.delete')
                @include('posts.edit')

            </div>



    </div>
                    {{-- End  show my posts --}}



</div>


@endsection


@section('modal_js')
<script src="{{asset('js/modal_data.js')}}"></script>
<script src="{{asset('js/add_comment.js')}}"></script>

@endsection



</div>




