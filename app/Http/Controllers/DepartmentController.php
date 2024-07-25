<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index(Request $request) {
        $departments = Department::withCount('employees')->latest();

        if (!empty($request->get('search'))) {
            $departments = $departments->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('value', 'like', '%' . $request->get('search') . '%');
            });
        }
        $perPage = $request->get('perPage', 20); 
        $departments = $departments->paginate($perPage);
        return view('departments.index', compact('departments'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departments,name',
            'description' => 'nullable|min:10'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $department = new Department();
            $department->name = $request->name;
            $department->description = $request->description;
            $department->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Department created successfully',
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to add Department. Please try again.',
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departments,name,'.$id,
            'description' => 'nullable|min:10',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $department = Department::findOrFail($id);
            $department->name = $request->name;
            $department->description = $request->description;
            $department->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Department updated successfully',
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update Department. Please try again.',
            ], 500);
        }
    }
    
    public function destroy($id)
        {
            try {
                $department = Department::findOrFail($id);
                $department->delete();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Department deleted successfully',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to delete department. Please try again.',
                ], 500);
            }
        }
}
