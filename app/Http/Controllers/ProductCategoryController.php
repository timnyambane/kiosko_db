<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
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

        $prod_categories = $shop->prod_categories;

        if ($prod_categories->isEmpty()) {
            return response()->json(['message' => 'No product categories found for this shop'], 200);
        }

        return response()->json(['product' => $prod_categories], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $shop_id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        $shop = $request->user()->shops->find($shop_id);
        if (!$shop) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $prod_category = $shop->prod_categories()->create([
            'category' => $request->category,
        ]);

        return response()->json(['success' => 'Product Category created successfully', 'product' => $prod_category], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    public function update(Request $request, $shop_id, $products_category)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $shop = $request->user()->shops()->find($shop_id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $product_cat = $shop->prod_categories()->find($products_category);

        if (!$product_cat) {
            return response()->json(['error' => 'Product category not found or does not belong to the specified shop'], 404);
        }

        $product_cat->update([
            'category' => $request->category,
        ]);

        return response()->json(['success' => 'Product category updated successfully', 'product' => $product_cat], 200);
    }

    public function destroy(Request $request, $shop_id, $products_category)
    {
        $shop = $request->user()->shops()->find($shop_id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $product_cat = $shop->prod_categories()->find($products_category);

        if (!$product_cat) {
            return response()->json(['error' => 'Product category not found or does not belong to the specified shop'], 404);
        }

        if (!$product_cat) {
            return response()->json(['error' => 'Party not found or does not belong to the specified shop'], 404);
        }

        $product_cat->delete();

        return response()->json(['success' => 'Product category deleted successfully'], 200);
    }


}
