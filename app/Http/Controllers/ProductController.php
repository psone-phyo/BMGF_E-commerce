<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    /**
     * create products and update products
     * params{
     * name
     * price
     * photo
     * description
     * category_id
     * stock
     * }
     */
    function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required|numeric',
                'photo' => 'required',
                'description' => 'required',
                'category_id' => 'required|numeric',
                'stock' => 'required'
            ]);

            if ($validation->fails()) {
                $errors = collect($validation->errors()->toArray())->map(function ($error) {
                    return $error[0];
                });
                return response()->json([
                    'error' => $errors
                ], 401);
            }

            Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'photo' => $request->photo,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'stock' => $request->stock
            ]);

            return response()->json([
                'success' => 'successfully created'
            ],201);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * create image link
     */

    function storeImage(Request $request){
        try {
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('product', $filename, 'public');
                $link = url('storage/product/' . $filename);

                return response()->json([
                    'link' => $link
                ], 200);
            } else {
                return response()->json([
                    'error' => 'No file uploaded'
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function update(Request $request, $id)
    {
        if (!$id){
            return response()->json([
                'error' => "productid is required"
            ],400);
        }

        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'error' => "Product not found"
                ], 404);
            }

            // Update the product
            $product->update([
                'name' => $request->name?? $product->name,
                'price' => $request->price?? $product->price,
                'photo' => $request->photo?? $product->photo,
                'description' => $request->description?? $product->description,
                'category_id' => $request->category_id?? $product->category_id,
                'stock' => $request->stock?? $product->stock
            ]);

            return response()->json([
                'success' => 'Successfully updated'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function delete($id)
    {
        if (!$id) {
            return response()->json([
                'error' => "product id is required"
            ], 400);
        }

        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'error' => "Product not found"
                ], 404);
            }

            $product->delete();

            return response()->json([
                'success' => 'Successfully deleted'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
