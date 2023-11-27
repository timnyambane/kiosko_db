<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $shop_id)
    {
        $shop = $request->user()->shops()->find($shop_id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $parties = $shop->parties;

        if ($parties->isEmpty()) {
            return response()->json(['message' => 'No parties found for this shop'], 200);
        }

        return response()->json(['parties' => $parties], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $shop_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'phone' => 'required|string',
            'role' => 'required|in:customer,supplier'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $authenticatedUserId = $request->user()->id;


        $shop = $request->user()->shops()->find($shop_id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $party = $shop->parties()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'role' => $request->role
        ]);

        return response()->json(['success' => 'Party created successfully', 'party' => $party, 'user' => $authenticatedUserId], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $shop_id, $party_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'phone' => 'required|string',
            'role' => 'required|in:customer,supplier'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $shop = $request->user()->shops()->find($shop_id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $party = $shop->parties()->find($party_id);

        if (!$party) {
            return response()->json(['error' => 'Party not found or does not belong to the specified shop'], 404);
        }

        $party->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'role' => $request->role
        ]);

        return response()->json(['success' => 'Party updated successfully', 'party' => $party], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $shop_id, $party_id)
    {
        $shop = $request->user()->shops()->find($shop_id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found or does not belong to the user'], 404);
        }

        $party = $shop->parties()->find($party_id);

        if (!$party) {
            return response()->json(['error' => 'Party not found or does not belong to the specified shop'], 404);
        }

        $party->delete();

        return response()->json(['success' => 'Party deleted successfully'], 200);
    }

}
