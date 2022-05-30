<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\PostImages;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Arr;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(StorePostRequest $request)
    {
      
        // name folder name and file name to store them
        if ($request->image_name) {
            // get image from form

            $image=$request->image_name;
            $time=Carbon::now();
            
            $directory=date_format($time, 'Y').'/'.date_format($time, 'm');
            $file_name=date_format($time, 'h').'/'.date_format($time, 's').'.'.$image->extension();
            Storage::disk('posts_images')->putFileAs($directory, $image, $file_name);

            $slug=SlugService::createSlug(Post::class, 'slug', $request->title);
            $validatedData = $request->validated();
            $post_store=Post::create(
                Arr::except($validatedData+['slug'=>$slug],['image_name'])
                
                // user id addeed in boot function in post model when creating
                
            
            );
            // store images for post

            PostImages::create([
                'post_id'=>$post_store->id,
                'image_name'=>$directory.'/'.$file_name
                ,
            ]
            );
            session()->flash('status','Your post has created successfully ');
            return redirect('/');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($post)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $post=Post::findOrFail($request->postId);


        $slug=SlugService::createSlug(Post::class, 'slug', $request->title_edit);

        $post->update([
            'title'=>$request->title_edit,
            'content'=>$request->content_edit,
            'slug'=>$slug,
            
        ]);
        session()->flash('status','Your post has updated successfully ');
            return redirect('/');

        
    
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        // return $request;
        // delete using soft deleted 
        $post_id=$request->delete_name;
        $post=Post::find($post_id);

        $post_delete=$post->Delete();
        if($post_delete){
            session()->flash('delete','post deleted successfully');
            return redirect('/');
        }
        

        
    }
}
