<?php


namespace App\Http\Controllers\Api;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   //  GET /api/v1/categories  عرض جميع الفئات
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return response()->json($categories);
    }

    //  POST /api/v1/admin/categories  إنشاء فئة جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000', 
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ], 201); 
    }

    //  PATCH /api/v1/admin/categories/{id}  تعديل فئة
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required', 
                'string',   
                'min:3',     
                'max:255',  
                Rule::unique('categories')->ignore($category->id), 
            ],
            'description' => 'nullable|string|max:1000', 
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    //  DELETE /api/v1/admin/categories/{id}  حذف فئة
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}

