<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $shop_id)
    {
        $shop = $request->user()->shops->find($shop_id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $product = $shop->products;

        if ($product->isEmpty()) {
            return response()->json(['message' => 'No products found for this shop', 'user' => $shop], 200);
        }

        return response()->json(['product' => $product], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $shop_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category' => 'required|string',
            'units' => 'required|string',
            'code' => 'required|string|unique:products,code',
            'stock' => 'required|integer',
            'b_price' => 'required|numeric',
            's_price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $authenticatedUserId = $request->user()->id;


        $shop = $request->user()->shops()->find($shop_id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $product = $shop->products()->create([
            'name' => $request->name,
            'category' => $request->category,
            'units' => $request->units,
            'code' => $request->code,
            'stock' => $request->stock,
            'b_price' => $request->b_price,
            's_price' => $request->s_price
        ]);

        return response()->json(['success' => 'Product created successfully', 'product' => $product, 'user' => $authenticatedUserId], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $shop_id, $product_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category' => 'required|string',
            'units' => 'required|string',
            'code' => 'required|string|unique:products,code',
            'stock' => 'required|integer',
            'b_price' => 'required|numeric',
            's_price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $shop = $request->user()->shops()->find($shop_id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $product = $shop->products()->find($product_id);

        if (!$product) {
            return response()->json(['error' => 'Product not found or does not belong to the specified shop'], 404);
        }

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'units' => $request->units,
            'code' => $request->code,
            'stock' => $request->stock,
            'b_price' => $request->b_price,
            's_price' => $request->s_price,
        ]);

        return response()->json(['success' => 'Product updated successfully', 'product' => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $shop_id, $product_id)
    {
        $shop_id = $request->user()->shops()->find($shop_id);

        if (!$shop_id) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $product = $shop_id->products()->find($product_id);

        if (!$product) {
            return response()->json(['error' => 'Party not found or does not belong to the specified shop'], 404);
        }

        $product->delete();

        return response()->json(['success' => 'Product deleted successfully'], 200);
    }
}
