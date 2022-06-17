<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, $post_id) {

        try {

            if(Auth::check()) {

                $validated = Validator::make($request->all(), 
                [
                    'comment_body' => 'required'
                ]);

                if($validated->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'validated error',
                        'errors' => $validated->errors()
                    ]);
                }
                
                $post = Post::find($post_id);

                $comment = Comment::create([
                    'comment_body' => $request->comment_body,
                    'post_id' => $post->id,
                    'user_id' => Auth::id()
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'comment added',
                    'comment' => $comment
                ]);
            }

        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id, $comment) {

        try{

            $validated = Validator::make($request->all(),
            [
                'comment_body' => 'required'
            ]);

            if($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validate error',
                    'errors' => $validated->errors()
                ]);
            }

            $comments = Comment::find($comment);
        
            if((Auth::check() && (Auth::id() == $comments->user_id)) || auth()->user()->hasRole('admin') ) {
                
                $comments->update($request->all());        
                
                return response()->json([
                    'status' => true,
                    'message' => 'comment updated',
                    'comment' => $comment
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'auth errors'
                ]);
            }

        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }

    }

    public function destroy($id, $comment) {

        $comments = Comment::find($comment);
    
        if((Auth::check() && (Auth::id() == $comments->user_id)) || auth()->user()->hasRole('admin') ) {
            
            $comments->delete();        
            
            return response()->json([
                'status' => true,
                'message' => 'comment deleted',
                'comment' => $comment
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'auth errors'
            ]);
        }
    }
}
