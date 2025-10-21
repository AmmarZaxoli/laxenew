<?php

namespace App\Livewire\Changetypeitem;

use App\Models\Definition;
use Livewire\Component;
use App\Models\Type;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $types = [];
    public $selectedRows = [];
    public $batchType = '';
    public $search = '';
    public $selected_type = '';
    public $count = 20;
    public $showSameTypeOnly = false;
    public $currentSelectedType = null;

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

    public function updatedSelectedRows()
    {
        // When selection changes, determine if all selected items have the same type
        if (count($this->selectedRows) > 0) {
            $selectedDefinitions = Definition::whereIn('id', $this->selectedRows)->get();
            $uniqueTypes = $selectedDefinitions->pluck('type_id')->unique();

            if ($uniqueTypes->count() === 1) {
                $this->currentSelectedType = $uniqueTypes->first();
            } else {
                $this->currentSelectedType = null;
            }
        } else {
            $this->currentSelectedType = null;
            $this->showSameTypeOnly = false;
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRows = $this->definitions->pluck('id')->toArray();
            $this->updatedSelectedRows();
        } else {
            $this->selectedRows = [];
            $this->currentSelectedType = null;
            $this->showSameTypeOnly = false;
        }
    }





    public function updateSelectedType()
    {
        // Validate the selected type
        $this->validate([
            'batchType' => 'required|exists:types,id'
        ]);

        try {
            // Update all selected definitions with the new type
            Definition::whereIn('id', $this->selectedRows)->update([
                'type_id' => $this->batchType
            ]);

            // Reset selections and batch type
            $this->selectedRows = [];
            $this->batchType = '';
            $this->currentSelectedType = null;
            $this->showSameTypeOnly = false;

            // Show success message
            flash()->success("تم تحديث النوع للعناصر المحددة بنجاح");
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء تحديث النوع: ' . $e->getMessage());
        }
    }

    public function resetBatchType()
    {
        $this->batchType = '';
    }

    public function render()
    {
        $definitions = Definition::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('code', 'like', "%{$this->search}%")
                    ->orWhere('barcode', 'like', "%{$this->search}%");
            })
            ->when($this->selected_type, function ($query) {
                $query->where('type_id', $this->selected_type);
            })
            ->paginate($this->count);

        return view('livewire.changetypeitem.show', [
            'definitions' => $definitions
        ]);
    }
}
