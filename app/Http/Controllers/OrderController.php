<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * 🟢 CREATE order (auto-register guest if needed)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'emergency_phone' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'delivery_method' => 'required|string|max:100',
            'note' => 'nullable|string',
            'total_amount' => 'nullable|numeric|min:0',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|integer',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Check if authenticated user exists
        $user = auth()->user();

        // 🟣 Auto-register guest user with role_id = 5 if not logged in
        if (!$user && $request->email) {
            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => Hash::make(Str::random(10)),
                    'role_id' => 5, // 👈 Assign role ID = 5 (guest or customer)
                ]
            );
        }

        // Create the order
        $order = Order::create(array_merge($validated, [
            'user_id' => $user?->id,
        ]));

        // Add order items
        foreach ($validated['items'] as $item) {
            $order->items()->create($item);
        }

        return response()->json([
            'message' => 'Order placed successfully!',
            'order' => $order->load('items'),
        ], 201);
    }

    /**
     * 🟡 GET all orders
     */
    public function index()
    {
        $orders = Order::with('items.product')->latest()->get();
        return response()->json($orders);
    }

    /**
     * 🟠 GET single order by ID
     */
    public function show($id)
    {
        $order = Order::with('items.product')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    /**
     * 🔵 UPDATE order (basic info or status)
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->update($request->only([
            'name',
            'phone',
            'email',
            'emergency_phone',
            'country',
            'district',
            'city',
            'address',
            'delivery_method',
            'note',
            'total_amount',
            'status',
        ]));

        return response()->json([
            'message' => 'Order updated successfully!',
            'order' => $order->fresh('items'),
        ]);
    }

    /**
     * 🔴 DELETE order and related items
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully!']);
    }

    /**
     * 🟣 GET all orders for a specific user (if logged in)
     */
    public function userOrders($userId)
    {
        $orders = Order::with('items.product')->where('user_id', $userId)->latest()->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found for this user'], 404);
        }

        return response()->json($orders);
    }


  public function latestOrder(Request $request)
{
    // Check if user is logged in
    $user = auth()->user();

    // If logged in: fetch their most recent order
    if ($user) {
        $order = Order::with('items.product')
            ->where('user_id', $user->id)
            ->latest()
            ->first();
    } else {
        // If guest: get by email or phone if provided
        $email = $request->query('email');
        $phone = $request->query('phone');

        $order = Order::with('items.product')
            ->when($email, fn($q) => $q->where('email', $email))
            ->when($phone, fn($q) => $q->orWhere('phone', $phone))
            ->latest()
            ->first();
    }

    if (!$order) {
        return response()->json(['message' => 'No recent order found'], 404);
    }

    return response()->json([
        'message' => 'Latest order retrieved successfully',
        'order' => $order,
    ]);
}


}
