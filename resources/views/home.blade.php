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
@if (session('create_status'))
    <div class="alert alert-success" id="success_create_update_msg">
        {{ session('create_status') }}
    </div>
@endif
{{-- End show success message when creating post --}}

{{-- show success message when deleting post --}}


@if (session('delete_status'))
    <div class="alert alert-danger" id="success_delete_msg">
        {{ session('delete_status') }}
    </div>
@endif
{{-- End show success message when deleting post --}}

{{-- show success message when updating post --}}
@if (session('update_status'))
    <div class="alert alert-success" id="success_create_update_msg">
        {{ session('update_status') }}
    </div>
@endif

{{-- End show success message when updating post --}}



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
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

                            <div class="container post_card" style="margin-top: 30px">
                                @if($loop->even)


                                    <div class="card posts_div card text-white bg-primary" style="margin: 20px 0px">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$post->title}}</h5>
                                            <p class="card-text">{{Str::limit ($post->content,180)}}</p>
                                        </div>
                                    </div>

                                @else
                                    <div class="card posts_divcard text-white bg-secondary">
                                        <div class="card-body">
                                             <h5 class="card-title">{{$post->title}}</h5>
                                             <p class="card-text">{{Str::limit ($post->content,180)}}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
             {{-- show actions(delete and edit for the owner of post) --}}


                             <div  id="post_info">
                                {{-- 1   for all people permision [A :show owner of post
                                                                B :show time of creating post
                                                                c: view post
                                                                ]
                                 --}}
                                <span class="badge bg-secondary">{{$post->created_at->diffForHumans()}}
                                </span>
                                <span class="badge bg-info">{{$post->user->name}}
                                </span>
                                <span>
                                    <a class="btn btn-primary btn-sm" href="{{route('posts.show',$post->slug)}}" >View</a>
                                </span>
                                {{-- 2 for authinticated user [A : add comment
                                                                B: show comments
                                                                C: like
                                                                 ]
                                --}}
                            @auth


                                <span class="show_comment_form" id="show_comment_form{{ $post->id }}"
                                    style="cursor: pointer;">comment
                                </span>


                                <span id="show_comment_{{ $post->id }}" class="show_comments"
                                        style="cursor: pointer;">{{ $post->comments_count }}Comments
                                </span>





                                    {{-- 3 authenticated and authorized [A: edit and delete] --}}

                             @if ($post->user->id===auth::user()->id)
                                <span>


                                    <button

                                        data-bs-toggle="modal"
                                        class="btn btn-primary btn-sm crud_action"
                                        data-bs-target="#editPostModal"
                                        data-id="{{$post->id}}"
                                        data-title="{{$post->title}}"
                                        data-content="{{$post->content}}"

                                            >Edit
                                    </button>
                                </span>
                                <span>


                                    <button
                                        class="btn btn-danger btn-sm deleteBtn crud_action"
                                        style="margin: 0px;"
                                        data-bs-toggle="modal"

                                        data-bs-target="#deleteModal"
                                        data-delete_id="{{$post->id}}"


                                        >Delete
                                    </button>
                                </span>
                            @endif
                            <span>


                                <like-component
                                  @auth

                                :reactable_type=`posts/{{$post->id}}`
                                :summary='@json($post->reactionSummary())'
                                :reacted='@json($post->reacted())'

                                @endauth

                                >

                                </like-component>
                          </span>



                            @endauth

                        </div>



                                {{-- success message --}}

                                <div class="alert alert-success visually-hidden" id="success_message{{$post->id}}">
                                    Comment saved successfully
                                </div>

                                {{-- End success message --}}


                                <div id="post_comments{{$post->id}}" style="display: none">

                                   {{-- here all comments are shown --}}
                                   @forelse ($post->comments as $comment )
                                    <div class="card"
                                    style="margin-top: 50px">
                                        <div class="card-body"
                                            >
                                            {{ $comment->comment }}
                                            <br>
                                            <br>
                                        </div>
                                    </div>
                                {{-- start edit and delete of comment --}}


                                    {{-- comment who can edit and delete --}}
                                    {{-- comment owner can edit and delete --}}
                                    {{-- post owner which comment belong to can only delete --}}

                                    @auth

                                    @if ($comment->user_id===auth::user()->id)
                                        <button

                                            class="btn btn-primary btn-sm commentsEdit"

                                            data-post-id="{{$post->id}}"
                                            data-comment-id="{{ $comment->id }}"
                                            data-comment="{{$comment->comment}}"

                                            >Edit
                                        </button>
                                        <button
                                            class="btn btn-danger btn-sm deleteBtn crud_action"
                                            style="margin: 0px;"
                                            data-bs-toggle="modal"

                                            data-bs-target="#deleteCommentModal"
                                            data-delete_id="{{$post->id}}"


                                            >Delete
                                        </button>

                                    @elseif ($comment->post->user_id===auth::user()->id )
                                    <span>
                                        <button
                                            class="btn btn-danger btn-sm deleteBtn crud_action"
                                            style="margin: 0px;"
                                            data-bs-toggle="modal"

                                            data-bs-target="#deleteModal"
                                            data-delete_id="{{$post->id}}"


                                            >Delete
                                        </button>



                                    </span>

                                @endif
                                {{-- end edit and delete buttons of comment --}}

                                @endauth



                                        <like-component
                                          @auth

                                        :reactable_type=`comments/{{$comment->id}}`
                                        :summary='@json($comment->reactionSummary())'
                                        :reacted='@json($comment->reacted())'

                                        @endauth

                                        >

                                        </like-component>
                                  </span>
                                  {{-- comment edit div --}}
                                  <div
                                    class="form_edit"
                                    id="div_comment_form{{ $post->id }}-{{ $comment->id }}"
                                    style="display: none">

                                    <form  class="update_comment_form" method="POST"
                                        data-post-id="{{$post->id}}"
                                        data-comment-id="{{ $comment->id }}">
                                        @csrf
                                        <div style="margin-left: 50px">

                                            <textarea style="text-align: center" name="comment_edit"
                                                        id="updated_comment{{ $post->id }}-{{ $comment->id }}"
                                                        cols="60" rows="3"
                                                        placeholder="update your comment">
                                            </textarea>
                                            <button type="submit" id="update_comment_btn{{$post->id}}">save</button>
                                            <div id="comment_error{{$post->id}}" class="text-danger"></div>
                                        </div>


                                    </form>
                                </div>
                                  {{-- end comment edit div --}}

                                  @empty
                                  <div class="bg-warning p-4">
                                      No comments yet for this post
                                  </div>





                                   @endforelse





                                </div>
                                    {{-- form for add comment --}}

                                <div  id="div_comment_form{{ $post->id }}" style="display: none">

                                    <form  class="add_comment" method="POST"
                                        data-postId="{{$post->id}}">
                                        @csrf
                                        <div style="margin-left: 50px">

                                            <textarea style="text-align: center" name="comment" id="comment_input{{ $post->id }}" cols="60" rows="3" placeholder="add your comment"></textarea>
                                            <button type="submit" id="add_comment_btn{{$post->id}}">save</button>
                                            <div id="comment_error{{$post->id}}" class="text-danger"></div>
                                        </div>


                                    </form>
                                </div>



                            {{-- End form for adding comment --}}

                                {{-- End add comment --}}





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
<script src="{{asset('js/comment_modal.js')}}"></script>


<script src="{{asset('js/comment_actions.js')}}"></script>



@endsection



</div>




