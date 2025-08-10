<?php

namespace App\Livewire\Types;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Type;

class Insert extends Component
{
    #[Validate('required|unique:types,typename')]
    public $typename = '';

    public function store()
    {
        $validated = $this->validate();

        Type::create($validated);

        flash()->Success('تم الإضافة بنجاح.');


        return redirect()->route('types.create');
    }

    public function render()
    {
        return view('livewire.types.insert');
    }
}
