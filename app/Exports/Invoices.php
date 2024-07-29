<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Events\AfterSheet;
class Invoices implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
            return Invoice::with('client')->get();
    }
     /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Invoice ID',
            'Client Name',
            'Invoice Date',
            'Invoice Amount',
            'Due Amount',
            'Due Date',
            'Status',
        ];
    }
    /**
    * @param mixed $invoice
    * @return array
    */
    public function map($invoice): array
    {
        return [
            $invoice->invoice_number,
            $invoice->client->first_name . ' ' . $invoice->client->last_name,
            $invoice->invoice_date,
            $invoice->total,
            $invoice->due_amount,
            $invoice->due_date,
            $invoice->invoice_status,
        ];
    }
    /**
    * @param Worksheet $sheet
    * @return void
    */
    public function styles(Worksheet $sheet)
    {
        // Set bold font for header
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // Center align the header text
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Set auto-width for columns
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }

    /**
    * @return array
    */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Example: Set background color for header row
                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'fill' => [
                        'fillType' => 'solid',
                        'color' => ['rgb' => 'D9EAD3'],
                    ],
                ]);
            },
        ];
    }
}
