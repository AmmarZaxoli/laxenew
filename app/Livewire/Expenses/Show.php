<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchName = '';
    public $createdAt;
    public $updatedAt;
    public $showResults = false;

    public $errorMessage = null;
    public $successMessage = null;

    protected $rules = [
        'createdAt' => 'required|date',
        'updatedAt' => 'required|date|after_or_equal:createdAt',
    ];

    public function mount()
    {
        $today = now()->format('Y-m-d');
        $this->createdAt = $today;
        $this->updatedAt = $today;
        $this->showResults = true; // Show today's expenses by default
    }

    public function updatedSearchName()
    {
        $this->showResults = true;
        $this->resetPage();
    }

    public function resetSearch()
    {
        $today = now()->format('Y-m-d');
        $this->searchName = '';
        $this->createdAt = $today;
        $this->updatedAt = $today;
        $this->showResults = true;
        $this->resetPage();
        $this->dismissAlert();
    }

    public function loadExpenses()
    {
        $this->validate([
            'createdAt' => 'required|date',
            'updatedAt' => 'required|date|after_or_equal:createdAt',
        ], [
            'updatedAt.after_or_equal' => 'يجب أن يكون تاريخ النهاية بعد أو يساوي تاريخ البداية',
        ]);

        $this->showResults = true;
        $this->resetPage();
    }

    public function dismissAlert()
    {
        $this->reset(['errorMessage', 'successMessage']);
    }

    public function deleteExpense($id)
    {
        $expense = Expense::find($id);
        if (!$expense) {
            $this->errorMessage = 'المصروف غير موجود';
            return;
        }

        $expense->delete();

        $this->successMessage = 'تم الحذف بنجاح.';
        $this->loadExpenses();
    }

    // Total for filtered expenses
    public function getTotalPriceProperty()
    {
        if (!$this->showResults) return 0;

        return Expense::query()
            ->when($this->createdAt && $this->updatedAt, function ($q) {
                $q->where(function ($query) {
                    $query->whereBetween('created_at', [$this->createdAt, $this->updatedAt])
                          ->orWhereBetween('updated_at', [$this->createdAt, $this->updatedAt]);
                });
            })
            ->sum('price');
    }

    // Total for search results
    public function getSearchTotalPriceProperty()
    {
        return Expense::query()
            ->when($this->searchName, fn($q) => $q->where('name', 'like', '%' . $this->searchName . '%'))
            ->when($this->createdAt && $this->updatedAt, function ($q) {
                $q->where(function ($query) {
                    $query->whereBetween('created_at', [$this->createdAt, $this->updatedAt])
                          ->orWhereBetween('updated_at', [$this->createdAt, $this->updatedAt]);
                });
            })
            ->sum('price');
    }

    public function render()
    {
        $query = Expense::query()
            ->when($this->searchName, fn($q) => $q->where('name', 'like', '%' . $this->searchName . '%'))
            ->when($this->createdAt && $this->updatedAt, function ($q) {
                $q->where(function ($query) {
                    $query->whereBetween('created_at', [$this->createdAt, $this->updatedAt])
                          ->orWhereBetween('updated_at', [$this->createdAt, $this->updatedAt]);
                });
            });

        $expenses = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.expenses.show', [
            'expenses' => $expenses,
            'totalPrice' => $this->totalPrice,
            'searchTotalPrice' => $this->searchTotalPrice,
            'showResults' => $this->showResults,
        ]);
    }
}
