<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tag = Tag::where('id', $id)->first();
        if (!$tag) {
            return response()->json(['message' => 'tag not found'], 404);
        }
        return response()->json($tag, 200);
    }
}
