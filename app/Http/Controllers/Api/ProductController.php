<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //  GET /api/v1/products?search=&category_id=&page=  عرض المنتجات مع دعم البحث والتصفية حسب التصنيف
    public function index(Request $request)
    {
        $query = Product::with('category', 'images')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10);

        return response()->json($products);
    }

    // GET /api/v1/products/{id} عرض تفاصيل منتج محدد
    public function show(Product $product)
    {
        return response()->json(
            $product->load('category', 'images') 
        );
    }

    //  POST /api/v1/admin/products  إضافة منتج جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|min:3|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string|min:10',
            'status'      => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'data'    => $product->load('category'),
        ], 201);
    }

    //  PATCH /api/v1/admin/products/{id}  تعديل منتج
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|min:3|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string|min:10',
            'status'      => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'data'    => $product->load('category'),
        ]);
    }

    //  DELETE /api/v1/admin/products/{id}  حذف منتج
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    //  POST /api/v1/admin/products/{id}/images رفع صور للمنتج
    public function uploadImages(Request $request, Product $product)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $uploadedImages = [];

        if(is_array($request->file('images'))) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public'); 

                $uploadedImages[] = ProductImage::create([
                    'product_id' => $product->product_id,
                    'image_path' => $path,
                ]);
            }
        }
     
        else if($request->hasFile('images')) {
            $image = $request->file('images');
            $path = $image->store('products', 'public');

            $uploadedImages[] = ProductImage::create([
                'product_id' => $product->product_id,
                'image_path' => $path,
            ]);
        }

        return response()->json([
            'message' => 'Images uploaded successfully',
            'data'    => $uploadedImages
        ], 201);
    }
}

