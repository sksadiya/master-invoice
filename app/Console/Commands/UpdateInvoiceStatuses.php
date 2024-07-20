<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class UpdateInvoiceStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update invoice statuses based on due date and payments';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = now(); // Get the current date

        // Fetch invoices where due_date is less than currentDate and due_amount > 0
        $invoices = Invoice::where('due_date', '<', $currentDate)
            ->where('due_amount', '>', 0)
            ->get();

        foreach ($invoices as $invoice) {
            $this->updateInvoiceStatus($invoice);
        }

        $this->info('Invoice statuses updated successfully.');
    }

    private function updateInvoiceStatus(Invoice $invoice)
    {
        $currentDate = now(); 
        if ($invoice->due_date < $currentDate && $invoice->due_amount > 0) {
            $invoice->invoice_status = 'Overdue';
        } else {
            if ($invoice->due_amount == 0) {
                $invoice->invoice_status = 'Paid';
            } elseif ($invoice->due_amount > 0 && $invoice->due_amount < $invoice->total) {
                $invoice->invoice_status = 'Partially_Paid';
            } else {
                $invoice->invoice_status = 'Unpaid';
            }
        }

        $invoice->save();
    }
}
