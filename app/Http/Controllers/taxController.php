<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class taxController extends Controller
{
    public function index(Request $request) {
        $taxes = Tax::latest();

        if (!empty($request->get('search'))) {
            $taxes = $taxes->where('name', 'like', '%' . $request->get('search') . '%');
            $taxes = $taxes->where('value', 'like', '%' . $request->get('search') . '%');
        }
        $perPage = $request->get('perPage', 20); 
        $taxes = $taxes->paginate($perPage);
        return view('tax.index', compact('taxes'));
    }
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:taxes,name',
        'value' => 'required|numeric|min:0|max:100'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $tax = new Tax();
        $tax->name = $request->name;
        $tax->value = $request->value;
        $tax->is_default = $request->is_default;
        $tax->save();

        return response()->json([
            'status' => true,
            'message' => 'Tax created successfully',
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to add tax. Please try again.',
            'error' => $e
        ], 500);
    }
}
public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:taxes,name,'.$id,
        'value' => 'required|numeric|min:0|max:100',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $tax = Tax::findOrFail($id);
        $tax->name = $request->name;
        $tax->value = $request->value;
        $tax->is_default = $request->is_default;
        $tax->save();

        return response()->json([
            'status' => true,
            'message' => 'Tax updated successfully',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to update tax. Please try again.',
        ], 500);
    }
}

public function destroy($id)
    {
        try {
            $tax = Tax::findOrFail($id);
            $tax->delete();

            return response()->json([
                'status' => true,
                'message' => 'Tax deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete tax. Please try again.',
                'error' => $e,
            ], 500);
        }
    }

    public function setDefaultTax(Request $request, $id)
    {
        try {
            // Set the current default tax to 0
            Tax::where('is_default', 1)->update(['is_default' => 0]);
    
            // Set the selected tax as the default
            $tax = Tax::findOrFail($id);
            $tax->is_default = $request->is_default;
            $tax->save();
    
            return response()->json(['success' => true, 'message' => 'Default tax updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while updating the default tax.']);
        }
    }
    
}
