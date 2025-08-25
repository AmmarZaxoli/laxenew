<?php

namespace App\Livewire\Accounting;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sub_Buy_Products_invoice;

class Showbuyproduct extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $searchTerm = '';
    public $filter = '';
    public $isLoading = false;


    public $sortColumn = 'name'; // default column
    public $sortDirection = 'asc'; // asc or desc
    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            // Toggle direction
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearchTerm()
    {
        $this->resetPage(); // reset pagination when searching
    }

    public function updatingFilter()
    {
        $this->resetPage(); // reset pagination when filtering
    }

    public function render()
    {
        $query = Sub_Buy_Products_invoice::with(['buy_invoice', 'buy_products_invoice']);

        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('code', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('barcode', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('buy_products_invoice', function ($sub) {
                        $sub->where('name', 'like', '%' . $this->searchTerm . '%');
                    });
            });
        }

        if (!empty($this->filter)) {
            $query->where(function ($q) {
                $q->where('code', 'like', '%' . $this->filter . '%')
                    ->orWhere('barcode', 'like', '%' . $this->filter . '%')
                    ->orWhereHas('buy_products_invoice', function ($sub) {
                        $sub->where('name', 'like', '%' . $this->filter . '%');
                    });
            });
        }

        // Apply sorting
        $query->orderBy($this->sortColumn, $this->sortDirection);

        $filteredResults = $query->paginate(20);

        return view('livewire.accounting.showbuyproduct', [
            'filteredResults' => $filteredResults
        ]);
    }
}
