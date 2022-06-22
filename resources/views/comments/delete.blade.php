
<!-- Modal -->
<div class="modal fade my_large_model" id="deleteCommentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Comment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @isset($comment)
          <form action="{{route('comments.destroy',$comment->id)}}" method="POST">
          @method('DELETE')
          @csrf
             <div class="modal-body">
                <h5> Are you sure you want to delete this comment . you cannot recover comment if you delete it</h5>

                <input type="hidden" name="delete_comment" id="delete_comment">

              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
              </div>
          </form>
          @endisset


      </div>
    </div>
  </div>
