@extends('layouts.app')
@section('right_list')
{{-- profile --}}
<a class="dropdown-item" href="/"><i class="fa fa-btn fa-user"></i>

    {{ __('Posts') }}
</a>
@endsection

@section('content')
<link href="{{ asset('css/profile-style.css') }}" rel="stylesheet">
@if(session()->has('success'))
    <div class="alert-success">
        {{session()->get('success')}}
    </div>
@endif

<div class="container">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <img  id="profile_image" src="{{ asset('assets/profile_images/'.$user->profile->avatar) }}"  alt="">
            <h2 id="profile_owner">{{ $user->name }} Profile</h2>
            <a href="{{ route('Profile.edit',[Auth::user()->id]) }}"
                class="btn btn-success"
                style="float: right;">
                Edit Profile
            </a>


        </div>
    </div>
</div>


@foreach ($posts as $post)

<div class="container">

    <div class="card" id="post_details" data-post_id="{{$post->id}}">
        <div class="card-body">
            <h5 class="card-title">{{$post->title}}</h5>
            <p class="card-text">{!!$post->content!!}</p>
            <h5>
                <span class="badge badge-info">{{$post->created_at->diffForHumans()}}</span>
            </h5>


        </div>



    </div>



</div>




@endforeach

@endsection





@section('list_items')

<a href="/" class="profile_link"><h4>Posts</h4> </a>

@endsection
