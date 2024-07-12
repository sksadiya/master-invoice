<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class categoryController extends Controller
{
    public function index(Request $request) {
        $categories = Category::latest();

        if (!empty($request->get('search'))) {
            $categories = $categories->where('name', 'like', '%' . $request->get('search') . '%');
        }
        $perPage = $request->get('perPage', 20); 
        $categories = $categories->paginate($perPage);
        return view('category.index', compact('categories'));
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:categories,name'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to add category. Please try again.',
        ], 500);
    }
}
public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:categories,name,'.$id,
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to update category. Please try again.',
        ], 500);
    }
}

public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete category. Please try again.',
            ], 500);
        }
    }
}
