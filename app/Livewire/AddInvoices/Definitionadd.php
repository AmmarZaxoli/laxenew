<?php

namespace App\Livewire\AddInvoices;

use Livewire\Component;
use App\Models\Type;
use App\Models\Product;
use App\Models\Definition;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Definitionadd extends Component
{
    use WithFileUploads;

    #[Validate('required|unique:definitions,name')]
    public $name = '';
    #[Validate('required|unique:definitions,barcode')]
    public $barcode = '';
    #[Validate('required|unique:definitions,code')]
    public $code = '';
    #[Validate('required|exists:types,id')]
    public $type_id = '';

    #[Validate('nullable')]
    public $madin = '';

    #[Validate('nullable|image|max:2048')]
    public $image;

    public $definition_id;

    #[Validate('required')]
    public $is_active = '';

    public $quantity = 0;
    public $price_sell = 0;

    public $testinser = false;

    public function store()
    {
        $validated = $this->validate();

        if ($this->image) {
            $validated['image'] = $this->image->store('Product', 'public');
        }

        $definition = Definition::create($validated);
        $this->definition_id = $definition->id;

        Product::create([
            'quantity'      => 0,
            'price_sell'    => 0,
            'definition_id' => $this->definition_id,
        ]);

        $this->dispatch('notify', type: 'success', message: 'تم إضافة المنتج بنجاح.');

        // Tell parent component to close modal and optionally select the product
        $this->dispatch('definitionCreated', definitionId: $this->definition_id);
    }

    public function render()
    {
        return view('livewire.add-invoices.definitionadd', [
            'types' => Type::all()
        ]);
    }
}