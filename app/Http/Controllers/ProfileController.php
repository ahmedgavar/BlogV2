<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Image as Image;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user=Auth::user();
        $posts=Post::with(['post_images','comments'])->where('user_id',$user->id)->get();

        return view('profiles.index',['user'=>$user,'posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         //store profile image using image intervension


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
        $user=Auth::user();
        $posts=Post::with('profile')->where('id',$user->id);
        return view('profiles.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProfileRequest $request, Profile $profile)
    {
        //

        $user=Auth::user();
        if ($request->file('avatar')) {
            $image = $request->file('avatar');
            $file_name = rand(1, 500).'.'.$image->extension();

            $first_path= 'assets/profile_images/';
            $destinationPath =$request->country.'/'.$request->last_name;
            if (!File::isDirectory($first_path. $destinationPath)) {
                File::makeDirectory($first_path. $destinationPath, 0777, true, true);
            }
            $imgFile = Image::make($image->getRealPath());
            $imgFile->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($first_path. $destinationPath.'/'.$file_name);



            // $user->profile->save();
            $user->profile()->updateOrCreate(['user_id'=>auth()->id(),

        ], $request->only(['first_name','last_name','about'])+['country'=>$request->country,'city'=>$request->city,'avatar'=>$destinationPath.'/'. $file_name]

        );


            return redirect('/Profile')
            ->with('success', 'Image has successfully uploaded.')
            ->with('fileName', $file_name);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
