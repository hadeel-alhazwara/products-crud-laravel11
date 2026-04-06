<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }


    public function create()
    {
        return view('products.create');
    }


    public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string|min:10',
                'status' => 'required|in:active,inactive',
            ]);
        

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

  
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255','name.required'=>'هذا الحقل مطلوب',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|min:10',
            'status' => 'required|in:active,inactive',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

  
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
