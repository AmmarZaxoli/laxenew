<?php

namespace App\Livewire\Definitions;

use App\Models\Definition;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Type;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

class Insert extends Component
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

    #[Validate('nullable|image|mimes:jpeg,png|max:2048')]
    public $image;


    public $definition_id;

    #[Validate('required')]
    public $is_active = '';

    public $quantity = 0;
    public $price_sell = 0;

    #[Validate('boolean')]
    public $delivery_type = false; // default false

    public function clear()
    {
        $this->reset([
            'name',
            'code',
            'barcode',
            'madin',
            'image',
            'definition_id',
            'is_active',
            'quantity',
            'price_sell',
            'type_id',
            'delivery_type'
        ]);
    }

    public function store()
    {
        try {
            $validated = $this->validate();

            if ($this->image) {
                $validated['image'] = $this->image->store('Product', 'public');
            }

            $definition = Definition::create($validated);
            $this->definition_id = $definition->id;

            Product::create([
                'quantity' => 0,
                'price_sell' => 0,
                'definition_id' => $this->definition_id,
            ]);

            flash()->addSuccess('تم الإضافة بنجاح.');
            $this->clear();

        } catch (ValidationException $e) {
            foreach ($e->validator->errors()->all() as $error) {
                flash()->addWarning($error);
            }
        } catch (\Exception $e) {
            flash()->addError('حدث خطأ أثناء الإضافة: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.definitions.insert', [
            'types' => Type::paginate(10),
        ]);
    }
}
