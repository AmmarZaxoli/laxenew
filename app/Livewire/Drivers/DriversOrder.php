<?php

namespace App\Livewire\Drivers;

use Livewire\Component;
use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DriversOrder extends Component
{
    public $showModal = false;
    public $drivers = [];
    public $createdAt = null;
    public $updatedAt = null;
    public $totalOrders = 0; //  Total orders

    public function toggleModal()
    {
        if (!$this->showModal) {
            // Default dates to today when opening
            $today = Carbon::today()->format('Y-m-d');
            $this->createdAt = $this->createdAt ?? $today;
            $this->updatedAt = $this->updatedAt ?? $today;
            $this->loadDrivers();
        } else {
            // Reset on close
            $this->reset(['createdAt', 'updatedAt', 'drivers', 'totalOrders']);
        }

        $this->showModal = !$this->showModal;
    }

    public function filterByDate()
    {
        $this->loadDrivers();
    }

    public function loadDrivers()
{
  
        // Determine date range
        if (!$this->createdAt && !$this->updatedAt) {
            $startDate = Carbon::today()->startOfDay();
            $endDate = Carbon::today()->endOfDay();
        } elseif ($this->createdAt && $this->updatedAt) {
            $startDate = Carbon::parse($this->createdAt)->startOfDay();
            $endDate = Carbon::parse($this->updatedAt)->endOfDay();

            if ($endDate->lt($startDate)) {
                $this->addError('dateFilter', 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية');
                return;
            }
        } else {
            $date = $this->createdAt ?: $this->updatedAt;
            $startDate = Carbon::parse($date)->startOfDay();
            $endDate = Carbon::parse($date)->endOfDay();
        }

        //  Get drivers excluding "نقد"

$this->drivers = Driver::query()
    ->where('nameDriver', '!=', 'نقد')
    ->withCount(['sellinfos as orders_count' => function ($q) use ($startDate, $endDate) {
        $q->where('customers.date_sell', '>=', $startDate)
          ->where('customers.date_sell', '<=', $endDate)
          ->where('sells.cash', 0);
    }])
    ->having('orders_count', '>', 0)  
    ->orderByDesc('orders_count')
    ->get();



    

        $this->totalOrders = collect($this->drivers)->sum('orders_count');

   
}

    public function render()
    {
        return view('livewire.drivers.drivers-order');
    }
}
