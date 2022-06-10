<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentsRequest;

class CommentController extends Controller
{
    public function store(Request $request, $post_id) {

        $post = Post::find($post_id);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->comment_body = $request->comment_body;

        $comment->save();


        return to_route('detail', $post);
    }
}
