<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryController extends Controller
{

    public function get()
    {
        $categories = Category::all();
        return response()->json([
            'meta' => count($categories),
            'data' => $categories
        ], 200);
    }
    /**
     * category
     * params{
     * name
     * }
     */
    public function store(Request $request)
    {
        if (!$request->name){
            return response()->json([
                'error' => "category name is required"
            ],400);
        }

        Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => "successfully created"
        ],201);
    }

    public function update(Request $request, $id)
    {
        if (!$id){
            return response()->json([
                'error' => "productid is required"
            ],400);
        }
        $category = Category::find($id);
        if (!$category){
            return response()->json([
                'error' => "Category not Found"
            ],400);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => "successfully updated"
        ],200);
    }

    public function delete($id)
    {
        if (!$id){
            return response()->json([
                'error' => "productid is required"
            ],400);
        }
        $category = Category::find($id);
        if (!$category){
            return response()->json([
                'error' => "Category not Found"
            ],400);
        }

        $category->delete();

        return response()->json([
            'success' => "successfully deleted"
        ],200);
    }
}
