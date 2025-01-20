<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4|max:15',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($request->hasFile('category_image')) {
            $imageName = $request->file('category_image')->store('images/categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'image' => $imageName,
        ]);
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|min:4|max:15',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $imageName = $request->file('image')->store('images/categories', 'public');
            $category->image = $imageName;
        }

        $category->update([
            'name' => $request->name,
            'image' => $category->image,
        ]);
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        if (Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('categories.index');
    }
}
