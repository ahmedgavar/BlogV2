<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Image as Image;
use App\Models\Post;
use App\Models\PostImages;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
        // save post reaction

     public function toggle_react(Post $post,Request $request)
     {

        $post->toggleReaction($request->reaction);



    }

    // create new post with oe or more images
    public function store(StorePostRequest $request)
    {
        // 1 start prepare folder for original images and resized images

        $time=Carbon::now();
        // name of image using slug
        $title=trim($request->title);
        $slug=Str::of($request->title)->slug('-');
        // folder of images if not existed
        $new_path=$slug.'/'.date_format($time, 'Y').'/'.date_format($time, 'm');

        $original_global_path=public_path().'/assets/posts_images/';
        $original_full_path=$original_global_path.$new_path;

        $resized_global_path=public_path().'/assets/posts_images_thumbs/';
        $resized_full_path=$resized_global_path.$new_path;

        if (!File::isDirectory($resized_full_path))

        {

            File::makeDirectory($resized_full_path, 0777, true, true);
         }
         if (!File::isDirectory($original_full_path))

         {

             File::makeDirectory($original_full_path, 0777, true, true);
          }

        // 1 End  prepare folder for original images and resized images




        if ($request->hasFile('images'))

        {

            // to ensure saving data in 2 tables
            DB::transaction(function () use ($slug,$title, $request,$new_path,$resized_full_path, $time)

            {


                // 1 save table of posts
                $post_data = Arr::except($request->all(), ['images','title']);
                $post_store=Post::create
                (
                 // user id added in boot function in post model when creating

                    $post_data+['slug'=>$slug,'title'=>$title]

                );

                // 2 save table of post_images


                foreach ($request->images as $image)
                {
                    // A_ path of image folders according post date and name
                    // B_ images names
                    $file_name = $slug.rand(1, 500);
                    $file_extension=$image->extension();

                    // C_ store original image
                    Storage::disk('posts_images')->putFileAs($new_path, $image, $file_name.'.'.$file_extension);

                    // D_ store resized image
                    $original_Image = Image::make($image->getRealPath());
                    $original_Image->resize(250, 150);



                    $original_Image->save($resized_full_path.'/'.$file_name .'.'.$file_extension, 100);

                    // 3 store images for post with relation

                    $post_store->post_Images()->create(
                        [
                            'image_path'=>$new_path,

                            'image_name'=>$file_name,
                            'image_extension'=>$file_extension,

                        ]

                    );
                }


            });

            // number of images


        }
        $total_images = count($request->file('images'));

            session()->flash('create_status', 'Your post has created successfully with '.$total_images.' image');

            return redirect('/');



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

        // i edit modal using data-bs-target

    }


    public function update(UpdatePostRequest $request)
    {


        $post=Post::find($request->postId);
        // if you changed title or content or images

        $time=Carbon::now();
        $title=trim($request->title_edit);


        // slug
        $slug=Str::of($request->title_edit)->slug('-');

        $new_path=date_format($time, 'Y').'/'.date_format($time, 'm');
        $origin_path=public_path(). '/assets/posts_images/';
        $resized_path=public_path(). '/assets/posts_images_thumbs/';

        //  1 case : if title not changes
        if($title==$post->title)
        {

            DB::transaction(function () use ($slug,$title, $request, $time,$post,$new_path,$resized_path,$origin_path)
            {
                $post->post_Images()->delete();

                // 1 delete  old folder for images
                $org_path=$origin_path.$slug.'/'.$post->created_at->year;
                $path_existed=File::isDirectory($org_path);

                if ($path_existed) {
                    File::deleteDirectory($org_path);



                }
                // 1 delete  old folder for resiced images
                $resiz_path=$resized_path.$slug.'/'.$post->created_at->year;
                $path_existed=File::isDirectory($resiz_path);

                if ($path_existed) {
                    File::deleteDirectory($resiz_path);



                }



                //  3 update post table
                $post_update=$post->update([
                'content'=>$request->content_edit,
                'slug'=>$slug,

                ]);
                // 4 save new images in database and folder
                foreach ($request->images_for_edit as $image) {
                    // A_ path of image folders according post date and name
                    $origin_path=$slug.'/'.$new_path;
                    // B_ images names
                    $file_name = $slug.rand(1, 500);
                    $file_extension=$image->extension();

                    // C_ store original image
                    Storage::disk('posts_images')->putFileAs($origin_path, $image, $file_name.'.'.$file_extension);

                    // D_ store resized image
                    $original_Image = Image::make($image->getRealPath());
                    $original_Image->resize(250, 150);
                    // create directory because image intervention not create folder

                    if (!File::isDirectory($resized_path.$origin_path)) {
                        File::makeDirectory($resized_path.$origin_path, 0777, true, true);
                    }
                    $original_Image->save($resized_path.$origin_path.'/'.$file_name.'.'.$file_extension, 100);

                    // // store images for post with relation

                    $post->post_Images()->create(
                        [
                        'image_path'=>$origin_path,
                        'image_name'=>$file_name,
                        'image_extension'=>$file_extension,


                    ]
                    );
                }

            });

        }

        // case 2 title changes
    else
    {
        $resized_path=public_path().'/assets/posts_images_thumbs/';

        DB::transaction(function () use ($slug,$title, $request, $time,$post,$resized_path)
        {
            // 2 delete original images from folder
            $origin_images_path=public_path(). '/assets/posts_images/'.$post->slug;
            $path_existed=File::isDirectory($origin_images_path);

            if ($path_existed) {
                File::deleteDirectory($origin_images_path);
            }

            // 2 delete resized images from folder
            $resized_images_path=public_path(). '/assets/posts_images_thumbs/'.$post->slug;
            $path_existed=File::isDirectory($resized_images_path);

            if ($path_existed) {
                File::deleteDirectory($resized_images_path);
            }



            $post->post_Images()->delete();

            $post_update=$post->update([
                'title'=>$title,
                'content'=>$request->content_edit,
                'slug'=>$slug,

                ]);



            // 4 save new images in database and folder
            foreach ($request->images_for_edit as $image) {
                // store images for post with relation


                // A_ path of image folders according post date and name
                $new_path=$slug.'/'.date_format($time, 'Y').'/'.date_format($time, 'm');
                // B_ images names
                $file_name = $slug.rand(1, 500);
                $file_extension=$image->extension();
                $post->post_Images()->create(
                    [
                    'image_path'=>$new_path,
                    'image_name'=>$file_name,
                    'image_extension'=>$file_extension,


                ]
                );


                // C_ store original image
                Storage::disk('posts_images')->putFileAs($new_path, $image, $file_name.'.'.$file_extension);

                // D_ store resized image
                $original_Image = Image::make($image->getRealPath());
                $original_Image->resize(250, 150);
                // create directory because image intervention not create folder

                if (!File::isDirectory($resized_path.$new_path))
                {
                    File::makeDirectory($resized_path.$new_path, 0777, true, true);
                }
                $original_Image->save($resized_path.$new_path.'/'.$file_name.'.'.$file_extension, 100);


            }

        });



    }


            $total_images =count($request->file('images_for_edit'));
            session()->flash('update_status', 'Your post has updated successfully with '.$total_images.' image');
            return redirect('/');


}






    public function destroy(Request $request)
    {
        //
        // return $request;
        // delete using force deleted
        $post_id=$request->delete_name;
        $post=Post::find($post_id);


        // delete folder of origin images
        $origin_images_path=public_path(). '/assets/posts_images/'.$post->slug;
        $path_existed=File::isDirectory($origin_images_path);

        if ($path_existed) {
            File::deleteDirectory($origin_images_path);
        }

         // delete folder of resized images
         $resized_images_path=public_path(). '/assets/posts_images_thumbs/'.$post->slug;
         $path_existed=File::isDirectory($resized_images_path);

         if ($path_existed) {
             File::deleteDirectory($resized_images_path);
         }

        $post_delete=$post->forceDelete();
        if($post_delete){

            session()->flash('delete_status','post deleted successfully');
            return redirect('/');
        }



    }
}



