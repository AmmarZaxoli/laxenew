<?php

namespace App\Exports;

use App\Models\Sell_invoice;
use Maatwebsite\Excel\Concerns\FromArray;

class GiftInvoicesExport implements FromArray
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

            if(count($row) == 8){
                $rows[] = $row;
                $row = [];
            }

        }

        if(!empty($row)){
            $rows[] = $row;
        }

        return $rows;
    }
}