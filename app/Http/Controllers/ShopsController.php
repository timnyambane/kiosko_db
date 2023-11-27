<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a new shop in the database.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'business_phone' => 'required|string|max:12',
            'business_category' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $shop = $request->user()->shops()->create([
            'business_name' => $request->business_name,
            'business_address' => $request->business_address,
            'owner_name' => $request->owner_name,
            'business_phone' => $request->business_phone,
            'business_category' => $request->business_category,
        ]);

        return response()->json(['success' => 'Shop created successfully', 'shop' => $shop], 200);
    }
}
