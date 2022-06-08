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
    @if(session()->has('success'))
        <div class="alert-success profile_success"
             style="width: 60%;height: 100px;text-align: center;margin:auto">

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

            {{-- show post info --}}
    @forelse ($posts as $post  )
        <div class="card">
            <div class="card-body" style="margin-bottom: 50px">
                <h5 class="card-title">{{$post->title}}</h5>
                <p class="card-text">{!!$post->content!!}</p>



            </div>
            <div class="card-body">


                <h5 style="text-align: center">
                    <span class="badge badge-info" style="color: red;">{{$post->created_at->diffForHumans()}}</span>


                </h5>

            </div>

        </div>

        {{-- show cpost comments --}}

@forelse ($post->comments as $comments )
<div class="card" style="width: 70%; margin: 50px">
    <div class="card-body" >
        {{ $comments->comment }}

    </div>

  </div>



@empty
No comments for post

@endforelse()

    @empty
    No posts for {{ $user->name }}

    @endforelse
            {{-- End show post info --}}




@endsection





@section('list_items')

<a href="/" class="profile_link"><h4>Posts</h4> </a>

@endsection
<script>

setTimeout(function(){
        $('.profile_success').hide();// or fade, css display however you'd like.
                }, 5000);
</script>
