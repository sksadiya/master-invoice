<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Tax;
use Illuminate\Http\Request;
use Carbon\Carbon;
class Invoices extends Controller
{
    public function index() {
        return view('invoices.index');
    }
    public function create() {
        $invoiceDate = Carbon::today()->toDateString(); // Today's date
        $dueDate = Carbon::today()->addDays(3)->toDateString(); // Today + 3 days
        $invoiceNumber = $this->generateInvoiceNumber();
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $clients = Client::all();
        $products = Product::all();
        $taxes = Tax::all();

        return view('invoices.create',compact('settings','clients','products','taxes','invoiceNumber','invoiceDate','dueDate'));
    } 
    public function fetchClient($id)
    {
        $client = Client::where('id', $id)->get();

        return response()->json([
            'status' => true,
            'client' => $client
        ]);
    }
    private function generateInvoiceNumber()
    {
        // Logic to generate a unique invoice number
        $lastInvoice = Invoice::latest()->first();

        if (!$lastInvoice) {
            $number = 1; // If no invoices exist yet, start with 1
        } else {
            $number = $lastInvoice->invoice_number + 1; // Increment the number
        }

        return $number;
    }

    public function store(Request $request) {
        $requests = $request->all();
        dd($requests);
    }
}
