<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponCategory extends Controller
{
    public function index()
    {
        return response()->json(Coupon::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:coupons',
            'price' => 'required|numeric',
            'type' => 'required|in:percentage,fixed',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        $coupon = Coupon::create($validated);
        return response()->json(['message' => 'Coupon created', 'data' => $coupon], 201);
    }

    public function show(Coupon $coupon)
    {
        return response()->json($coupon);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:coupons,name,' . $coupon->id,
            'price' => 'required|numeric',
            'type' => 'required|in:percentage,fixed',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        $coupon->update($validated);
        return response()->json(['message' => 'Coupon updated', 'data' => $coupon]);
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json(['message' => 'Coupon deleted']);
    }


    // ✅ Apply Coupon API
    public function apply(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        $coupon = Coupon::where('name', $request->name)
            ->where('status', 1)
            ->first();

        if (!$coupon) {
            return response()->json(['message' => 'Invalid or inactive coupon'], 404);
        }

        $today = Carbon::now()->toDateString();

        if (($coupon->startDate && $today < $coupon->startDate) ||
            ($coupon->endDate && $today > $coupon->endDate)) {
            return response()->json(['message' => 'Coupon expired'], 400);
        }

        return response()->json([
            'message' => 'Coupon applied successfully',
            'data' => $coupon,
        ]);
    }
}
