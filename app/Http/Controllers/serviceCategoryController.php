<?php

namespace App\Http\Controllers;

use App\Models\serviceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class serviceCategoryController extends Controller
{

         public function index(Request $request) {
        $categories = serviceCategory::latest();

        if (!empty($request->get('search'))) {
            $categories = $categories->where('name', 'like', '%' . $request->get('search') . '%');
        }
        $perPage = $request->get('perPage', 20); 
        $categories = $categories->paginate($perPage);
        return view('service_categories.index', compact('categories'));
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:service_categories,name'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $category = new serviceCategory();
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Service Category created successfully',
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
        'name' => 'required|unique:service_categories,name,'.$id,
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $category = serviceCategory::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Service Category updated successfully',
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
            $category = serviceCategory::findOrFail($id);
            $category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Service Category deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete category. Please try again.',
            ], 500);
        }
    }
}
