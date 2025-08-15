<?php

namespace App\Livewire\Definitions;

use App\Models\Definition;
use App\Models\Type;
use Livewire\Component;
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

    public function definitionId($id)
    {
        $this->dispatch('confirm', id: $id);
    }

    #[On('delete')]
    public function delete($id)
    {
        try {
            $definition = Definition::findOrFail($id);

            if ($definition->products()->count() > 0) {
                flash()->addError('لا يمكن حذف هذا التعريف لأنه مرتبط بمنتجات.');
                return;
            }

            $definition->delete();

            flash()->addSuccess('تم الحذف بنجاح.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            flash()->addError('لم يتم العثور على التعريف.');
        } catch (\Exception $e) {
            flash()->addError('حدث خطأ أثناء الحذف: ' . $e->getMessage());
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedType()
    {
        $this->resetPage();
    }

    // Add this method for active/inactive filtering
    public function filterActive($status)
    {
        $this->active_filter = ($status === '1') ? '1' : '0';
        $this->resetPage();
    }

    // Add this method to clear active filter
    public function clearActiveFilter()
    {
        $this->active_filter = null;
        $this->resetPage();
    }
    #[On('definitionUpdated')]
    public function refreshRow($id)
    {
        // Just refresh the component
        // Or, optionally, only reload that row data (advanced)
    }

    public $delivery_filter = null;

public function filterDelivery($type)
{
    if ($type === 'all') {
        $this->delivery_filter = null;
    } elseif ($type === 'true' || $type === true) {
        $this->delivery_filter = true;
    } elseif ($type === 'false' || $type === false) {
        $this->delivery_filter = false;
    }
    $this->resetPage();
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
    ->when(!is_null($this->active_filter), function ($query) {
        $query->where('is_active', $this->active_filter);
    })
    ->when(!is_null($this->delivery_filter), function ($query) {
        $query->where('delivery_type', $this->delivery_filter);
    })
    ->paginate(10);


        return view('livewire.definitions.show', [
            'definitions' => $definitions
        ]);
    }
}
