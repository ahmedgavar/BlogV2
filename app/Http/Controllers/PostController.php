<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Image as Image;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostImages;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
        // reactions

     public function toggle_react(Post $post,Request $request)
     {
        

        $post->toggleReaction('like');
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


        DB::transaction(function () use($slug,$validatedData,$request,$time) {


            // 1 save table of posts
            $post_store=Post::create(
                Arr::except($validatedData+['slug'=>$slug], ['images'=>'image_name'])

         // user id added in boot function in post model when creating
            );


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
        });
            // number of images
            $total_images = count($request->file('images'));


            session()->flash('status', 'Your post has created successfully with '.$total_images.' image');

            return redirect('/');

        }

    }
    /**
     *
     * @param string $slug
     */

    public function show( $slug )
    {
        //
        $post=Post::with(['post_Images','comments'])-> where('slug',$slug)->first();


        return view('posts.show',['post'=>$post]);
    }


    public function edit($post)
    {
        //

    }


    public function update(UpdatePostRequest $request)
    {
        //
        $validatedData = $request->validated();
        $time=Carbon::now();
        $slug=SlugService::createSlug(Post::class, 'slug', $validatedData['title_edit']);

        // delete old images from database

        $post=Post::with('post_Images')->find($request->postId);
        foreach ($post->post_Images as $old_images) {
            # code...
            $old_images->Delete();
        }
        // End delete old images from database
        // delete old images from directory
// path of folders
        $origin_path=$slug.'/'.date_format($time, 'Y').'/'.date_format($time, 'm');
        if( $post->title!=$request->validated()[ 'title_edit']){

        Storage::deleteDirectory($post->slug);


        }


        //1 name folder name and file name to store them
                // get image from form html
        if ($request->hasFile('images_for_edit')) {

            // update post table
         // user id added in boot function in post model when updating

            $post_update=$post->update([
                'title'=>$request->validated()[ 'title_edit'],
                'content'=>$request->validated()[ 'content_edit'],
                'slug'=>$slug,

            ]);
            // delete old folder





            // number of images
            $total_images = count($request->file('images_for_edit'));


            foreach ($request->images_for_edit as $image) {
                // $origin_path=$slug.'/'.date_format($time, 'Y').'/'.date_format($time, 'm');


                // images names
                $file_name = $slug.rand(1, 500).'.'.$image->extension();



                // store original image
                Storage::disk('posts_images')->putFileAs($origin_path, $image, $file_name);

                // store resized image
                $original_Image = Image::make($image->getRealPath());
                $original_Image->resize(250, 150);
                // create directory because image intervention not create folder

                if (!File::isDirectory(public_path().'/assets/posts_images_thumbs/'.$origin_path) && $post->title==$request->validated()[ 'title_edit']) {
                    File::makeDirectory(public_path().'/assets/posts_images_thumbs/'.$origin_path, 0777, true, true);
                }
                $original_Image->save(public_path('assets/posts_images_thumbs/').$origin_path.'/'.$file_name, 100);

                // store images for post
                ;

                PostImages::updateOrCreate(
                    [
                    'post_id'=>$post->id,
                    'image_name'=>$origin_path.'/'. $file_name ,
                    ]
                );
            }
            session()->flash('status', 'Your post has created successfully with '.$total_images.' image');

            return redirect('/');

        }
        else{
        $slug=SlugService::createSlug(Post::class, 'slug', $validatedData['title_edit']);

            $post_update=$post->updateOrCreate([
                'title'=>$request->validated()[ 'title_edit'],
                'content'=>$request->validated()[ 'content_edit'],
                'slug'=>$slug,

            ]);
            session()->flash('status', 'Your post has created successfully with 0 image');

            return redirect('/');
        }





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



