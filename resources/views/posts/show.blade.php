@extends('layouts.app')
@section('content')



        <div class="title" style="text-align: center;margin: 50px 0px;">

            <h1 style="color: red">{{ $post->title }}</h1>

        </div>





            {{-- show images --}}
        <div style="margin-bottom: 50px">
            <h3 style="margin:20px 50px">Images</h3>

            @forelse ( $post->post_Images as $images )
                <img src="{{asset('assets/posts_images/'. $images->image_name)}} " alt=" no images"  height="200px" style="margin:20px 0px 10px 70px">


            @empty
            <h3> No images for this post</h3>



            @endforelse

            <div class="title" style="text-align: center;margin: 50px 0px;">

                <h1 style="color: red">{{ $post->content }}</h1>

            </div>

        </div>
            {{-- End show images --}}

            {{-- show post comments --}}
            <div>


                @forelse ($post->comments as $comments )

                    <div class="card" style="width: 70%; margin: 50px">
                        <div class="card-body" >
                            {{ $comments->comment }}

                        </div>

                      </div>

                      <div style="text-align: center">

                                <span class="badge bg-secondary">{{$post->created_at->diffForHumans()}}</span>
                                <span class="badge bg-info">{{$post->user->name}}</span>

                      </div>


                @empty
                      <h3> No Comments yet</h3>


                @endforelse



            </div>

            {{--End show post comments --}}





@stop
