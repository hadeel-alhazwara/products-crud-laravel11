<?php
namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin(); 
        $orders = Order::with('user')->latest()->paginate(10);

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1', 
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.qty' => 'required|integer|min:1',
            'address.city' => 'required|string', 
            'address.street' => 'required|string', 
        ]);

        $total = 0;
        foreach ($request->items as $item) {
            $product = \App\Models\Product::findOrFail($item['product_id']); 
            $total += $product->price * $item['qty']; 
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total'   => $total,
            'status'  => 'pending',
            'items'   => $request->items,  
            'address' => $request->address, 
        ]);

        return response()->json([
            'message' => 'Order created successfully',
            'data'    => $order
        ], 201);
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id()) 
                        ->latest()
                        ->paginate(10);

        return response()->json($orders);
    }

   
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !$this->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($order->load('user'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled,paid',
        ]);

        $order->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'message' => 'Order status updated successfully',
            'data'    => $order
        ]);
    }

    public function destroy(Order $order)
    {
        $this->authorizeAdmin();

        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }

    private function isAdmin()
    {
        return Auth::user() && Auth::user()->role === 'Admin';
    }

    private function authorizeAdmin()
    {
        if (!$this->isAdmin()) {
            abort(response()->json(['error' => 'Unauthorized'], 403));
        }
    }
}

