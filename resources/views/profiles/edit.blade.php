@extends('layouts.app')
@section('content')
<link href="{{ asset('css/profile-style.css') }}" rel="stylesheet">

<div class="container">

    
    <div class="row">
        <form action="{{ route('Profile.update',[Auth::user()->id]) }}" method="post" enctype="multipart/form-data">
            <h3 id="form_title">Update  profile </h3>
            @method('put')
            @csrf

            <div class="all_form">
                <div class="one_row" >
                    <div>
                        <label for="First Name">First Name</label>
                        <input type="text" name="first_name">

                    </div>
                    @error('first_name') <span class="error text-danger">{{ $message }}</span> @enderror

                    <div>
                        <label for="last Name">Last Name</label>
                        <input type="text" name="last_name">

                    </div>
                    @error('last_name') <span class="error text-danger">{{ $message }}</span> @enderror


                </div>

                <div class="one_row" >
                    <div id="textarea_">
                        <label id="text_area_label" for="user_description">user Info </label>
                        <textarea name="about" id="user_description" cols="80" rows="5"></textarea>

                    </div>
                    @error('about') <span class="error text-danger">{{ $message }}</span> @enderror



                </div>
                <div class="one_row" >
                    <div>
                        <label for="country">Country </label>
                        <input type="text" name="country">
                    </div>
                    <div>
                        <label for="city ">City </label>
                        <input type="text" name="city">
                    </div>

                </div>



            </div>
            <div class="custom-file">
                <input type="file" name="avatar" class="custom-file-input" id="chooseFile">
                <label class="custom-file-label" for="chooseFile">Select file</label>
            </div>
            @error('avatar') <span class="error text-danger">{{ $message }}</span> @enderror

            <button type="submit" id="update_profile_btn" class="btn btn-outline-danger btn-block mt-4">
                change
            </button>
        </form>

    </div>
</div>

@endsection
