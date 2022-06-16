<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Filters\PostFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(PostFilter $request) {
        $posts = Post::with('comments.user')->get();
        $posts = Post::filter($request)->get();

        return response()->json([
            'status' => true,
            'posts' => $posts->toArray()
        ], 200);
    }

    // public function search(PostFilter $request)
    // {
    //     $posts = Post::filter($request)->get();

    //     return response()->json([
    //         'status' => true,
    //         'posts' => $posts
    //     ]);
    // }

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
        $this->authorize('create', Post::class);

        $post = Post::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Post Created',
            'post' => $post
        ], 200);
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
    public function edit(Post $post)
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
    public function update(StorePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Post Updated',
            'posts' => $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Post Deleted',
            'posts' => $post
        ], 200);
    }

}
