<?php

namespace App\Livewire\Drivers;

use App\Models\Driver;
use Livewire\Component;

class Show extends Component
{
     public $delete_id;

     public $editingDriverId = null;

    public function loadDriver($id)
    {
        $this->editingDriverId = $id;
    }

    protected $listeners = ['deleteConfirmed' => 'deleteType'];

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteType()
    {
        $driver = Driver::find($this->delete_id);
        if ($driver) {
            $driver->delete();
            $this->dispatch('TypeDelete');
        }
    }


    public function render()
    {
        $drivers = Driver::latest()->paginate(10);
        return view('livewire.drivers.show', compact('drivers'));
    }
}
