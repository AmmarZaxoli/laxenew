<?php

namespace App\Livewire\Invoices;

use App\Models\Buy_invoice;
use App\Models\Buy_Products_invoice;
use App\Models\Company;
use App\Models\Sub_Buy_Products_invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

use function Laravel\Prompts\error;

class Show extends Component
{
    use WithPagination;
    // In your Livewire component class
    public $editModal = false;
    public $editingInvoiceId = null;
    public $editingInvoice = null;

    public function editInvoice($invoiceId)
    {
        $this->editingInvoiceId = $invoiceId;
        $this->editingInvoice = Buy_invoice::find($invoiceId);
        $this->editModal = true;
    }

    public function closeModal()
    {
        $this->editModal = false;
        $this->editingInvoiceId = null;
        $this->editingInvoice = null;
    }
    public $search = '';
    public $selected_company = '';
    public $companys;

    public function mount()
    {
        $this->companys = Company::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCompany()
    {
        $this->resetPage();
    }

    public $id;

    public function deleteConfirmation($id)
    {
        $this->id = $id;
        // This sends the event to the browser (JS)
        $this->dispatch('show-delete-confirmation');
    }

    #[On('deleteConfirmed')]
    public function removeProduct()
    {
        $Sub_Buy = Sub_Buy_Products_invoice::where('num_invoice_id', $this->id)->get();
        $Buy = Buy_Products_invoice::where('id', $this->id)->get();


        if ($Sub_Buy->isEmpty() && $Buy->isEmpty()) {
            Buy_invoice::where('id', $this->id)->delete();
            flash()->success('تم الحذف بنجاح');
        } else {
            flash()->warning('لا يمكن الحذف لأنه يوجد منتجات في هذه الفاتورة');
            return;
        }
    }


    public function render()
    {
        $invoices = buy_invoice::query();

        if ($this->search) {
            $invoices->where(function ($query) {
                $query->where('num_invoice', 'like', '%' . $this->search . '%')
                    ->orWhere('name_invoice', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selected_company) {
            $invoices->where('name_invoice', $this->selected_company);
        }

        $invoices = $invoices->orderBy('id', 'desc')->paginate(10);

        return view('livewire.invoices.show', compact('invoices'));
    }
}
