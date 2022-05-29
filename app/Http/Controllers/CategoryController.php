<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function create() {
        $this->authorize('create', Category::class);

        return view('categories.create');
    }

    public function store(Request $request) {
        $this->authorize('create', Category::class);

        $validated = $request->validate(['title' => ['required']]);

        Category::create($validated);

        return to_route('categories.index');
    }

    public function edit(Category $category) {
        $this->authorize('update', $category);
        
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category) {
        $this->authorize('update', $category);

        $validated = $request->validate(['title' => 'required']);
        $category->update($validated);

        return to_route('categories.index');
    }

    public function destroy(Category $category) {
        $this->authorize('delete', $category);

        $category->delete();

        return to_route('categories.index');
    }
}
