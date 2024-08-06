<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Intervention\Image\Laravel\Facades\Image;
class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::with('user','department')->latest();
        // return dd($employees);
        if (!empty($request->get('search'))) {
            $employees = $employees->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('value', 'like', '%' . $request->get('search') . '%');
            });
        }
        $perPage = $request->get('perPage', 20);
        $employees = $employees->paginate($perPage);
        return view('employee.index', compact('employees'));
    }

    public function create() {
        $countries = Country::all();
        $departments = Department::all();
        $roles = Role::all();
        return view('employee.create',compact('countries','departments','roles'));
    }

    public function store(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'full_name' => 'required|min:3',
            'email' => 'required|email|max:255|unique:users,email',
            'region_code' => 'required',
            'contact' => 'required|numeric',
            'alt_contact' => 'nullable|numeric',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,id',
            'dept' => 'required|exists:departments,id',
            'address' => 'nullable',
            'country' => 'nullable|exists:countries,id',
            'state' => 'nullable|exists:states,id',
            'city' => 'nullable|exists:cities,id',
            'pincode' => 'nullable',
            'pan' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'adhar' => 'nullable|regex:/^\d{12}$/',
            'acc_holder_name' => 'nullable|string|max:255',
            'acc_number' => 'nullable|digits_between:9,18',
            'ifsc' => 'nullable|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'bank_name' => 'nullable|string|max:255',
            'pan_file' => 'nullable|file',
            'adhar_file' => 'nullable|file',
            'passbook' => 'nullable|file',
            'salary' => 'nullable|numeric'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $success =  false;
        $user = new User();
        $user->name = $request->full_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->region_code = $request->region_code;
        $user->contact = $request->contact;
        $user->role = 2;
        $user->save();

        try {
            $role = Role::findById($request->role);
            $user->syncRoles([$role]);
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            return redirect()->back()->withErrors(['error' => 'The selected role does not exist.'])->withInput();
        }
        $employee = new Employee();
        $employee->user_id = $user->id;
        $employee->dept_id = $request->dept;
        $employee->address = $request->address;
        $employee->alt_contact = $request->alt_contact;
        $employee->country_id = $request->country;
        $employee->state_id = $request->state;
        $employee->city_id = $request->city;
        $employee->pincode = $request->pincode;
        $employee->pan = $request->pan;
        $employee->adhar = $request->adhar;
        $employee->acc_holder_name = $request->acc_holder_name;
        $employee->ifsc = $request->ifsc;
        $employee->acc_number = $request->acc_number;
        $employee->bank_name = $request->bank_name;
        $employee->salary = $request->salary;

        if ($request->file('passbook')) {
            $passbook = $request->file('passbook');
            $passbookName = time() . '_' . uniqid() . '.' . $passbook->getClientOriginalExtension();
            $passbookPath = public_path('/images/uploads/documents/');
            $passbook->move($passbookPath, $passbookName);
            $employee->passbook =  $passbookName;
        }
        if ($request->file('pan_file')) {
            $pan_file = $request->file('pan_file');
            $pan_fileName = time() .'_'. uniqid() .'.' . $pan_file->getClientOriginalExtension();
            $pan_filePath = public_path('/images/uploads/documents/');
            $pan_file->move($pan_filePath, $pan_fileName);
            $employee->pan_file =  $pan_fileName;
        }
        if ($request->file('adhar_file')) {
            $adhar_file = $request->file('adhar_file');
            $adhar_fileName = time() . '_' . uniqid() . '.' . $adhar_file->getClientOriginalExtension();
            $adhar_filePath = public_path('/images/uploads/documents/');
            $adhar_file->move($adhar_filePath, $adhar_fileName);
            $employee->adhar_file =  $adhar_fileName;
        }
        $employee->save();
        $success = true;
        if($success) {
            Session::flash('success','Employee Added Successfully');
        } else {
            Session::flash('success','Failed to Employee');
        }
        return redirect()->route('employees');
    }

    public function edit(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (empty($employee)) {
            Session::flash('error', 'No Employee found!');
            return redirect()->route('employees');
        }
        $countries = Country::all();
        $departments = Department::all();
        $roles = Role::all();
        return view('employee.edit', compact('employee', 'countries','departments','roles'));
    }

    public function update($id ,Request $request) {
        $employee = Employee::find($id);

        if (empty($employee)) {
            Session::flash('error', 'No Employee found!');
            return redirect()->route('employees');
        }
        $validator = Validator::make($request->all(),[
            'full_name' => 'required|min:3',
            'email' => 'required|email|max:255|unique:users,email,' . $employee->user_id,
            'region_code' => 'required',
            'contact' => 'required|numeric',
            'alt_contact' => 'nullable|numeric',
            'password' => 'nullable|min:6',
            'role' => 'required|exists:roles,id',
            'dept' => 'required|exists:departments,id',
            'address' => 'nullable',
            'country' => 'nullable|exists:countries,id',
            'state' => 'nullable|exists:states,id',
            'city' => 'nullable|exists:cities,id',
            'pincode' => 'nullable',
            'pan' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'adhar' => 'nullable|regex:/^\d{12}$/',
            'acc_holder_name' => 'nullable|string|max:255',
            'acc_number' => 'nullable|digits_between:9,18',
            'ifsc' => 'nullable|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'bank_name' => 'nullable|string|max:255',
            'pan_file' => 'nullable|file',
            'adhar_file' => 'nullable|file',
            'passbook' => 'nullable|file',
            'salary' => 'nullable|numeric'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $success =  false;
        $user = $employee->user;
        $user->name = $request->full_name;
        $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        $user->region_code = $request->region_code;
        $user->contact = $request->contact;
        // $user->role = 2;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $role = Role::findById($request->role);
        $user->syncRoles([$role]);
        $employee->dept_id = $request->dept;
        $employee->address = $request->address;
        $employee->alt_contact = $request->alt_contact;
        $employee->country_id = $request->country;
        $employee->state_id = $request->state;
        $employee->city_id = $request->city;
        $employee->pincode = $request->pincode;
        $employee->pan = $request->pan;
        $employee->adhar = $request->adhar;
        $employee->acc_holder_name = $request->acc_holder_name;
        $employee->ifsc = $request->ifsc;
        $employee->acc_number = $request->acc_number;
        $employee->bank_name = $request->bank_name;
        $employee->salary = $request->salary;

        $fileBasePath = public_path('images/uploads/documents/');
        if ($request->file('passbook')) {
            if ($employee->passbook) {
                $filePath = $fileBasePath . $employee->passbook;
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
            $passbook = $request->file('passbook');
            $passbookName = time() . '_' . uniqid() . '.' . $passbook->getClientOriginalExtension();
            $passbookPath = public_path('/images/uploads/documents/');
            $passbook->move($passbookPath, $passbookName);
            $employee->passbook =  $passbookName;
        }

        if ($request->file('pan_file')) {
            if ($employee->pan_file) {
                $filePath = $fileBasePath . $employee->pan_file;
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
            $pan_file = $request->file('pan_file');
            $pan_fileName = time() . '_' . uniqid() . '.' . $pan_file->getClientOriginalExtension();
            $pan_filePath = public_path('/images/uploads/documents/');
            $pan_file->move($pan_filePath, $pan_fileName);
            $employee->pan_file =  $pan_fileName;
        }
        if ($request->file('adhar_file')) {
            if ($employee->adhar_file) {
                $filePath = $fileBasePath . $employee->adhar_file;
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
            $adhar_file = $request->file('adhar_file');
            $adhar_fileName = time() . '_' . uniqid() . '.' . $adhar_file->getClientOriginalExtension();
            $adhar_filePath = public_path('/images/uploads/documents/');
            $adhar_file->move($adhar_filePath, $adhar_fileName);
            $employee->adhar_file =  $adhar_fileName;
        }
        $employee->save();
        $success = true;
        if($success) {
            Session::flash('success','Employee Updated Successfully');
        } else {
            Session::flash('success','Failed to Employee');
        }
        return redirect()->route('employees');
    }
    public function destroy($id) {
        $employee = Employee::find($id);
        if (empty($employee)) {
            Session::flash('error', 'No employee found!');
            return redirect()->route('employees');
        }
        $fileBasePath = public_path('images/uploads/documents/');

    // Delete files from the specific directory
    if ($employee->passbook) {
        $filePath = $fileBasePath . $employee->passbook;
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }
    if ($employee->pan_file) {
        $filePath = $fileBasePath . $employee->pan_file;
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }
    if ($employee->adhar_file) {
        $filePath = $fileBasePath . $employee->adhar_file;
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }
    $employee->user()->delete();
        $employee->delete();
        Session::flash('success', 'employee Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'employee Deleted Successfully'
        ]);
    }

    public function show($id, Request $request)
    {
        $employee = Employee::with('user','expenses')->find($id);
        if (empty($employee)) {
            Session::flash('error', 'No Employee Found!');
            return redirect()->back();
        }
        $expenses = $employee->expenses;
        $country = Country::find($employee->country_id);
        $state = State::find($employee->state_id);
        $city = City::find($employee->city_id);
   
        return view('employee.show', compact('employee','country','state','city','expenses'));
    }
}
