<?php

namespace App\Livewire\Invoices;

use App\Models\Buy_invoice;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

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
