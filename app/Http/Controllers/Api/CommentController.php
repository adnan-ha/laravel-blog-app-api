<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($PostID)
    {
        $comments = Comment::where('post_id', $PostID)->with('user')->get();
        $data = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
                'post_id' => $comment->post_id,
                'user' => [
                    'user_id' => $comment->user->id,
                    'user_name' => $comment->user->name,
                    'user_photo' => $comment->user->image_url,
                ]
            ];
        });
        return response()->json(['comments' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'post_id' => 'required|numeric'
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
        ]);
        return response()->json(['message' => 'comment added successfully', 'comment' => $comment], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::where('id', $id)->first();

        if (!$comment) {
            return response()->json(['message' => 'comment not found'], 404);
        }

        if (Auth::id() != $comment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment->update([
            'comment' => $request->comment,
        ]);
        return response()->json(['message' => 'comment updated successfully', 'comment' => $comment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::where('id', $id)->first();

        if (!$comment) {
            return response()->json(['message' => 'comment not found'], 404);
        }

        if (Auth::id() == $comment->user_id || Auth::id() == $comment->post->user_id) {
            $comment->delete();
            return response()->json(['message' => 'comment deleted successfully'], 200);
        }
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
