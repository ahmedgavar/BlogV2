<!-- Modal -->

<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Post </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

          <!-- modal content -->
        @isset($post)
          <form  enctype="multipart/form-data" method="POST" id="post_form"
            action="{{route('posts.update',$post->id)}}">
            @csrf
            @method('PATCH')
              <div class="modal-body my_large_model">

                <input type="hidden" name="postId" id="postId">
                <div class="input-group mb-3 form_div">
                  <h4>Title</h4>
                  <input type="text" name="title_edit" id="title_edit"  style="height: 50px;"  value="{{ old('title_edit') }}" class="@error('title_edit') is-invalid @enderror">
                <div>

                @error('title_edit') <span class="error text-danger">{{ $message }}</span> @enderror

                <div class="input-group mb-3 form_div">
                  <h4> Content</h4>
                  <textarea name="content_edit" id="content_edit" style="height: 100px;" class="@error('content_edit') is-invalid @enderror">{{ old('content_edit') }}</textarea>
                </div>

                @error('content_edit') <span class="error text-danger">{{ $message }}</span> @enderror

                    <!-- show post images -->
                    @foreach ($post->post_Images as $images )
                        <img src="{{asset('assets/posts_images_thumbs/'.$images->image_name)}}" id="preview_image" width="120" alt="">

                    @endforeach
                    <!-- End show post images -->



                 <div class="input-group mb-3 form_div">
                   <h4>upload image:</h4>
                   <input type="file" name="images_for_edit[]" id="images_edit" multiple  accept="image/*" class="@error('image_name_edit') is-invalid @enderror">


                  </div>

                @error('images_for_edit') <span class="error text-danger">{{ $message }}</span> @enderror

                    {{-- div for edit images --}}
                <div class="imgEditPreview">
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
      </form>
      @endisset
    </div>
  </div>
</div>


 <!-- Don't close modal if there are errors -->





