<!-- Modal -->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Post </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  
        enctype="multipart/form-data"
        method="POST"
        id="post_form"
        action="{{route('posts.store')}}">
        @csrf
        <div class="modal-body my_large_model">
     
              <!-- modal content -->
          
          <div class="input-group mb-3 form_div">
            <h4>Title</h4>
            <input type="text" name="title" value="{{ old('title') }}" style="height: 50px;" class="@error('title') is-invalid @enderror">
          <div>
                              
          @error('title') <span class="error text-danger">{{ $message }}</span> @enderror



            <!-- post content -->
          <div class="input-group mb-3 form_div">
            <h4> Content</h4>
            <textarea name="content" style="height: 100px;" class="@error('content') is-invalid @enderror">{{ old('content') }}</textarea>
          </div>
             
          @error('content') <span class="error text-danger">{{ $message }}</span> @enderror

            <!-- post image -->
              
          <div class="input-group mb-3 form_div">
            <h4>upload image:</h4>
            <input type="file" name="images[]" id="image_name"  multiple accept="image/*"  
            
                class="@error('images') is-invalid @enderror">
            

          </div>
             
          @error('images') <span class="error text-danger">{{ $message }}</span> @enderror
          <div class="imgPreview">
             </div>

          <!-- <img src="" id="preview_image" width="120" alt=""> -->
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>

    </div>
  </div>
</div>
  <!-- @section('model_changes')

  @if (count($errors) > 0)
      <script>
          $( document ).ready(function() {
              $('#createPostModal').modal('show');
          });
      </script>
  @endif
  <!--  show image after submit  -->
  <script>
        // $(function() {
        //   // Multiple images preview with JavaScript
        //   var multiImgPreview = function(input, imgPreviewPlaceholder) {
        //       if (input.files) {
        //           var filesAmount = input.files.length;
        //           for (i = 0; i < filesAmount; i++) {
        //               var reader = new FileReader();
        //               reader.onload = function(event) {
        //                   $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
        //               }
        //               reader.readAsDataURL(input.files[i]);
        //           }
        //       }
        //   };
        //   $('#image_name').on('change', function() {
        //       multiImgPreview(this, 'div.imgPreview');
        //   });
        //   });  

  </script>
  @stop

  @section('modals_js')
  <script src="{{asset('js/modal_data.js')}}"></script>

  @stop --> -->
