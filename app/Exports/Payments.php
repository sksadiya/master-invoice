<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Events\AfterSheet;

class Payments implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Payment::with('invoice')->get();
    }
    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Payment Date',
            'Invoice ID',
            'Client Name',
            'Payment Amount',
            'Payment Method',
        ];
    }
    /**
    * @param mixed $payment
    * @return array
    */
    public function map($payment): array
    {
        return [
           $payment->payment_date,
           $payment->invoice->invoice_number,
           $payment->invoice->client->first_name .' '. $payment->invoice->client->last_name,
           $payment->amount,
           $payment->payment_mode,
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
