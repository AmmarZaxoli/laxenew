<?php

namespace App\Livewire\Types;

use Livewire\Component;
use Livewire\Attributes\on;
use Livewire\WithPagination;
use App\Models\Type;

class Show extends Component
{
    use WithPagination;
    public $delete_id;



    public function typedelete($id)
    {

        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {

        type::find($id)->delete();
        flash()->addSuccess('تم الحذف بنجاح.');
    }

    public $search = '';
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $types = Type::where('typename', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.types.show', compact('types'));
    }
}
