<?php

namespace App\Livewire\DeleteInvoices;

use Livewire\Component;
use App\Models\DeleteInvoice;
use App\Models\DeleteItemInvoice;
use Livewire\WithPagination;

class DeletedInvoice extends Component
{
     use WithPagination;
    
    public $search = '';

    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    public $selectedInvoiceId = null;
    public $showModal = false;
    public $invoiceDetails = null;
    public $invoiceItems = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset to first page on search
    }

    public function updatingPerPage()
    {
        $this->resetPage(); // Reset to first page if perPage changes
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function viewInvoice($invoiceId)
    {
        $this->selectedInvoiceId = $invoiceId;
        $this->showModal = true;
        $this->invoiceDetails = DeleteInvoice::find($invoiceId);
        $this->invoiceItems = DeleteItemInvoice::where('sell_invoice_id', $invoiceId)
            ->with('product')
            ->get();
    }

    public function closeModal()
    {
        $this->reset(['selectedInvoiceId', 'showModal', 'invoiceDetails', 'invoiceItems']);
    }

    public function render()
    {
        $invoices = DeleteInvoice::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('num_invoice_sell', 'like', '%' . $this->search . '%')
                      ->orWhere('customermobile', 'like', '%' . $this->search . '%')
                      ->orWhere('user', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%')
                      ->orWhere('id', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.delete-invoices.deleted-invoice', [
            'invoices' => $invoices,
        ]);
    }
}