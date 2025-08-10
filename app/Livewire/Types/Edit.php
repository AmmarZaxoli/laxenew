<?php

namespace App\Livewire\Types;

use App\Models\Type;
use Livewire\Component;

class Edit extends Component
{
    public $typeid;
    public $typename;

    public function mount($type_id)
    {
        $this->typeid = $type_id;
        $type = Type::findOrFail($type_id);
        $this->typename = $type->typename;
    }
    

    public function update()
    {
        $this->validate([
            'typename' => 'required',
        ]);

        $type = Type::findOrFail($this->typeid);
        $type->update([
            'typename' => $this->typename,
        ]);

        flash()->addSuccess('تم التحديث بنجاح.');
        return redirect()->route('types.create');
    }

    public function render()
    {
        return view('livewire.types.edit');
    }
}
