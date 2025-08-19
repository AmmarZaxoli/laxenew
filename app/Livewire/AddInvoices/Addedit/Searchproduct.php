<?php

namespace App\Livewire\AddInvoices\Addedit;

use Livewire\Component;

use App\Models\Definition;
use App\Models\Buy_Products_invoice;

class Searchproduct extends Component
{
    protected $listeners = ['clearSearchAndFocus'];
    public $search = '';
    public $product_id = '';
    public $name = '';
    public $code = '';
    public $type_id = '';
    public $showDropdown = false;
    public $selectedProduct = null;
    public $showCreateModal = false;
    public $isHandlingNotFound = false;
    public $purchases = [];




    public function clearSearchAndFocus()
    {
        $this->resetSearch();
        $this->dispatch('browser:focus-search-input');
    }

    // Reset search input
    public function resetSearch()
    {
        $this->search = '';
        $this->showDropdown = false;
        $this->selectedProduct = null;
    }

    // Clear selected product
    public function clearSelection()
    {
        $this->selectedProduct = null;
        $this->search = '';
        $this->showDropdown = false;
    }

    public function updatedSearch($value)
    {
        $this->showDropdown = is_string($value) && strlen($value) >= 1;
        $this->selectedProduct = null;
        $this->isHandlingNotFound = false;

        // Auto-select if barcode exists exactly
        if (strlen($value) >= 3) {
            $product = Definition::where('barcode', $value)->first();
            if ($product) {
                $this->selectProduct($product->id);
                return;
            }
        }

        // If not matched, check for no results
        $this->checkForNoResults();
    }


    public function getResultsProperty()
    {
        if (!is_string($this->search)) {
            return collect();
        }

        return Definition::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('code', 'like', '%' . $this->search . '%')
                ->orWhere('barcode', 'like', '%' . $this->search . '%');
        })
            ->where('is_active', '1')
            ->whereHas('products')
            ->withCount('products')
            ->limit(7)
            ->get();
    }


    public function selectProduct($product_id)
    {
        // Find the product definition
        $this->selectedProduct = Definition::find($product_id);

        if (!$this->selectedProduct) {
            $this->dispatch('notify', type: 'error', message: 'Product not found!');
            return;
        }

        // Get only the purchase with the highest ID for this product
        // Load latest 10 purchases with related buy_invoice
        $this->purchases = Buy_Products_invoice::with('buy_invoice')
            ->where('product_id', $product_id)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();









        // Set product properties
        $this->search = $this->selectedProduct->barcode;
        $this->product_id = $this->selectedProduct->id;
        $this->name = $this->selectedProduct->name;
        $this->code = $this->selectedProduct->code;
        $this->type_id = $this->selectedProduct->type_id;
        $this->showDropdown = false;

        // Dispatch events
        $this->dispatch('productSelected', product: $this->selectedProduct);
        $this->dispatch('productSelected', [
            'id' => $this->product_id,
            'name' => $this->name,
            'code' => $this->code,
            'barcode' => $this->search,
            'type_id' => $this->type_id,
        ])->to('add-invoices.insert');
    }

    public function checkForNoResults()
    {
        if (
            !$this->isHandlingNotFound &&
            is_string($this->search) &&
            strlen($this->search) >= 1 &&
            $this->results->isEmpty()
        ) {
            $this->isHandlingNotFound = true;
            $this->dispatch('show-product-not-found-alert', searchTerm: $this->search);
        }
    }

    public function handleConfirmedAddProduct($productName)
    {
        $this->search = $productName;
        $this->openCreateModal();
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
        $this->isHandlingNotFound = false;
    }

    public function handleCancelAddProduct()
    {
        $this->isHandlingNotFound = false;
    }

    public function handleDefinitionCreated($definitionId)
    {
        $this->showCreateModal = false;
        $this->selectProduct($definitionId);
        $this->dispatch('notify', type: 'success', message: 'Product added successfully!');
    }

    public function render()
    {
        return view('livewire.add-invoices.addedit.searchproduct', [
            'definitions' => $this->results,
        ]);
    }
}
