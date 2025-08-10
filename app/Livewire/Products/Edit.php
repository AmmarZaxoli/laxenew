<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class Edit extends Component
{
    public $product_id;
    public $product;
    public $price_sell;
    public $name;
    public $is_active;

    public function mount($product_id)
    {
        $this->product = Product::with('definition')->findOrFail($product_id);
        $this->product_id = $product_id;

        $this->price_sell = $this->product->price_sell;
        $this->name = $this->product->definition->name;
        $this->is_active = (string) $this->product->definition->is_active; // for radio buttons
    }

    public function update()
    {
        $this->validate([
            'price_sell' => 'required|numeric|min:0',
            'is_active' => 'required',
        ]);

        // Update product
        $this->product->update([
            'price_sell' => $this->price_sell,
        ]);

        // Update related definition
        $this->product->definition->update([
            'is_active' => $this->is_active,
        ]);

        flash()->addSuccess('تم التحديث بنجاح.');

        return redirect()->route('products.create');
    }

    public function render()
    {
        return view('livewire.products.edit');
    }
}
