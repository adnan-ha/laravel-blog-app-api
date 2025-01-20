<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->get();
        $data = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'image' => $post->image_url,
                'updated_at' => $post->updated_at,
                'created_at' => $post->updated_at,
                'user' => [
                    'user_id' => $post->user->id,
                    'user_name' => $post->user->name,
                    'user_photo' => $post->user->image_url,
                ],
            ];
        });
        return response()->json(['posts' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,svg',
            'category_id' => 'numeric|nullable',
            'tags' => 'array',
        ]);

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('images/posts', 'public');
        }

        $post = Post::create([
            "user_id" => Auth::id(),
            "title" => $request->title,
            "description" => $request->description,
            "category_id" => $request->category_id,
            "image" => isset($imageName) ? $imageName : NULL,
        ]);
        $post->tags()->attach($request->tags);
        return response()->json(['message' => 'post was created successfully', 'post' => $post], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::where('id', $id)->first();
        if (!$post) {
            return response()->json(['message' => 'post not found'], 404);
        }

        if ($post->tags) {
            $tags = $post->tags->map(function ($tag) {
                return [
                    'tag_id' => $tag->id,
                    'tag_name' => $tag->name,
                ];
            });
        }

        if ($post->category) {
            $category = [
                'category_id' => $post->category->id,
                'category_name' => $post->category->name,
                'category_image' => $post->category->image_url,
            ];
        }

        $data = [
            'id' => $post->id,
            'title' => $post->title,
            'description' => $post->description,
            'image' => $post->image_url,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'user' => [
                'user_id' => $post->user->id,
                'user_name' => $post->user->name,
                'user_photo' => $post->user->image_url,
            ],
            'category' => isset($category) ? $category : null,
            'tags' => isset($tags) ? $tags : null,
        ];
        return response()->json(['post' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::where('id', $id)->first();

        if (!$post) {
            return response()->json(['message' => 'post not found'], 404);
        }

        if (Auth::id() != $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,svg',
            'category_id' => 'numeric|nullable',
            'tags' => 'array',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                if (Storage::disk('public')->exists($post->image)) {
                    Storage::disk('public')->delete($post->image);
                }
            }
            $imageName = $request->file('image')->store('images/posts', 'public');
            $post->image = $imageName;
        }

        $post->update([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $post->image,
        ]);

        $post->tags()->sync($request->tags);
        return response()->json(['message' => 'post was updated successfully', 'post' => $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();

        if (!$post) {
            return response()->json(['message' => 'post not found'], 404);
        }

        if (Auth::id() != $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($post->image) {
            if (Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
        }
        $post->delete();
        return response()->json(['message' => 'post was deleted successfully'], 200);
    }
}
