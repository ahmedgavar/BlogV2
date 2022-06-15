

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
        <div>
            <comment-like-component
            @auth

                :comment_id="{{$comment->id}}"
                :summary='@json($comment->reactionSummary())'
                :reacted='@json($comment->reacted())'

                @endauth



            >
            </comment-like-component>
        </div>
    @empty
    <div class="bg-warning p-4">
        No comments yet for this post
    </div>




    @endforelse

{{-- </div> --}}
</div>
