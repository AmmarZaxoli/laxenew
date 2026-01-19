<?php

namespace App\Livewire\Products;


use Livewire\Component;
use App\Models\Type;
use App\Models\Product;
use App\Models\Sub_Buy_Products_invoice;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

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


    public $totalAvailableQty = 0;
    public $totalBuyPrice = 0;
    public $totalSellPrice = 0;
    private function calculateSums()
    {
        $items = Sub_Buy_Products_invoice::with('type')
            ->whereRaw('(quantity - q_sold) > 0')
            ->get();


        $this->totalAvailableQty = $items->sum(fn($item) => $item->available);

        $this->totalBuyPrice = $items->sum(
            fn($item) =>
            $item->available * $item->buy_price
        );

        $this->totalSellPrice = $items->sum(
            fn($item) =>
            $item->available * $item->sell_price
        );
    }
    public function render()
    {
        $this->calculateSums();
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
