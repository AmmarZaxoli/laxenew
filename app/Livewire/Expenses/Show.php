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
    public $createdAt = '';
    public $updatedAt = '';
    public $showResults = false;

    public $name = '';
    public $price = '';
    public $namething = '';

    public $errorMessage = null;
    public $successMessage = null;

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
    public function mount()
{
    $today = now()->format('Y-m-d');
    if (!$this->createdAt) {
        $this->createdAt = $today;
    }
    if (!$this->updatedAt) {
        $this->updatedAt = $today;
    }
}

    public function updatedSearchName()
    {
        $this->showResults = true;
        $this->resetPage();
    }


    public function getCanLoadDataProperty()
    {
        return $this->createdAt && $this->updatedAt;
    }

    public function getShouldShowResultsProperty()
    {
        return $this->showResults || strlen($this->searchName) > 0;
    }

    public function resetSearch()
    {
        $this->reset(['searchName', 'createdAt', 'updatedAt']);
        $this->showResults = false;
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

        $this->errorMessage = null;
        $this->showResults = true;
        $this->resetPage();
    }

    protected $listeners = ['delete' => 'deleteExpense'];


    public function deleteExpense($id)
    {
        if (! $expense = Expense::find($id)) {
            $this->errorMessage = 'المصروف غير موجود';
            return;
        }

        $expense->delete();

        flash()->addSuccess('تم الحذف بنجاح.');
        $this->loadExpenses();
    }
    public function dismissAlert()
    {
        $this->reset(['errorMessage', 'successMessage']);
    }

    public function getSearchTotalPriceProperty()
    {
        return Expense::query()
            ->when($this->searchName, fn($q) => $q->where('name', 'like', '%' . $this->searchName . '%'))
            ->sum('price');
    }

    public function getTotalPriceProperty()
    {
        if (!$this->shouldShowResults) {
            return 0;
        }

        return Expense::query()
            ->when($this->createdAt, function ($q) {
                $q->where(function ($query) {
                    $query->whereDate('created_at', '>=', $this->createdAt)
                        ->orWhereDate('updated_at', '>=', $this->createdAt);
                });
            })
            ->when($this->updatedAt, function ($q) {
                $q->where(function ($query) {
                    $query->whereDate('created_at', '<=', $this->updatedAt)
                        ->orWhereDate('updated_at', '<=', $this->updatedAt);
                });
            })
            ->sum('price');
    }


    public function render()
    {
        $query = Expense::query()
            ->when($this->searchName, fn($q) => $q->where('name', 'like', '%' . $this->searchName . '%'));

        if ($this->shouldShowResults) {
            $query->when($this->createdAt, function ($q) {
                $q->where(function ($query) {
                    $query->whereDate('created_at', '>=', $this->createdAt)
                        ->orWhereDate('updated_at', '>=', $this->createdAt);
                });
            })->when($this->updatedAt, function ($q) {
                $q->where(function ($query) {
                    $query->whereDate('created_at', '<=', $this->updatedAt)
                        ->orWhereDate('updated_at', '<=', $this->updatedAt);
                });
            });
        }

        $expenses = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.expenses.show', [
            'expenses' => $expenses,
            'canLoadData' => $this->canLoadData,
            'totalPrice' => $this->totalPrice,
            'searchTotalPrice' => $this->searchTotalPrice,
            'showResults' => $this->shouldShowResults,
        ]);
    }
}
