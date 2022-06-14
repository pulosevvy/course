<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentsRequest;

class CommentController extends Controller
{
    public function store(Request $request, $post_id) {

        $user = User::all();

        $post = Post::find($post_id);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->comment_body = $request->comment_body;

        $comment->save();


        return to_route('detail', $post);
    }

    public function edit($id,$comm, Request $request){
        $comment = Comment::find($comm);
        $posts = Post::findOrFail($id);
        return view('comments.comments-edit', compact([
            'comment','posts'
        ]));
    }

    public function update($id,$comm, Request $request){
        $request->validate([
            'comment_body' => 'required',

        ]);
        $comment = Comment::find($comm);
        $comment->update($request->all());
        return redirect()->route('detail', $id);
    }

    public function delete($id,$comm){
        $comment = Comment::find($comm);
        $comment->delete();

        return redirect()->back();
    }
}
