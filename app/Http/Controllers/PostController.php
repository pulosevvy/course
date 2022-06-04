<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Filters\PostFilter;
use App\Models\Category;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index() {
        
        $posts = Post::with('category')->get(); 

        return view('posts.index', compact('posts'));
    }

    public function showPost(PostFilter $request) {

        $posts = Post::filter($request)->get();
        $categories = Category::all();

        return view('dashboard', 
            // ['posts' => Post::latest()->filter(request(['search']))->get()],
         compact('posts', 'categories'));
    }

    public function create(Category $category, Post $post) {

        $this->authorize('create', Post::class);
        $categories = Category::all();
        return view('posts.create', compact('categories', 'post'));
    }

    public function store(Request $request) {

        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        // dd($validated);

        Post::create($validated);

        return to_route('posts.index');
    }

    public function edit(Post $post) {
        $this->authorize('update', $post);
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post) {
        $this->authorize('update', $post);
        $validated = $request->validate(['title' => 'required', 'body' => 'required', 'category_id' => 'required']);
        $post->update($validated);

        return to_route('posts.index');
    }

    public function destroy(Post $post){
        $this->authorize('delete', $post);
        $post->delete();

        return to_route('posts.index');
    }
}
