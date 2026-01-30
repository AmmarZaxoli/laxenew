<?php

namespace App\Livewire\Print;

use App\Models\Driver;
use App\Models\Sell_invoice;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;

class Multiinvoices extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $driverInvoices;
    public $drivers = [];
    public $search = '';
    public $selected_driver = '';

    public $selectedInvoices = [];
    public array $invoiceNumberToIdMap = [];
    public $selectAll = false;

    public $date_from;
    public $date_to;
    public $filteredByDate = false;

    // public $showBulkDateModal = false;
    // public $bulkNewDateSell;

    // public $showBulkDriverModal = false;
    // public $bulkDriverId;
    public $printedStatus = 0;

    public function filterPrinted($status)
    {
        $this->printedStatus = $status;
        $this->resetSelectedInvoices();
    }
    public function updatedDateTo()
    {
        $this->resetSelectedInvoices();
    }

    public function updatedSelectedDriver()
    {
        $this->resetSelectedInvoices();
    }

    public function updatedPrintedStatus()
    {
        $this->resetSelectedInvoices();
    }


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
        // Get only the invoices from the current page
        $currentPageInvoices = $this->getCurrentPageInvoices();

        if ($value) {
            // Add their invoice numbers to selectedInvoices
            $this->selectedInvoices = array_unique(array_merge(
                $this->selectedInvoices,
                $currentPageInvoices->pluck('num_invoice_sell')->map(fn($num) => (string) $num)->toArray()
            ));
        } else {
            // Remove only current page invoices from selectedInvoices
            $this->selectedInvoices = array_diff(
                $this->selectedInvoices,
                $currentPageInvoices->pluck('num_invoice_sell')->map(fn($num) => (string) $num)->toArray()
            );
        }
    }
    protected function getCurrentPageInvoices()
    {
        $query = Sell_invoice::with(['customer', 'sell'])
            ->whereHas('sell', fn($q) => $q->where('cash', 0))
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('num_invoice_sell', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', fn($q) => $q->where('mobile', 'like', '%' . $this->search . '%'));
                });
            })
            ->when(!is_null($this->printedStatus), function ($q) {
                $q->whereHas('customer', fn($q) => $q->where('print', $this->printedStatus));
            })
            ->when(
                $this->selected_driver,
                fn($q) => $q->whereHas('customer', fn($q2) => $q2->where('driver_id', $this->selected_driver))
            );

        if ($this->filteredByDate && $this->date_from && $this->date_to) {
            $query->whereBetween('date_sell', [$this->date_from, $this->date_to]);
        }

        return $query->paginate(30); // 👈 same as render()
    }

    public function updatedPage($page)
    {
        // Uncheck "select all" when changing page
        $this->selectAll = false;

        // Forget selected invoices from the previous page
        $this->selectedInvoices = [];
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
            ->when(
                $this->selected_driver,
                fn($q) =>
                $q->whereHas('customer', fn($q2) => $q2->where('driver_id', $this->selected_driver))
            )
            ->when(
                $this->filteredByDate && $this->date_from && $this->date_to,
                fn($q) =>
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
            ->whereHas('sell', fn($q) => $q->where('cash', 1))
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('num_invoice_sell', 'like', '%' . $this->search . '%')
                        ->orWhereHas(
                            'customer',
                            fn($q) =>
                            $q->where('mobile', 'like', '%' . $this->search . '%')
                        );
                });
            })
            ->when(!is_null($this->printedStatus), function ($q) {
                $q->whereHas(
                    'customer',
                    fn($q) =>
                    $q->where('print', $this->printedStatus)
                );
            })
            ->when(
                $this->selected_driver,
                fn($q) =>
                $q->whereHas(
                    'customer.driver',
                    fn($q2) =>
                    $q2->where('driver_id', $this->selected_driver)
                )
            );

        if ($this->filteredByDate && $this->date_from && $this->date_to) {
            $query->whereDate('date_sell', '>=', $this->date_from)
                ->whereDate('date_sell', '<=', $this->date_to);
        }

        $driverInvoices = $query->paginate(30);


        return view('livewire.print.multiinvoices', [
            'driverInvoices' => $driverInvoices,
            'invoices' => $driverInvoices, // 👈 just alias

        ]);
    }


    public function printSelected()
    {
        if (empty($this->selectedInvoices)) {
            session()->flash('error', 'Please select at least one invoice.');
            return;
        }

        // Fetch all invoices by their invoice numbers (num_invoice_sell)
        $invoices = Sell_invoice::whereIn('num_invoice_sell', $this->selectedInvoices)
            ->with('customer')
            ->get();

        // Extract unique customer IDs from invoices (skip if no customer linked)
        $customerIds = $invoices->pluck('customer.id')->filter()->unique();

        // Update 'print' column to true (1) for all these customers
        Customer::whereIn('id', $customerIds)->update(['print' => 1]);

        // Prepare the URL for printing
        $invoiceIds = implode(',', $this->selectedInvoices);
        $url = route('print.invoices', ['invoiceIds' => $invoiceIds]);

        // Dispatch event to trigger printing
        $this->dispatch('print-invoices', $url);


        $this->selectedInvoices = [];
        $this->selectAll = false;
    }

    public function markAllCustomersAsPrinted()
    {
        Customer::where('print', 0)->update([
            'print' => 1
        ]);

        flash()->addSuccess('تم  بنجاح.');
    }
}
