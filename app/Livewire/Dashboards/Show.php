<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;

class Show extends Component
{
    // Card metrics
    public $todaySales = "150,000";
    public $todayProfit = "15,000";
    public $totalDept = "50,000";
    public $todayDelivery = 24;
    public $todayOrders = 42;
    public $pendingDelivery = 8;
   

    public function render()
    {
        return view('livewire.dashboards.show');
    }
}