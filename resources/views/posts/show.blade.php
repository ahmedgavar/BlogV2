@extends('layouts.app')
@section('content')


<div class="container">
    <div class="title" style="text-align: center;margin: 50px 0px;">

        <h1 style="color: red">{{ $post->title }}</h1>

    </div>



{{-- show images --}}
<div style="margin-bottom: 50px">
<h3 style="margin:20px 50px">Images</h3>

@foreach ($post->post_Images as $images )

<img src="{{asset('assets/posts_images/'. $images->image_name)}} " alt=" no images"  height="200px" style="margin:20px 0px 10px 70px">


@endforeach


</div>
<h3>{{ $post->content }}</h3>

</div>


@stop
