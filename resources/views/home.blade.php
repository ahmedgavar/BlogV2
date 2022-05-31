@extends('layouts.app')

@section('content')

<!-- show success message when creating post -->
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if (session('delete'))
    <div class="alert alert-danger">
        {{ session('delete') }}
    </div>
@endif
<!-- End show success message when creating post -->
<link href="{{ asset('posts-styles/home-style.css') }}" rel="stylesheet">


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Latest Posts') }}

                    <button type="button" id="create_post_link" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPostModal">create Post</button>
                    
                </div>

                <div class="card-body">

                <!-- Start  show my posts -->
                
                        @foreach ($posts as $post)
                            @empty($post)
                            <strong>No posts Found</strong>

                            @endempty
                        
                            @isset($post)

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
                                            class="btn btn-primary btn-sm"
                                            data-bs-target="#editPostModal"
                                            data-id="{{$post->id}}"

                                            data-title="{{$post->title}}"
                                            data-content="{{$post->content}}"

                                            >Edit
                                        </button>
                                        <button
                                            class="btn btn-danger btn-sm deleteBtn" 
                                            style="margin: 0px;"
                                            data-bs-toggle="modal"

                                            data-bs-target="#deleteModal"

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

                    @endisset

                    
                                
                        @endforeach
                    
                        <!-- End  show my posts -->


                    
                </div>
            </div>
        </div>
    </div>
    @include('posts.create')

@include('posts.delete')
    
@include('posts.edit')





@stop

@section('modals_js')
<script src="{{asset('js/modal_data.js')}}"></script>

@stop