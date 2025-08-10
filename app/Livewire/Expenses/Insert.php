<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Insert extends Component
{
    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required|numeric')]
    public $price = '';

    #[Validate('required')]
    public $namething = '';

    public function store()
    {
        $validated = $this->validate();

        Expense::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'namething' => $validated['namething'],

        ]);
        flash()->addSuccess('تم اضافة بنجاح');

        return redirect()->route('expenses.create');
    }
    // Add this method to your Livewire component
    public function resetForm()
    {
        $this->reset(['name', 'price', 'namething']);
        $this->resetErrorBag(); // Clears validation errors
    }
    public function render()
    {
        return view('livewire.expenses.insert');
    }
}
