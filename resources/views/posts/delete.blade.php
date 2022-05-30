
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5> Are you sure you want to delete this post . If you delete this post all comments will be deleted</h5>
        @isset($post)
        <form action="{{route('posts.destroy',$post->id)}}" method="POST">
        <input type="hidden" name="delete_name" id="delete_name">

        @method('DELETE')

            @csrf

      </div>
      @endisset
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Delete</button>
      </div>
      </form>

    </div>
  </div>
</div>
