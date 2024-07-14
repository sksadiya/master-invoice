<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::latest();

        if (!empty($request->get('search'))) {
            $products = $products->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('value', 'like', '%' . $request->get('search') . '%');
            });
        }

        $perPage = $request->get('perPage', 20);
        $products = $products->paginate($perPage);

        return view('product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name|min:2',
            'category' => 'required',
            'description' => 'nullable|min:10',
            'unit_price' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $success = $product->save();
        if ($success) {
            Session::flash('success', 'Product Created Successfully');
        } else {
            Session::flash('error', 'Product Creation Failed');
        }
        return redirect()->route('products');
    }
    public function edit($id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            Session::flash('error', 'No Product Found!');
            return redirect()->back();
        }
        $categories = Category::all();
        return view('product.edit', compact('categories', 'product'));
    }
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            Session::flash('error', 'No Product Found!');
            return redirect()->route('products');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|unique:products,name,' . $id,
            'category' => 'required',
            'description' => 'nullable|min:10',
            'unit_price' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $success = $product->save();
        if ($success) {
            Session::flash('success', 'Product Updated Successfully');
        } else {
            Session::flash('error', 'Product Update Failed');
        }
        return redirect()->route('products');
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            Session::flash('error', 'No Product Found!');
            return redirect()->back();
        }
        $product->delete();
        Session::flash('success', 'Product Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Product Deleted Successfully'
        ]);
    }
}
