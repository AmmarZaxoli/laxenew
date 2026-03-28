<?php

namespace App\Livewire\Invoices;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sell_invoice;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GiftInvoicesExport;

class Gift extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $date_from;
    public $date_to;

    public $showResults = false;

    public function exportExcel()
    {
        return Excel::download(
            new GiftInvoicesExport($this->date_from, $this->date_to),
            'gift-invoices.xlsx'
        );
    }

    public function filterByDate()
    {
        $this->validate([
            'date_from' => 'required|date',
            'date_to'   => 'required|date',
        ]);

        $this->showResults = true;
        $this->resetPage();
    }

    public function render()
    {
        $query = Sell_invoice::with(['customer.driver', 'sell'])
            ->where('selling', 1);

        if ($this->showResults) {

            $query->when($this->date_from, function ($q) {
                $q->whereDate('date_sell', '>=', $this->date_from);
            });

            $query->when($this->date_to, function ($q) {
                $q->whereDate('date_sell', '<=', $this->date_to);
            });
        } else {

            $query->whereRaw('1=0'); // لا يظهر أي نتيجة
        }

        $invoices = $query->orderByDesc('date_sell')->paginate(10);

        return view('livewire.invoices.gift', [
            'invoices' => $invoices
        ]);
    }
}
