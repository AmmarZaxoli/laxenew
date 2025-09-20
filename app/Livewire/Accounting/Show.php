<?php

namespace App\Livewire\Accounting;

use App\Models\Sellinfo;
use App\Models\Customer;
use App\Models\Expense;
use Livewire\Component;

class Show extends Component
{

    public $startdate;
    public $enddate;
    public $total = 0;
    public $totalpriceall = 0;
    public $totalreligion = 0;
    public $totalafterdiscount = 0;
    public $totaldiscount = 0;

    public $totalProfitafterdiscount = 0;
    public $expense = 0;
    public function mount()
    {
        $this->startdate = now()->format('Y-m-d');
        $this->enddate   = now()->format('Y-m-d');
    }
    public function calculateTotal()
    {




        $this->totalpriceall = Sellinfo::whereHas('invoice', function ($q) {
            $q->whereDate('date_sell', '>=', $this->startdate)
                ->whereDate('date_sell', '<=', $this->enddate);
        })
            ->sum('total_Price_invoice');

        $this->total = Sellinfo::where('cash', 0)
            ->whereHas('invoice', function ($q) {
                $q->whereDate('date_sell', '>=', $this->startdate)
                    ->whereDate('date_sell', '<=', $this->enddate);
            })
            ->sum('total_Price_invoice');

        $this->totalreligion = Sellinfo::where('cash', 0)
            ->whereHas('invoice', function ($q) {
                $q->whereDate('date_sell', '>=', $this->startdate)
                    ->whereDate('date_sell', '<=', $this->enddate);
            })
            ->sum('total_Price_invoice');





        $this->totalafterdiscount = Sellinfo::where('cash', 1)
            ->whereHas('invoice', function ($q) {
                $q->whereDate('date_sell', '>=', $this->startdate)
                    ->whereDate('date_sell', '<=', $this->enddate);
            })
            ->sum('total_price_afterDiscount_invoice');


        $this->totaldiscount = Sellinfo::where('cash', 0)
            ->whereHas('invoice', function ($q) {
                $q->whereDate('date_sell', '>=', $this->startdate)
                    ->whereDate('date_sell', '<=', $this->enddate);
            })
            ->sum('discount');





        $this->totalProfitafterdiscount = Customer::whereDate('date_sell', '>=', $this->startdate)
            ->whereDate('date_sell', '<=', $this->enddate)
            ->whereHas('sellInvoice', function ($q) {
                $q->whereHas('sell', function ($q2) {
                    $q2->where('cash', 1);
                });
            })
            ->sum('profit_invoice_after_discount');


        $this->expense = Expense::whereDate('created_at', '>=', $this->startdate)
            ->whereDate('created_at', '<=', $this->enddate)
            ->sum('price');
    }
    public function render()
    {
        return view('livewire.accounting.show');
    }
}
