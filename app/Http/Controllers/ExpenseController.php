<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\expense_category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::latest();
        if (!empty($request->get('search'))) {
            $expenses = $expenses->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('value', 'like', '%' . $request->get('search') . '%');
            });
        }
        $perPage = $request->get('perPage', 20);
        $expenses = $expenses->paginate($perPage);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $categories = expense_category::all();
        $members = User::all();
        return view('expenses.create', compact('categories', 'members'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'category' => 'required|exists:expense_categories,id',
            'member' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'title' => 'required|min:3',
            'description' => 'nullable',
            'bill' => 'nullable|file',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $success = false;

        $expense = new Expense();
        $expense->title = $request->title;
        $expense->date = $request->date;
        $expense->expense_category_id = $request->category;
        $expense->team_member_id = $request->member;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        if ($request->file('bill')) {
            $bill = $request->file('bill');
            $billName = time() . '_' . uniqid() . '.' . $bill->getClientOriginalExtension();
            $billPath = public_path('/images/uploads/bills/');
            $bill->move($billPath, $billName);
            $expense->bill_file = $billName;
        }
        $expense->save();
        $success = true;
        if ($success) {
            return redirect()->route('expenses')
                ->with('success', 'Expense Created Successfully');
        } else {
            return redirect()->route('expenses')
                ->with('error', 'Failed to add Expense');
        }
    }
    public function edit($id)
    {
        $expense = Expense::find($id);
        if (empty($expense)) {
            Session::flash('error', 'No Expense found!');
            return redirect()->route('expenses');
        }
        $categories = expense_category::all();
        $members = User::all();
        return view('expenses.edit', compact('expense', 'categories', 'members'));
    }
    public function update(Request $request, $id)
    {
        $expense = Expense::find($id);
        if (empty($expense)) {
            Session::flash('error', 'No Expense found!');
            return redirect()->route('expenses');
        }
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'category' => 'required|exists:expense_categories,id',
            'member' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'title' => 'required|min:3',
            'description' => 'nullable',
            'bill' => 'nullable|file',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $success = false;
        $expense->title = $request->title;
        $expense->date = $request->date;
        $expense->expense_category_id = $request->category;
        $expense->team_member_id = $request->member;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        $fileBasePath = public_path('images/uploads/bills/');

        // Delete files from the specific directory
        if ($request->hasFile('bill')) {
            // Handle file upload
            $bill = $request->file('bill');
            $billName = time() . '_' . uniqid() . '.' . $bill->getClientOriginalExtension();
            $billPath = public_path('/images/uploads/bills/');

            // Move the new file to the destination
            if ($bill->move($billPath, $billName)) {
                // Delete the old file if it exists
                if ($expense->bill_file) {
                    $filePath = $fileBasePath . $expense->bill_file;
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
                // Update the expense record with the new file name
                $expense->bill_file = $billName;
            } else {
                // Handle the error (e.g., log it, set an error message, etc.)
                Session::flash('error', 'Failed to upload the new bill file.');
                return redirect()->back()->withInput();
            }
        }
        $expense->save();
        $success = true;
        if ($success) {
            Session::flash('success', 'Expense updated successfully!');
        } else {
            Session::flash('error', 'Failed to update expense!');
        }
        return redirect()->route('expenses');
    }
    public function destroy($id) {
        $expense = Expense::find($id);
        
        if (empty($expense)) {
            Session::flash('error', 'No Expense found!');
            return redirect()->route('expenses');
        }
        $success = false;
        $fileBasePath = public_path('images/uploads/documents/');
        if ($expense->bill_file) {
            $filePath = $fileBasePath . $expense->bill_file;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        $expense->delete();
        $success = true;
        if ($success) {
            Session::flash('success', 'Expense deleted successfully!');
        } else {
            Session::flash('error', 'Failed to delete expense!');
        }
        return redirect()->route('expenses');
    }
}
