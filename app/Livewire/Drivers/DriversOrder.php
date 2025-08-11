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
            $this->reset(['createdAt', 'updatedAt', 'drivers']);
        }

        $this->showModal = !$this->showModal;
    }

    public function filterByDate()
    {
        $this->loadDrivers();
    }

    public function loadDrivers()
    {
        try {
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

            // Query drivers with customer data filtered by date_sell
            $this->drivers = Driver::query()
                ->withCount(['customers as orders_count' => function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date_sell', [$startDate, $endDate]);
                }])
                ->with(['customers' => function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date_sell', [$startDate, $endDate])
                      ->orderByDesc('date_sell')
                      ->limit(1);
                }])
                ->whereHas('customers', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date_sell', [$startDate, $endDate]);
                })
                ->orderByDesc('orders_count')
                ->get();

        } catch (\Exception $e) {
            Log::error("Error loading drivers: " . $e->getMessage());
            $this->addError('dateFilter', 'حدث خطأ أثناء تحميل البيانات');
        }
    }

    public function render()
    {
        return view('livewire.drivers.drivers-order');
    }
}
