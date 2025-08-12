<?php

namespace App\Livewire\Print;

use App\Models\Driver;
use App\Models\Sell_invoice;
use App\Models\Sellinfo;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Offer;
use App\Models\Offer_sell;
use App\Models\Product;
use App\Models\Seling_product_info;
use App\Models\SellingProduct;
use App\Models\Sub_Buy_Products_invoice;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class Multiinvoices extends Component
{
    public $driverInvoices;
    public $selectedInvoiceId;
    public $selectedDriverId;
    public $drivers = [];
    public $search = '';
    public $selected_driver = '';

    public $selectedInvoices = [];
    public array $invoiceNumberToIdMap = [];
    public $selectAll = false;

    public $date_from;
    public $date_to;
    public $filteredByDate = false;

    public $showBulkDateModal = false;
    public $bulkNewDateSell;

    public $showBulkDriverModal = false;
    public $bulkDriverId;

    public function mount()
    {
        $this->drivers = Driver::all();
        $today = now()->format('Y-m-d');
        $this->date_from = $this->date_from ?? $today;
        $this->date_to = $this->date_to ?? $today;
    }

    // Clear selected invoices when filters/search change
    public function updatedSearch()
    {
        $this->resetSelectedInvoices();
    }


    public function updatedDateFrom()
    {
        $this->resetSelectedInvoices();
    }

 
    public function resetSelectedInvoices()
    {
        $this->selectedInvoices = [];
        $this->selectAll = false;
    }

    // Also clear selection when clicking search button
    public function filterByDate()
    {
        $this->filteredByDate = true;
        $this->resetSelectedInvoices();
    }

    public function updatedSelectAll($value)
    {
        $filteredInvoices = Sell_invoice::with(['customer', 'sell'])
            ->whereHas('sell', fn($q) => $q->where('cash', 0))
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('num_invoice_sell', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', fn($q) => $q->where('mobile', 'like', '%' . $this->search . '%'));
                });
            })
            ->when($this->selected_driver, fn($q) =>
                $q->whereHas('customer', fn($q2) => $q2->where('driver_id', $this->selected_driver))
            )
            ->when($this->filteredByDate && $this->date_from && $this->date_to, fn($q) =>
                $q->whereDate('date_sell', '>=', $this->date_from)
                  ->whereDate('date_sell', '<=', $this->date_to)
            )
            ->pluck('num_invoice_sell')
            ->map(fn($num) => (string) $num)
            ->toArray();

        $this->selectedInvoices = $value ? $filteredInvoices : [];
    }

    public function updatedSelectedInvoices()
    {
        $filteredInvoices = Sell_invoice::with(['customer', 'sell'])
            ->whereHas('sell', fn($q) => $q->where('cash', 0))
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('num_invoice_sell', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', fn($q) => $q->where('mobile', 'like', '%' . $this->search . '%'));
                });
            })
            ->when($this->selected_driver, fn($q) =>
                $q->whereHas('customer', fn($q2) => $q2->where('driver_id', $this->selected_driver))
            )
            ->when($this->filteredByDate && $this->date_from && $this->date_to, fn($q) =>
                $q->whereDate('date_sell', '>=', $this->date_from)
                  ->whereDate('date_sell', '<=', $this->date_to)
            )
            ->select('id', 'num_invoice_sell')
            ->get()
            ->mapWithKeys(fn($invoice) => [$invoice->num_invoice_sell => $invoice->id])
            ->toArray();

        $filteredInvoiceNumbers = array_keys($filteredInvoices);

        $this->selectAll = count($filteredInvoiceNumbers) > 0 &&
            empty(array_diff($filteredInvoiceNumbers, $this->selectedInvoices));

        $this->invoiceNumberToIdMap = $filteredInvoices;
    }

  public function render()
{
    $query = Sell_invoice::with(['customer', 'sell'])
        ->whereHas('sell', fn($q) => $q->where('cash', 0))
        ->when($this->search, function ($q) {
            $q->where(function ($sub) {
                $sub->where('num_invoice_sell', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($q) {
                        $q->where('mobile', 'like', '%' . $this->search . '%');
                    });
            });
        })
        ->whereHas('customer', function ($q) {
            $q->where('print', false); 
        })
        ->when(
            $this->selected_driver,
            fn($q) =>
            $q->whereHas('customer.driver', fn($q2) => $q2->where('driver_id', $this->selected_driver))
        );

    if ($this->filteredByDate && $this->date_from && $this->date_to) {
        $query->whereDate('date_sell', '>=', $this->date_from)
            ->whereDate('date_sell', '<=', $this->date_to);
    }

    $this->driverInvoices = $query->get();

    $driverInvoices = $this->driverInvoices;
    $invoices = $driverInvoices;

    return view('livewire.print.multiinvoices', compact('driverInvoices', 'invoices'));
}


   

   

   

   



   
   

    public function printSelected()
    {
        if (empty($this->selectedInvoices)) {
            session()->flash('error', 'Please select at least one invoice.');
            return;
        }

        $invoiceIds = implode(',', $this->selectedInvoices);

        $url = route('print.invoices', ['invoiceIds' => $invoiceIds]);

        $this->dispatch('print-invoices', $url);
    }
}
