<?php

namespace App\Livewire\Barcode;

use App\Models\Driver;
use App\Models\Sell_invoice;
use Livewire\Component;

class BarcodeScanner extends Component
{
    public array $barcodes = [];
    public $selectedDriverId = null;
    public $drivers;
    public $driverInvoices = [];
    public $scannedInvoices = [];

    public function mount()
    {
        $this->drivers = Driver::all();
    }

    public function updatedSelectedDriverId($value)
    {
        if ($value) {
            // Get invoices for the selected driver
            $this->driverInvoices = Sell_invoice::with(['customer', 'sell'])
                ->whereHas('customer', function ($q) use ($value) {
                    $q->where('driver_id', $value);
                })
                ->whereHas('sell', fn($q) => $q->where('cash', 0))
                ->get()
                ->map(function ($invoice) {
                    return [
                        'num_invoice_sell' => $invoice->num_invoice_sell,
                        'mobile' => $invoice->customer->mobile ?? 'N/A',
                        'total_price_afterDiscount_invoice' => $invoice->sell->total_price_afterDiscount_invoice ?? 0,
                    ];
                })
                ->toArray();

            // Reset scanned invoices for new driver
            $this->scannedInvoices = [];
            $this->barcodes = [];
        } else {
            $this->driverInvoices = [];
            $this->scannedInvoices = [];
        }
    }
    public $barcodeInput;
    public function addBarcodeFromInput()
    {
        $this->addBarcode($this->barcodeInput);

        // Clear input after scanning
        $this->barcodeInput = '';
    }
    public function addBarcode(string $code): void
    {
        if (!$this->selectedDriverId) {
            flash()->error('يرجى اختيار سائق أولاً');
            return;
        }

        // Prevent duplicate scans
        if (in_array($code, $this->barcodes)) {
            flash()->warning('تم مسح الفاتورة ضوئيًا بالفعل');
            return;
        }

        $invoice = Sell_invoice::with(['customer', 'sell'])
            ->where('num_invoice_sell', $code)
            ->whereHas('sell', fn($q) => $q->where('cash', 0))
            ->first();

        if (!$invoice) {
            flash()->error('لم يتم العثور على الفاتورة');
            return;
        }

        if (!$invoice->customer->driver_id) {
            flash()->error('Invoice has no driver assigned');
            return;
        }

        if ($invoice->customer->driver_id == $this->selectedDriverId) {
            // Add to scanned invoices
            $this->scannedInvoices[] = [
                'num_invoice_sell' => $invoice->num_invoice_sell,
                'mobile' => $invoice->customer->mobile ?? 'N/A',
                'date' => $invoice->created_at->format('Y-m-d'),
                'total_price_afterDiscount_invoice' => $invoice->sell->total_price_afterDiscount_invoice ?? 0,
            ];

            // Add to barcode list
            $this->barcodes[] = $code;

            flash()->success('تمت إضافة الفاتورة بنجاح');
        } else {
            flash()->error('الفاتورة تخص سائقًا آخر');
        }
    }

    public function removeBarcode($index)
    {
        if (isset($this->barcodes[$index])) {
            $removedCode = $this->barcodes[$index];

            // Remove from barcodes array
            unset($this->barcodes[$index]);
            $this->barcodes = array_values($this->barcodes);

            // Remove from scanned invoices
            $this->scannedInvoices = array_filter(
                $this->scannedInvoices,
                fn($inv) => $inv['num_invoice_sell'] !== $removedCode
            );
        }
    }

    public function render()
    {
        return view('livewire.barcode.barcode-scanner');
    }
}
