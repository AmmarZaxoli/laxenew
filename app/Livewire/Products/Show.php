<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Type;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    protected $listeners = ['refreshTable' => '$refresh'];

    public $delete_id;
    public $types = [];
    public $selected_type = '';
    public $active_filter = null;
    public $search = '';

    public function mount()
    {
        $this->types = Type::all();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedType()
    {
        $this->resetPage();
    }


    public function filterActive($status)
    {
        $this->active_filter = ($status === '1') ? '1' : '0';
        $this->resetPage();
    }


    public function clearActiveFilter()
    {
        $this->active_filter = null;
        $this->resetPage();
    }
    public function render()
    {
        $products = Product::with(['definition', 'definition.type'])
            ->whereHas('definition', function ($query) {
                if ($this->search) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('code', 'like', "%{$this->search}%")
                        ->orWhere('barcode', 'like', "%{$this->search}%");
                }

                if (!is_null($this->active_filter)) {
                    $query->where('is_active', $this->active_filter === '1' ? '1' : '0');
                }

                if ($this->selected_type) {
                    $query->where('type_id', $this->selected_type);
                }
            })
            ->paginate(10);

        return view('livewire.products.show', compact('products'));
    }
}
