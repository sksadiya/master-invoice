<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\invoiceItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Tax;
use App\Rules\GstNumber;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Invoices extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('client');
        if (!empty($request->get('search'))) {
            $invoices = $invoices->where('name', 'like', '%' . $request->get('search') . '%');
            $invoices = $invoices->where('value', 'like', '%' . $request->get('search') . '%');
        }
        $perPage = $request->get('perPage', 20);
        $invoices = $invoices->paginate($perPage);
        return view('invoices.index', compact('invoices'));
    }
    public function create()
    {
        $invoiceDate = Carbon::today()->toDateString(); // Today's date
        $dueDate = Carbon::today()->addDays(3)->toDateString(); // Today + 3 days
        $invoiceNumber = $this->generateInvoiceNumber();
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $clients = Client::all();
        $products = Product::all();
        $taxes = Tax::all();

        return view('invoices.create', compact('settings', 'clients', 'products', 'taxes', 'invoiceNumber', 'invoiceDate', 'dueDate'));
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
        // Fetch the invoice prefix from settings
        $invoicePrefix = Setting::where('key', 'invoice-prefix')->value('value');

        // If no prefix is set in the settings, use the default value
        if (!$invoicePrefix) {
            $invoicePrefix = '#SAS';
        }

        // Fetch the last invoice
        $lastInvoice = Invoice::latest()->first();

        if (!$lastInvoice) {
            $number = 1; // If no invoices exist yet, start with 1
        } else {
            // Extract the numeric part from the last invoice number
            $lastInvoiceNumber = intval(preg_replace('/[^0-9]/', '', $lastInvoice->invoice_number));
            $number = $lastInvoiceNumber + 1; // Increment the number
        }

        // Concatenate the prefix and the incremented number
        return $invoicePrefix . $number;
    }

    public function store(Request $request)
    {
        // $request = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'invoicenoInput' => 'required|unique:invoices,invoice_number',
            'invoice_date' => 'required|date|after_or_equal:today',
            'due_date' => 'required|date|after_or_equal:today',
            'invoice_status' => 'required|in:Unpaid,Paid,Partially_Paid,Overdue,Draft,Processing',
            'invoice_subtotal' => 'required',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:Fixed,Percentage',
            'final_amount' => 'required',
            'tax_id' => 'nullable',
            'tax_name' => 'nullable|numeric',
            'cart_tax' => 'nullable',
            'cart_discount' => 'nullable',
            'payment_type' => 'required|string',
            'notes' => 'nullable|min:10',
            'itemArray' => 'required|array',
            'client' => 'required',
            'product_id' => 'required|array',
            'product_rate' => 'required|array',
            'product_qty' => 'required|array',
            'product_item_total' => 'required|array',
            'fullname' => 'required',
            'clientEmail' => 'nullable|email|max:255',
            'companyAddress' => 'required',
            'company_postal_code' => 'required',
            'gst_number' => ['required', new GstNumber],
            'company_email' => 'required|email|max:255',
            'companyPhone' => 'required',
            'clientAddress' => 'required',
            'clientContact' => 'required',
            'clientGST' => ['required', new GstNumber],
        ]);
        $success = false;
        if ($validator->passes()) {
            $invoice = new Invoice();
            $invoice->client_id = $request->client;
            $invoice->invoice_number = $request->invoicenoInput;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->due_date = $request->due_date;
            $invoice->invoice_status = $request->invoice_status;
            $invoice->subtotal = $request->invoice_subtotal;
            $invoice->discount = $request->discount;
            $invoice->discount_type = $request->discount_type;
            $invoice->total = $request->final_amount;
            $invoice->tax_id = $request->tax_id;
            $invoice->tax = $request->tax_name;
            $invoice->tax_total = $request->cart_tax;
            $invoice->discount_total = $request->cart_discount;
            $invoice->note = $request->notes;
            $invoice->payment_method = $request->payment_type;
            $invoice->save();

            Setting::where('key', 'Address')->update(['value' => $request->companyAddress]);
            Setting::where('key', 'zip-code')->update(['value' => $request->company_postal_code]);
            Setting::where('key', 'GST-NO')->update(['value' => $request->gst_number]);
            Setting::where('key', 'company-email')->update(['value' => $request->company_email]);
            Setting::where('key', 'company-phone')->update(['value' => $request->companyPhone]);

            $invoiceItemsJSON = $request->input('itemArray')[0];

            // Decode the JSON string to get the array of invoice items
            $invoiceItems = json_decode($invoiceItemsJSON, true);

            // Debugging: Check the structure of the decoded array
            // dd($invoiceItems);
            if (is_array($invoiceItems)) {
                foreach ($invoiceItems as $item) {
                    // Ensure $item contains the necessary keys
                    if (isset($item['product_id'], $item['product_name'], $item['price'], $item['quantity'], $item['total'])) {
                        $invoiceItem = new InvoiceItem();
                        $invoiceItem->invoice_id = $invoice->id; // Assuming $invoice is defined
                        $invoiceItem->product_id = $item['product_id'];
                        $invoiceItem->product_name = $item['product_name'];
                        $invoiceItem->unit_price = $item['price']; // Assuming 'price' is mapped to 'rate'
                        $invoiceItem->quantity = $item['quantity'];
                        $invoiceItem->total = $item['total'];
                        $invoiceItem->save();
                    }
                }
            }

            $client = Client::find($request->client);
            if ($client) {
                $client->Address = $request->clientAddress;
                $client->contact = $request->clientContact;
                $client->GST = $request->clientGST;
                $client->email = $request->clientEmail;
                $client->save();
            }
            $success = true;
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($success) {
            Session::flash('success', 'Invoice Created Successfully');
        } else {
            Session::flash('error', 'Invoice Creation Failed');
        }
        return redirect()->route('invoices');
    }
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        if (empty($invoice)) {
            Session::flash('error', 'No Invoice found!');
            return redirect()->route('invoices');
        }
        $invoice->items()->delete();
        $invoice->delete();
        Session::flash('success', 'Invoice Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Invoice Deleted Successfully'
        ]);
    }

    public function edit(Request $request, $id)
    {
        $invoice = Invoice::with('items')->find($id);

        if (empty($invoice)) {
            Session::flash('error', 'No CLient found!');
            return redirect()->route('invoices');
        }

        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $clients = Client::all();
        $products = Product::all();
        $taxes = Tax::all();

        return view('invoices.edit', compact('invoice','settings','clients','products','taxes'));
    }

    public function update($id , Request $request) {
        // dd($request->all());
        $invoice = Invoice::with('items')->find($id);
        if (empty($invoice)) {
            Session::flash('error', 'No CLient found!');
            return redirect()->route('invoices');
        }

        $validator = Validator::make($request->all(), [
            'invoicenoInput' => 'required|unique:invoices,invoice_number,' . $invoice->id,
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'invoice_status' => 'required|in:Unpaid,Paid,Partially_Paid,Overdue,Draft,Processing',
            'invoice_subtotal' => 'required',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:Fixed,Percentage',
            'final_amount' => 'required',
            'tax_id' => 'nullable',
            'tax_name' => 'nullable|numeric',
            'cart_tax' => 'nullable',
            'cart_discount' => 'nullable',
            'payment_type' => 'required|string',
            'notes' => 'nullable|min:10',
            'itemArray' => 'required|array',
            'client' => 'required',
            'product_id' => 'required|array',
            'product_rate' => 'required|array',
            'product_qty' => 'required|array',
            'product_item_total' => 'required|array',
            'fullname' => 'required',
            'clientEmail' => 'nullable|email|max:255',
            'companyAddress' => 'required',
            'company_postal_code' => 'required',
            'gst_number' => ['required', new GstNumber],
            'company_email' => 'required|email|max:255',
            'companyPhone' => 'required',
            'clientAddress' => 'required',
            'clientContact' => 'required',
            'clientGST' => ['required', new GstNumber],
        ]);
        if ($validator->fails()) { 
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($validator->passes()) {
            $invoice->client_id = $request->client;
            $invoice->invoice_number = $request->invoicenoInput;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->due_date = $request->due_date;
            $invoice->invoice_status = $request->invoice_status;
            $invoice->subtotal = $request->invoice_subtotal;
            $invoice->discount = $request->discount;
            $invoice->discount_type = $request->discount_type;
            $invoice->total = $request->final_amount;
            $invoice->tax_id = $request->tax_id;
            $invoice->tax = $request->tax_name;
            $invoice->tax_total = $request->cart_tax;
            $invoice->discount_total = $request->cart_discount;
            $invoice->note = $request->notes;
            $invoice->payment_method = $request->payment_type;
            $invoice->save();

            Setting::where('key', 'Address')->update(['value' => $request->companyAddress]);
            Setting::where('key', 'zip-code')->update(['value' => $request->company_postal_code]);
            Setting::where('key', 'GST-NO')->update(['value' => $request->gst_number]);
            Setting::where('key', 'company-email')->update(['value' => $request->company_email]);
            Setting::where('key', 'company-phone')->update(['value' => $request->companyPhone]);

            $invoiceItemsJSON = $request->input('itemArray')[0];

            // Decode the JSON string to get the array of invoice items
            $invoiceItems = json_decode($invoiceItemsJSON, true);

            // Debugging: Check the structure of the decoded array
            // dd($invoiceItems);
            if (is_array($invoiceItems)) {
                InvoiceItem::where('invoice_id', $invoice->id)->delete();
                foreach ($invoiceItems as $item) {
                    // Ensure $item contains the necessary keys
                    if (isset($item['product_id'], $item['product_name'], $item['price'], $item['quantity'], $item['total'])) {
                        $invoiceItem = new InvoiceItem();
                        $invoiceItem->invoice_id = $invoice->id; // Assuming $invoice is defined
                        $invoiceItem->product_id = $item['product_id'];
                        $invoiceItem->product_name = $item['product_name'];
                        $invoiceItem->unit_price = $item['price']; // Assuming 'price' is mapped to 'rate'
                        $invoiceItem->quantity = $item['quantity'];
                        $invoiceItem->total = $item['total'];
                        $invoiceItem->save();
                    }
                }
            }

            $client = Client::find($request->client);
            if ($client) {
                $client->Address = $request->clientAddress;
                $client->contact = $request->clientContact;
                $client->GST = $request->clientGST;
                $client->email = $request->clientEmail;
                $client->save();
            }
            $success = true;
        } 
        if ($success) {
            Session::flash('success', 'Invoice Updated Successfully');
        } else {
            Session::flash('error', 'Invoice Updation Failed');
        }
        return redirect()->route('invoices');
    }

    
    public function show($id, Request $request)
    {
        $invoice = Invoice::with('items','client', 'client.city', 'client.state', 'client.country')->find($id);
        if (empty($invoice)) {
            Session::flash('error', 'No Invoice Found!');
            return redirect()->back();
        }
        
        return view('invoices.show',compact('invoice'));
    }
    public function downloadInvoice($id)
    {
        set_time_limit(300);
        $invoice = Invoice::with('items', 'client', 'client.city', 'client.state', 'client.country')->find($id);
        $pdf = Pdf::loadView('invoices.invoice_pdf', compact('invoice'));
        return $pdf->download('invoice.pdf');
    }
}
