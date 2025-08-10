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
        // When opening modal, set createdAt and updatedAt to today if empty
        $today = Carbon::today()->format('Y-m-d');
        $this->createdAt = $this->createdAt ?? $today;
        $this->updatedAt = $this->updatedAt ?? $today;
    } else {
        // When closing modal, reset dates (optional)
        $this->reset(['createdAt', 'updatedAt']);
    }

    $this->loadDrivers();
    $this->showModal = !$this->showModal;
}


    public function loadDrivers()
    {
        try {
            // Set default to today if no dates selected
            if (!$this->createdAt && !$this->updatedAt) {
                $startDate = Carbon::today()->startOfDay();
                $endDate = Carbon::today()->endOfDay();
            } 
            // Use selected dates if both are provided
            elseif ($this->createdAt && $this->updatedAt) {
                $startDate = Carbon::parse($this->createdAt)->startOfDay();
                $endDate = Carbon::parse($this->updatedAt)->endOfDay();
                
                // Ensure end date is after start date
                if ($endDate->lt($startDate)) {
                    $this->addError('dateFilter', 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية');
                    return;
                }
            }
            // Handle if only one date is provided
            else {
                $date = $this->createdAt ?: $this->updatedAt;
                $startDate = Carbon::parse($date)->startOfDay();
                $endDate = Carbon::parse($date)->endOfDay();
            }
$this->drivers = Driver::query()
    ->withCount(['invoices' => function ($query) use ($startDate, $endDate) {
        $query->whereHas('sell', function($q) use ($startDate, $endDate) {
            $q->where('cash', 0)
              ->whereBetween('created_at', [$startDate, $endDate]);
        });
    }])
    ->with(['invoices' => function($query) use ($startDate, $endDate) {
        $query->whereHas('sell', function($q) use ($startDate, $endDate) {
            $q->where('cash', 0)
              ->whereBetween('created_at', [$startDate, $endDate]);
        })->orderByDesc('date_sell')->limit(1); // latest invoice
    }])
    ->whereHas('invoices.sell', function($q) use ($startDate, $endDate) {
        $q->where('cash', 0)
          ->whereBetween('created_at', [$startDate, $endDate]);
    })
    ->orderBy('invoices_count', 'desc')
    ->get();


        } catch (\Exception $e) {
            Log::error("Error loading drivers: " . $e->getMessage());
            $this->addError('dateFilter', 'حدث خطأ أثناء تحميل البيانات');
        }
    }

    public function updated($property)
    {
        if (in_array($property, ['createdAt', 'updatedAt'])) {
            $this->validateDate($property);
            $this->loadDrivers();
        }
    }

    protected function validateDate($field)
    {
        if ($this->$field && !strtotime($this->$field)) {
            $this->addError($field, 'تاريخ غير صحيح');
            $this->$field = null;
            return false;
        }
        return true;
    }

    public function render()
    {
        return view('livewire.drivers.drivers-order');
    }
}