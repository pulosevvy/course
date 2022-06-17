<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index() {
        $category = Category::all();

        return response()->json([
            'status' => true,
            'categories' => $category
        ]);
    }

    public function store(Request $request) {
        $this->authorize('create', Category::class);

        try {

            $validated = Validator::make($request->all(),
            [
                'title' => 'required|min:3'
            ]);

            if($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validate error',
                    'error' => $validated->errors()
                ]);
            }

            $category = Category::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Category created',
                'categories' => $category
            ]); 

        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, Category $category) {
        $this->authorize('update', $category);

        try {

            $validated = Validator::make($request->all(),
            [
                'title' => 'required|min:3'        
            ]);

            if($validated->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validate errors',
                    'erorr' => $validated->errors()
                ]);
            }

            $category->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Category updated',
                'categories' => $category
            ]);

        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }


    public function destroy(Category $category) {
        
        $this->authorize('delete', $category);

        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category Deleted',
            'categories' => $category
        ], 200);
    }
}
