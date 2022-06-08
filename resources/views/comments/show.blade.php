
{{-- <div id="post_comments{{$post->id}}" style="display: none;" > --}}

<div class="container" >

    @forelse($comments as $comment )

            <div class="card">
                <div class="card-body">
                    {{ $comment->comment }}
                </div>
              </div>



        <div style="margin: 20px 0px 20px 200px">
            <span class="badge bg-info">{{$comment->created_at->diffForHumans()}}</span>
            <span class="badge bg-primary" style="margin-left: 15px">{{$comment->user->name}}</span>



        </div>
    @empty
    <div class="bg-warning p-4">
        No comments yet for this post
    </div>



    @endforelse
{{-- </div> --}}
</div>
