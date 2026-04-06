<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('orders.index', compact('orders'));
    }

   
    public function create()
    {
        return view('orders.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total'   => 'required|numeric|min:0',
            'status'  => 'required|in:pending,completed,cancelled',
        ]);

        Order::create($request->all());

        return view('orders.index', compact('orders'));
    }

    
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }


    public function update(Request $request, Order $order)
    {
        $request->validate([
            'total'   => 'required|numeric|min:0',
            'status'  => 'required|in:pending,completed,cancelled',
        ]);

        $order->update($request->all());

        return view('orders.index', compact('orders'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return view('orders.index', compact('orders'));
    }
}
