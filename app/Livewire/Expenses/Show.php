<?php

namespace App\Livewire\Expenses;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Expense;
use Carbon\Carbon;

class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchName = '';
    public $createdAt;
    public $createdAt1;
    public $showResults = true;
    public $totalPrice = 0;
    public $searchTotalPrice = 0;

    // New properties for multi-select
    public $selectedExpenses = [];
    public $selectAll = false;
    public $bulkDate;
    public $showBulkModal = false;
    public $pageExpenseIds = [];

    public function mount()
    {
        $today = date('Y-m-d');
        $this->createdAt = $today;
        $this->createdAt1 = $today;
        $this->bulkDate = $today;
    }

    public function resetSearch()
    {
        $this->searchName = '';
        $this->createdAt = Carbon::today()->format('Y-m-d');
        $this->createdAt1 = Carbon::today()->format('Y-m-d');
        $this->showResults = true;
        $this->selectedExpenses = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function getdatabtdate()
    {
        $this->showResults = true;
        $this->resetPage();
    }

    // Delete expense function
    public function delete($id)
    {
        $expense = Expense::find($id);
        if ($expense) {
            $expense->delete();

            flash()->success('تم حذف المصروف بنجاح');
        }
    }

    // Toggle selection of all visible expenses
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedExpenses = $this->pageExpenseIds;
        } else {
            $this->selectedExpenses = [];
        }
    }

    // Update selected expenses when individual checkboxes change
    public function updatedSelectedExpenses()
    {
        $this->selectAll = count($this->selectedExpenses) === count($this->pageExpenseIds);
    }


    public function updateBulkDates()
    {
        if (empty($this->selectedExpenses) || !$this->bulkDate) {
            flash()->warning('لم يتم تحديد أي عناصر');

            return;
        }

        Expense::whereIn('id', $this->selectedExpenses)
            ->update(['created_at' => Carbon::parse($this->bulkDate)]);

        // Reset selection and close modal
        $this->selectedExpenses = [];
        $this->selectAll = false;
        $this->showBulkModal = false;
        $this->bulkDate = date('Y-m-d');

        // Show success message
        flash()->success('تم تحديث تواريخ العناصر المحددة بنجاح');
    }

    // Open bulk update modal
    public function openBulkModal()
    {
        if (empty($this->selectedExpenses)) {
            flash()->warning('لم يتم تحديد أي عناصر');

            return;
        }

        $this->showBulkModal = true;
    }

    // Close bulk update modal
    public function closeBulkModal()
    {
        $this->showBulkModal = false;
    }

    public function render()
    {
        if (!$this->showResults) {
            return view('livewire.expenses.show', ['expenses' => collect()]);
        }

        // Query with filters
        $query = Expense::query()
            ->whereDate('created_at', '>=', $this->createdAt)
            ->whereDate('created_at', '<=', $this->createdAt1)
            ->when($this->searchName, fn($q) => $q->where('name', 'like', '%' . $this->searchName . '%'))
            ->orderBy('created_at', 'desc');

        $expenses = $query->paginate(15);

        // Store current page expense IDs for select all functionality
        $this->pageExpenseIds = $expenses->pluck('id')->toArray();

        $this->totalPrice = Expense::whereDate('created_at', '>=', $this->createdAt)
            ->whereDate('created_at', '<=', $this->createdAt1)
            ->sum('price');

        $this->searchTotalPrice = Expense::whereDate('created_at', '>=', $this->createdAt)
            ->whereDate('created_at', '<=', $this->createdAt1)
            ->when($this->searchName, fn($q) => $q->where('name', 'like', '%' . $this->searchName . '%'))
            ->sum('price');

        return view('livewire.expenses.show', compact('expenses'));
    }
}
