<?php

namespace App\Livewire\Expenses;

use Livewire\Component;
use App\Models\Expense;

class Edit extends Component
{
    public $expenseId;
    public $name;
    public $price;
    public $namething;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0.01',
        'namething' => 'required|string|max:500',
    ];

    protected $messages = [
        'name.required' => 'حقل الاسم مطلوب',
        'price.required' => 'حقل السعر مطلوب',
        'price.numeric' => 'يجب أن يكون السعر رقماً',
        'price.min' => 'يجب أن يكون السعر أكبر من الصفر',
        'namething.required' => 'حقل وصف المصروف مطلوب',
    ];

    public function mount($expenseId)
    {
        $this->expenseId = $expenseId;
        $this->loadExpense();
    }

    public function loadExpense()
    {
        $expense = Expense::findOrFail($this->expenseId);
        $this->name = $expense->name;
        $this->price = $expense->price;
        $this->namething = $expense->namething;
    }

    public function update()
    {

       
          $this->validate([
            'name' => 'required',
            'price' => 'required',
            'namething' => 'required',
          
        ]);

        $expense = Expense::findOrFail($this->expenseId);
        $expense->update([
            'name' => $this->name,
            'price' => $this->price,
            'namething' => $this->namething,
            
        ]);

        flash()->addSuccess('تم التحديث بنجاح.');
        return redirect()->route('expenses.create'); // update to your actual route
    }

    public function render()
    {
        return view('livewire.expenses.edit');
    }
}
