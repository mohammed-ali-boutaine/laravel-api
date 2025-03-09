<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {

            $products = Product::all();
            return response()->json($products);

        
        // catching errors
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while fetching products'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'image_src' => 'required|string',
            ]);

            $product = Product::create($validatedData);

            return response()->json([
                'product' => $product,
                'message' => 'Product created successfully'
            ], 201);



            // catching errors
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while creating the product.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = Product::find($id);

        // return product
        if (!empty($product)) {
            return response()->json($product);
        }


        // product not found
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {

            $product = Product::findOrFail($id);

            // validation
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric|min:0',
                'image_src' => 'sometimes|string',
            ]);


            // Check if the product exists
            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }
            if ($request->has('name')) {
                $product->name = $request->name;
            }
            if ($request->has('description')) {
                $product->description = $request->description;
            }
            if ($request->has('price')) {
                $product->price = $request->price;
            }
            if ($request->has('image_src')) {
                $product->image_src = $request->image_src;
            }

            // Save the changes
            $product->save();

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product
            ]);


        // catching errors
        } catch (\Exception $e) {
            // Log the exception (optional)
            Log::error('Error updating product: ' . $e->getMessage());

            // Return a generic error message
            return response()->json([
                'message' => 'An error occurred while updating the product.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            Product::destroy($id);
            return response()->json(['message' => 'Product Deleted'], 202);


            // catching errors
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting the product'
            ], 500);
        }
    }
}
