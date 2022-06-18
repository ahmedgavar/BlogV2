<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function toggle_react(Comment $comment,Request $request)
    {


       $comment->toggleReaction($request->reaction);
   }

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
    public function store(Request $request)
    {
        //
        $request->validate(['comment'=>'required'],['comment.required'=>'comment cannot be empty']);
        $comment=Comment::create([
            'comment'=>$request->comment,
            'post_id'=>$request->post_id,
            'user_id'=>Auth::user()->id
        ]);
        return $comment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\int  $post_id
     * @return \Illuminate\Http\Response
     */
    public function show($post_id)
    {
        // get all comments of post using relation
        $post = Post::with('comments')->orderBy('id','desc')->find($post_id);

        return view('comments.show',['comments'=>$post->comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
