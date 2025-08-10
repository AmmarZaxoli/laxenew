<?php

namespace App\Livewire\Drivers;

use Livewire\Component;
use App\Models\Driver;

class Edit extends Component
{

    public $driverId;
    public $nameDriver, $mobile, $numcar, $taxiprice, $address;

    public function mount($driverId)
    {
        $this->driverId = $driverId;
        $driver = Driver::findOrFail($driverId);

        $this->nameDriver = $driver->nameDriver;
        $this->mobile = $driver->mobile;
        $this->numcar = $driver->numcar;
        $this->taxiprice = $driver->taxiprice;
        $this->address = $driver->address;
    }

    public function update()
    {
        $this->validate([
            'nameDriver' => 'required',
            'mobile' => 'required',
            'numcar' => 'nullable',
            'taxiprice' => 'required|numeric|min:1000',

            'address' => 'nullable',
        ]);

        $driver = Driver::findOrFail($this->driverId);
        $driver->update([
            'nameDriver' => $this->nameDriver,
            'mobile' => $this->mobile,
            'numcar' => $this->numcar,
            'taxiprice' => $this->taxiprice,
            'address' => $this->address,
        ]);

        flash()->addSuccess('تم التحديث بنجاح.');
        return redirect()->route('driver.create');
    }

    public function render()
    {
        return view('livewire.drivers.edit');
    }
}
