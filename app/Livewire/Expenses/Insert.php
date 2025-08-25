<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Carbon\Carbon;

class Insert extends Component
{
    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required|numeric')]
    public $price = '';

    #[Validate('required')]
    public $namething = '';

    #[Validate('required|date')]
    public $createdAt = '';

    public function store()
    {
        $validated = $this->validate();

        // Create a new instance and manually assign attributes
        $expense = new Expense();
        $expense->timestamps = false; // disable automatic timestamps
        $expense->name       = $validated['name'];
        $expense->price      = $validated['price'];
        $expense->namething  = $validated['namething'];
        $expense->created_at = $validated['createdAt'];
        $expense->save();

        flash()->addSuccess('تم اضافة بنجاح');

        // Reset form fields
        $this->reset(['name', 'price', 'namething', 'createdAt']);
        $this->createdAt = date('Y-m-d'); // reset to today if desired
    }

    public function mount()
    {
        $this->createdAt = date('Y-m-d');
    }
    // Add this method to your Livewire component

    public function render()
    {
        return view('livewire.expenses.insert');
    }
}
