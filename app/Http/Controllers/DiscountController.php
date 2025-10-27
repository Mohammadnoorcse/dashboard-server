<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index() {
        return response()->json(Discount::all());
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'discountPrice' => 'required|numeric',
            'discountType' => 'nullable|in:percentage,fixed',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'status' => 'nullable|integer'
        ]);

        $discount = Discount::create([
            'name' => $request->name,
            'discountPrice' => $request->discountPrice,
            'discountType' => $request->discountType ?? 'percentage',
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'status' => $request->status ?? 1
        ]);

        return response()->json(['message' => 'Discount created', 'data' => $discount]);
    }

    public function update(Request $request, $id) {
        $discount = Discount::find($id);
        if(!$discount) return response()->json(['message' => 'Discount not found'], 404);

        $request->validate([
            'name' => 'nullable|string',
            'discountPrice' => 'nullable|numeric',
            'discountType' => 'nullable|in:percentage,fixed',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'status' => 'nullable|integer'
        ]);

        $discount->update([
            'name' => $request->name ?? $discount->name,
            'discountPrice' => $request->discountPrice ?? $discount->discountPrice,
            'discountType' => $request->discountType ?? $discount->discountType,
            'startDate' => $request->startDate ?? $discount->startDate,
            'endDate' => $request->endDate ?? $discount->endDate,
            'status' => $request->status ?? $discount->status
        ]);

        return response()->json(['message' => 'Discount updated', 'data' => $discount]);
    }

    public function destroy($id) {
        $discount = Discount::find($id);
        if(!$discount) return response()->json(['message' => 'Discount not found'], 404);
        $discount->delete();
        return response()->json(['message' => 'Discount deleted']);
    }

    public function show($id) {
        $discount = Discount::find($id);
        if(!$discount) return response()->json(['message' => 'Discount not found'], 404);
        return response()->json($discount);
    }
}
