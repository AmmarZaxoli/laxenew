<?php

namespace App\Livewire\Expenses;

use Livewire\Component;
use App\Models\Expense;
use Carbon\Carbon;

class Edit extends Component
{
    public $expenseId;
    public $name;
    public $price;
    public $namething;
    public $created_at;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0.01',
        'namething' => 'required|string|max:500',
        'created_at' => 'required|date',
    ];

    protected $messages = [
        'name.required' => 'حقل الاسم مطلوب',
        'price.required' => 'حقل السعر مطلوب',
        'price.numeric' => 'يجب أن يكون السعر رقماً',
        'price.min' => 'يجب أن يكون السعر أكبر من الصفر',
        'namething.required' => 'حقل وصف المصروف مطلوب',
        'created_at.required' => 'حقل التاريخ مطلوب',
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

        // تنسيق التاريخ ليظهر بشكل صحيح في input type=datetime-local
        $this->created_at = Carbon::parse($expense->created_at)->format('Y-m-d\TH:i');
    }

    public function update()
    {
        $this->validate();

        $expense = Expense::findOrFail($this->expenseId);

        // تعطيل timestamps
        $expense->timestamps = false;

      
        $expense->name       = $this->name;
        $expense->price      = $this->price;
        $expense->namething  = $this->namething;
        $expense->created_at = Carbon::parse($this->created_at);

        $expense->save(); 

        flash()->addSuccess('تم التحديث بنجاح.');
        return redirect()->route('expenses.create');
    }


    public function render()
    {
        return view('livewire.expenses.edit');
    }
}
