<?php

namespace App\Livewire\Dashboards;

use App\Models\Sellinfo;
use Livewire\Component;
use Carbon\Carbon;

class Show extends Component
{
    // Card metrics
    public $totalpriceall = 0;
    public $weekSales = 0;
    public $countorder = 0;
    public $countordersale = 0;
    public $totalprice = 0;

    public $salesLabels = [];
    public $salesData = [];
    public $paymentLabels = [];
    public $paymentData = [];

    public function calculateTotal()
    {
        // Today sales
        $this->totalpriceall = Sellinfo::whereHas('invoice', function ($q) {
            $q->whereDate('date_sell', Carbon::today());
        })->sum('total_Price_invoice');

        // This week sales
        $this->weekSales = Sellinfo::whereHas('invoice', function ($q) {
            $q->whereBetween('date_sell', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        })->sum('total_Price_invoice');

        // Pending deliveries
        $this->countorder = Sellinfo::where('cash', 0)->count();

        // Today's orders
        $this->countordersale = Sellinfo::whereHas('invoice', function ($q) {
            $q->whereDate('date_sell', Carbon::today());
        })->count();

        // Total debt
        $this->totalprice = Sellinfo::where('cash', 0)
            ->whereHas('invoice')
            ->sum('total_price_afterDiscount_invoice');
    }

    public function loadSales7Days()
    {
        $startDate = Carbon::today()->subDays(6);
        $endDate = Carbon::today();

        $sales = Sellinfo::whereHas('invoice', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('date_sell', [$startDate, $endDate]);
        })->with('invoice')->get()
        ->groupBy(function ($item) {
            return Carbon::parse($item->invoice->date_sell)->format('Y-m-d');
        });

        $this->salesLabels = [];
        $this->salesData = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $label = $day->format('D'); // Mon, Tue...
            $this->salesLabels[] = $label;

            $dateKey = $day->format('Y-m-d');
            if (isset($sales[$dateKey])) {
                $this->salesData[] = $sales[$dateKey]->sum('total_Price_invoice');
            } else {
                $this->salesData[] = 0;
            }
        }
    }

    public function loadPaymentMethods()
    {
        $methods = Sellinfo::selectRaw('cash as method, SUM(total_Price_invoice) as total')
            ->groupBy('cash')
            ->get();

        $this->paymentLabels = [];
        $this->paymentData = [];

        foreach ($methods as $method) {
            $this->paymentLabels[] = $method->method == 1 ? 'Cash' : 'Credit Card';
            $this->paymentData[] = $method->total;
        }
    }

    public function mount()
    {
        $this->calculateTotal();
        $this->loadSales7Days();
        $this->loadPaymentMethods();
    }

    public function render()
    {
        return view('livewire.dashboards.show');
    }
}
