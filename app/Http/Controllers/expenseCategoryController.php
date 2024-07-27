<?php

namespace App\Http\Controllers;

use App\Models\expense_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class expenseCategoryController extends Controller
{
     public function index(Request $request) {
        $expenseCategories = expense_category::latest();

        if (!empty($request->get('search'))) {
            $expenseCategories = $expenseCategories->where('name', 'like', '%' . $request->get('search') . '%');
        }
        $perPage = $request->get('perPage', 20); 
        $expenseCategories = $expenseCategories->paginate($perPage);
        return view('expenseCategory.index', compact('expenseCategories'));
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:expense_categories,name'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $expenseCategory = new expense_category();
        $expenseCategory->name = $request->name;
        $expenseCategory->save();

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
        'name' => 'required|unique:expense_categories,name,'.$id,
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $expenseCategory = expense_category::findOrFail($id);
        $expenseCategory->name = $request->name;
        $expenseCategory->save();

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
            $expenseCategory = expense_category::findOrFail($id);
            $expenseCategory->delete();

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
