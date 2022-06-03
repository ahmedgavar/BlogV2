@extends('layouts.app')

@section('content')

<link href="{{ asset('posts-styles/home-style.css') }}" rel="stylesheet">

<!-- show success message when creating post -->
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
<!-- End show success message when creating post -->


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Latest Posts') }}

                    <button
                        type="button" 
                        id="create_post_link" 
                        class="btn btn-primary crud_action"
                         data-bs-toggle="modal" 
                         data-bs-target="#createPostModal"
                         data-action="create"
                         >create Post

                    </button>
                   
                    
                </div>

                <div class="card-body">

                    <!-- Start  show my posts -->
            
                    @forelse ($posts as $post)
                        
                            <div class="container post_card">
                                @if($loop->even)


                                    <div class="card posts_div" style="background-color: #f77f7a;">
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
                                <span id="comment">comment</span>
                                <span>
                                    <a class="btn btn-primary btn-sm" href="{{route('posts.show',$post->id)}}" >View</a>
                                    <button
                                            
                                        data-bs-toggle="modal"
                                        class="btn btn-primary btn-sm crud_action"
                                        data-bs-target="#editPostModal"
                                        data-id="{{$post->id}}"
                                        data-action="update"
                                        data-title="{{$post->title}}"
                                        data-content="{{$post->content}}"

                                            >Edit
                                    </button>
                                    <button
                                        class="btn btn-danger btn-sm deleteBtn crud_action" 
                                        style="margin: 0px;"
                                        data-bs-toggle="modal"

                                        data-bs-target="#deleteModal"
                                        data-action="delete"
                                        data-delete_id="{{$post->id}}"


                                        >Delete
                                    </button>
                                </span>
                        
                              </div>
                            @endauth
                            @guest
                                <div  id="post_info">
                                    <button class="btn btn-primary btn-sm">View</button>
                                        
                                </div>
                            @endguest

                        @empty
                            not posts yet
                    @endforelse
                    
                    
                    <!-- End  show my posts -->
                    
                </div>

               
                    
            </div>
            
        </div>
    </div>
</div>
@include('posts.create')

@stop
@section('modal_js')
    
<script src="{{asset('js/modal_data.js')}}"></script>


@stop



    



