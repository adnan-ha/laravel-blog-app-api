<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use function Pest\Laravel\json;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $data = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'image' => $category->image_url,
                'updated_at' => $category->updated_at,
                'created_at' => $category->updated_at
            ];
        });
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::where('id', $id)->first();
        if ($category) {
            $data = [
                'id' => $category->id,
                'name' => $category->name,
                'image' => $category->image_url,
                'updated_at' => $category->updated_at,
                'created_at' => $category->updated_at
            ];
            return response()->json($data, 200);
        }
        return response()->json(['message' => 'category not found'], 404);
    }
}
