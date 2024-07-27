<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolesAndPermissions extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::latest();
        if (!empty($request->get('search'))) {
            $roles = $roles->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('value', 'like', '%' . $request->get('search') . '%');
            });
        }
        $perPage = $request->get('perPage', 20);
        $roles = $roles->paginate($perPage);
        return view('roles.index', compact('roles'));
    }
    public function create()
    {
        $allPermissions = Permission::all();
    
    // Organize permissions into categories
    $permissions = [
        'departments' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Departments');
        }),
        'employees' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Employees');
        }),
        'clients' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Clients');
        }),
        'invoices' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Invoices');
        }),
        'payments' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Payments');
        }),
        'categories' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Categories');
        }),
        'services' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Services');
        }),
        'roles' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Roles');
        }),
        'settings' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Settings') || str_contains($permission->name, 'Dashboard');
        }),
      
    ];
        // $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'permissions' => 'array|nullable',
            'permissions.*' => 'exists:permissions,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $role = Role::create(['name' => $request->name]);
        if ($request->has('permissions')) {
            $permissions = $request->input('permissions');
            $validPermissions = Permission::whereIn('id', $permissions)->pluck('id');
            $role->syncPermissions($validPermissions);
        }

        return redirect()->route('roles')->with('success', 'Role Created Succcessfully.');
    }
    public function edit($id)
    {
        $role = Role::find($id);
        if (empty($role)) {
            Session::flash('error', 'No role Found!');
            return redirect()->back();
        }
        $allPermissions = Permission::all();
    
    // Organize permissions into categories
    $permissions = [
        'departments' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Departments');
        }),
        'employees' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Employees');
        }),
        'clients' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Clients');
        }),
        'invoices' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Invoices');
        }),
        'payments' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Payments');
        }),
        'categories' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Categories');
        }),
        'services' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Services');
        }),
        'roles' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Roles');
        }),
        'settings' => $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, 'Settings') || str_contains($permission->name, 'Dashboard');
        }),
       
    ];
        return view('roles.edit', compact('permissions', 'role'));
    }
    public function update($id, Request $request)
    {
        $role = Role::find($id);
        if (empty($role)) {
            Session::flash('error', 'No role Found!');
            return redirect()->back();
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'permissions' => 'array|nullable',
            'permissions.*' => 'exists:permissions,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $role->name = $request->name;
        $role->save();
        if ($request->has('permissions')) {
            $permissions = $request->input('permissions');
            $validPermissions = Permission::whereIn('id', $permissions)->pluck('id');
            $role->syncPermissions($validPermissions);
        } else {
            $role->syncPermissions([]); // Remove all permissions if none are selected
        }

        return redirect()->route('roles')->with('success', 'Role Updated Successfully.');
    }
    public function destroy($id)
    {
        $role = Role::find($id);
        if (empty($role)) {
           return response()->json([
            'status' => 'error',
            'message' => 'No role Found!',
           ],422);
        }
        $role->delete();
        Session::flash('success', 'Role Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Role Deleted Successfully'
        ]);
    }
}
