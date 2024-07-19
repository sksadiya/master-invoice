<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Payments extends Controller
{
    public function index()
    {

        return view('payments.index');
    }
    public function create()
    {

    }
    public function store(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'invoice' => 'required|exists:invoices,id',
        'Payment_method' => 'required|string',
        'payment_date' => 'required|date',
        'payment_note' => 'nullable|string',
        'payment_amount' => [
            'required',
            'numeric',
            'min:0',
            'regex:/^\d+(\.\d{1,2})?$/', // Minimum value of 0
            function ($attribute, $value, $fail) use ($request) {
                // Find the invoice
                $invoice = Invoice::find($request->invoice);

                if (!$invoice) {
                    $fail('Invoice not found.');
                    return;
                }

                // Calculate the due amount before saving the new payment
                $previousPayments = $invoice->payments()->sum('amount');
                $dueAmountBeforePayment = max($invoice->total - $previousPayments, 0);

                // Ensure the payment amount does not exceed the due amount
                if ($value > $dueAmountBeforePayment) {
                    $fail('The payment amount exceeds the due amount.');
                }
            }
        ]
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Find the invoice
    $invoice = Invoice::find($request->invoice);

    if (!$invoice) {
        return response()->json([
            'status' => false,
            'message' => 'Invoice not found'
        ], 404);
    }

    // Calculate the due amount before saving the new payment
    $previousPayments = $invoice->payments()->sum('amount');
    $dueAmountBeforePayment = max($invoice->total - $previousPayments, 0);

    // Check if due amount is zero
    if ($dueAmountBeforePayment <= 0) {
        return response()->json([
            'status' => false,
            'message' => 'The invoice is already fully paid. No additional payments can be made.'
        ], 400);
    }

    // Ensure the payment amount does not exceed the due amount
    $paymentAmount = min($request->payment_amount, $dueAmountBeforePayment);

    // Create and save the payment
    $payment = new Payment();
    $payment->invoice_id = $request->invoice;
    $payment->payment_mode = $request->Payment_method;
    $payment->payment_date = $request->payment_date;
    $payment->notes = $request->payment_note;
    $payment->amount = $paymentAmount;
    $payment->due_payment = $dueAmountBeforePayment - $paymentAmount;
    $payment->save();

    // Update the invoice's due amount
    $newDueAmount = $dueAmountBeforePayment - $paymentAmount;
    $invoice->due_amount = max($newDueAmount, 0);

    if ($invoice->due_amount == 0) {
        $invoice->invoice_status = 'Paid';
    } elseif ($invoice->due_amount > 0 && $invoice->due_amount < $invoice->total) {
        $invoice->invoice_status = 'Partially_Paid';
    } else {
        $invoice->invoice_status = 'Unpaid'; // You can also handle other statuses if needed
    }

    $invoice->save();

    return response()->json([
        'status' => true,
        'message' => 'Payment saved and invoice updated successfully!',
        'due_amount' => $invoice->due_amount
    ]);
}

}
