<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostImages;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Image as Image;

class PostController extends Controller
{
    
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

  

    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();

        $time=Carbon::now();
        // name of image using slug and 
        $slug=SlugService::createSlug(Post::class, 'slug', $request->title);

        //1 name folder name and file name to store them
                // get image from form html
        if ($request->hasFile('images')) {
            // 1 save table of posts
            $post_store=Post::create(
                Arr::except($validatedData+['slug'=>$slug], ['image_name'])
         
         // user id added in boot function in post model when creating
            );
            // number of images
            $total_images = count($request->file('images'));


            foreach ($request->images as $image) {
                $origin_path=$slug.'/'.date_format($time, 'Y').'/'.date_format($time, 'm');

            
                // images names
                $file_name = $slug.rand(1, 500).'.'.$image->extension();

               
                // path of folders
                $origin_path=$slug.'/'.date_format($time, 'Y').'/'.date_format($time, 'm');
                // store original image
                Storage::disk('posts_images')->putFileAs($origin_path, $image, $file_name);
        
                // store resized image
                $original_Image = Image::make($image->getRealPath());
                $original_Image->resize(250, 150);
                // create directory because image intervention not create folder
        
                if (!File::isDirectory(public_path().'/assets/posts_images_thumbs/'.$origin_path)) {
                    File::makeDirectory(public_path().'/assets/posts_images_thumbs/'.$origin_path, 0777, true, true);
                }
                $original_Image->save(public_path('assets/posts_images_thumbs/').$origin_path.'/'.$file_name, 100);
        
                // store images for post
                ;

                PostImages::create(
                    [
                    'post_id'=>$post_store->id,
                    'image_name'=>$origin_path.'/'. $file_name ,
                    ]
                );
            }
            session()->flash('status', 'Your post has created successfully with '.$total_images.' image');
        
            return redirect('/');
        }
        
    }

    public function show(Post $post)
    {
        //
    }

    
    public function edit($post)
    {
        //

    }

    
    public function update(UpdatePostRequest $request)
    {
        //

        $post=Post::findOrFail($request->postId);

        $slug=SlugService::createSlug(Post::class, 'slug', $request->title_edit);

        $post_update=$post->update([
            'title'=>$request->validated()[ 'title_edit'],
            'content'=>$request->validated()[ 'content_edit'],
            'slug'=>$slug,
            
        ]);
        
        session()->flash('status','Your pos successfully ');
        return redirect('/');

       
    }

  
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



