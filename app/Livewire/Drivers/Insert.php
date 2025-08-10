<?php

namespace App\Livewire\Drivers;

use App\Models\Driver;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Insert extends Component
{
    #[Validate('required')]
    public $nameDriver = '';

    #[Validate('required|unique:drivers,mobile')]
    public $mobile = '';

    #[Validate('nullable')]
    public $numcar = '';
    #[Validate('required|numeric|gt:1000')]
    public $taxiprice = 0;

    #[Validate('nullable')]
    public $address = '';

    public function store()
    {
        $validated = $this->validate();

        Driver::create([
            'nameDriver' => $validated['nameDriver'],
            'mobile' => $validated['mobile'],
            'numcar' => $validated['numcar'],
            'taxiprice' => $validated['taxiprice'],
            'address' => $validated['address'],
        ]);
        flash()->addSuccess('تم اضافة بنجاح.');

        return redirect()->route('driver.create');
    }

    public function render()
    {
        return view('livewire.drivers.insert');
    }
}
