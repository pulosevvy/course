<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Filters\PostFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(PostFilter $request) {
        $posts = Post::filter($request)->get();

        return response()->json([
            'status' => true,
            'posts' => $posts
        ], 200);
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
        $this->authorize('create', Post::class);

        try {

            $validated = Validator::make($request->all(), 
            [
                'title' => 'required',
                'body' => 'required'
            ]);

            if($validated->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validate error',
                    'error' => $validated->errors()
                ]);
            }

            $post = Post::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Post Created',
                'post' => $post
            ], 200);

        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
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
        $post = Post::with('comments.user')->find($post);

        return response()->json([
            'status' => true,
            'posts' => $post->toArray()
        ], 200);
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
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        try {

            $validated = Validator::make($request->all(),
            [
                'title' => 'required',
                'body' => 'required'
            ]);

            if($validated->fails()) {
                return response()->json([
                    'status' => 'required',
                    'message' => 'validate error',
                    'error' => $validated->errors()
                ]);
            }

            $post->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Post Updated',
                'posts' => $post
            ], 200);

        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }

        
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
