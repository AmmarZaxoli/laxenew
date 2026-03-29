<?php

namespace App\Exports;

use App\Models\Sell_invoice;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class GiftInvoicesExport implements FromArray, WithColumnWidths, WithEvents
{
    protected $date_from;
    protected $date_to;

    public function __construct($date_from, $date_to)
    {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function array(): array
    {
        $numbers = Sell_invoice::where('selling',1)

            ->when($this->date_from, function ($q) {
                $q->whereDate('date_sell','>=',$this->date_from);
            })

            ->when($this->date_to, function ($q) {
                $q->whereDate('date_sell','<=',$this->date_to);
            })

            ->pluck('num_invoice_sell')
            ->toArray();

        $rows = [];
        $row = [];

        foreach ($numbers as $num) {

            $row[] = $num;

            if(count($row) == 5){
                $rows[] = $row;
                $row = [];
            }
        }

        if(!empty($row)){
            $rows[] = $row;
        }

        return $rows;
    }

    // column width
    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 25,
        ];
    }

    // row height
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                for ($i = 1; $i <= 200; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(40);
                }

                // center + bold
                $event->sheet->getDelegate()->getStyle('A1:E200')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin'
                        ]
                    ]
                ]);
            },
        ];
    }
}