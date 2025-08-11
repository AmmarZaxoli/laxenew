<?php

namespace App\Livewire\Drivers\InvoiceControls;


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
use Illuminate\Http\Request;


class Show extends Component
{



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
    public function openDateFilterModal()
    {
        $today = now()->format('Y-m-d');
        $this->date_from = $this->date_from ?? $today;
        $this->date_to = $this->date_to ?? $today;
        $this->filteredByDate = false; // or true if you want to filter by default
        // Show modal logic here, if you have one, e.g.:
        // $this->showDateFilterModal = true;
    }

    public function numinvoice($id)
    {
        $this->dispatch('loadInvoiceData', [
            'num_invoice' => $id,
        ]);
    }

    public function openDriverModal($invoiceId)
    {
        $this->selectedInvoiceId = $invoiceId;
        $this->selectedDriverId = ''; // reset

    }

    public function updateDriver()
    {
        $this->validate([
            'selectedDriverId' => 'required|exists:drivers,id',
        ]);

        $customer = Customer::where('sell_invoice_id', $this->selectedInvoiceId)->first();



        if ($customer) {
            $customer->driver_id = $this->selectedDriverId;
            $customer->save();

            session()->flash('message', 'تم تحديث السائق بنجاح');
            $this->dispatch('close-driver-modal');
        } else {
            session()->flash('message', 'الفاتورة أو العميل غير موجود');
        }
    }



    public function openBulkDateModal()
    {
        if (empty($this->selectedInvoices)) {
            session()->flash('error', 'يرجى اختيار فاتورة واحدة على الأقل.');
            return;
        }



        // تعيين تاريخ افتراضي (مثلاً التاريخ الحالي)
        $this->bulkNewDateSell = now()->format('Y-m-d\TH:i');
        $this->showBulkDateModal = true;
    }

    // تحديث تواريخ الفواتير المختارة دفعة واحدة
   public function updateBulkDateSell()
{
    foreach ($this->selectedInvoices as $invoiceNumber) {
        $invoice = Sell_invoice::where('num_invoice_sell', $invoiceNumber)->first();

        if ($invoice) {
            // Update invoice date
            $invoice->date_sell = $this->bulkNewDateSell;
            $invoice->save();

            // If related customer exists, update their date_sell as well
            if ($invoice->customer) {
                $invoice->customer->date_sell = $this->bulkNewDateSell;
                $invoice->customer->save();
            }
        }
    }

    session()->flash('message', 'تم تحديث تاريخ البيع للفواتير المختارة بنجاح.');
    $this->showBulkDateModal = false;
}



    #[On('invoiceUpdated')]
    public function refresh()
    {
        // فارغ: سيؤدي فقط إلى إعادة تنفيذ render()
    }

    public function mount()
    {
        $this->drivers = Driver::all();
        $today = now()->format('Y-m-d');
        $this->date_from = $this->date_from ?? $today;
        $this->date_to = $this->date_to ?? $today;
    }

    public function filterByDate()
    {
        $this->filteredByDate = true;
    }



    public function updatedSelectAll($value)
    {
        $filteredInvoices = Sell_invoice::with(['customer', 'sell'])
            ->whereHas('sell', fn($q) => $q->where('cash', 0))
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
            ->when(
                $this->selected_driver,
                fn($q) =>
                $q->whereHas(
                    'customer',
                    fn($q2) =>
                    $q2->where('driver_id', $this->selected_driver)
                )
            )
            ->when(
                $this->filteredByDate && $this->date_from && $this->date_to,
                fn($q) =>
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
                        ->orWhereHas(
                            'customer',
                            fn($q) =>
                            $q->where('mobile', 'like', '%' . $this->search . '%')
                        );
                });
            })
            ->when(
                $this->selected_driver,
                fn($q) =>
                $q->whereHas(
                    'customer',
                    fn($q2) =>
                    $q2->where('driver_id', $this->selected_driver)
                )
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
            ->whereHas('sell', fn($q) => $q->where('cash', 0))
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
            ->when(
                $this->selected_driver,
                fn($q) =>
                $q->whereHas(
                    'customer.driver', // Note the added relationship
                    fn($q2) =>
                    $q2->where('driver_id', $this->selected_driver)
                )
            );

        if ($this->filteredByDate && $this->date_from && $this->date_to) {
            $query->whereDate('date_sell', '>=', $this->date_from)
                ->whereDate('date_sell', '<=', $this->date_to);
        }

        $invoices = $query->get();

        return view('livewire.drivers.invoice-controls.show', compact('invoices'));
    }





    public function print($id) {}
    public function edit($id) {}

    public function payment($id)
    {
        $sell = Sellinfo::where('sell_invoice_id', $id)->first();

        if ($sell) {
            $sell->cash = true;
            $sell->save();
        }
    }

    public function paymentmulti()
    {
        $this->updatedSelectedInvoices();
        $this->paymentselected(); // تقوم بتحديث cash = true
    }




    public function paymentselected()
    {
        $selectedIds = array_map(
            fn($invoiceNum) => $this->invoiceNumberToIdMap[$invoiceNum] ?? null,
            $this->selectedInvoices
        );

        $selectedIds = array_filter($selectedIds);

        if (empty($selectedIds)) {
            session()->flash('error', 'لم يتم تحديد أي فواتير صالحة.');
            return;
        }

        Sellinfo::whereIn('sell_invoice_id', $selectedIds)
            ->update(['cash' => true]);

        session()->flash('message', 'تم تحديث حالة الدفع بنجاح.');

        $this->selectedInvoices = [];
        $this->selectAll = false;
    }
    public $showBulkDriverModal = false;
    public $bulkDriverId;

    public function openBulkDriverModal()
    {
        $this->bulkDriverId = '';
        $this->showBulkDriverModal = true;
    }


    public function updateBulkDriver()
    {

        foreach ($this->selectedInvoices as $invoiceNumber) {
            $invoice = Sell_invoice::where('num_invoice_sell', $invoiceNumber)->first();
            if ($invoice && $invoice->customer) {
                $invoice->customer->driver_id = $this->bulkDriverId;
                $invoice->customer->save();
            }
        }



        flash()->Success('تم تحديث السائق للفواتير المحددة بنجاح.');

        $this->showBulkDriverModal = false;
        $this->selectedInvoices = [];
        $this->selectAll = false;
    }



    public function delete($id)
    {
        $this->confirmDelete($id);
    }


    public function confirmDelete($id)
    {
        DB::beginTransaction();

        try {
            // 1. Handle selling products
            $sellingProducts = SellingProduct::where('sell_invoice_id', $id)->get();

            foreach ($sellingProducts as $sellingProduct) {
                $product = Product::find($sellingProduct->product_id);
                if ($product) {
                    $product->increment('quantity', $sellingProduct->quantity);
                }
            }

            // 2. Handle product batch quantities
            $productInfos = Seling_product_info::where('sell_invoice_id', $id)->get();

            foreach ($productInfos as $productInfo) {
                $batch = Sub_Buy_Products_invoice::find($productInfo->sub_id);
                if ($batch) {
                    $batch->decrement('q_sold', $productInfo->quantity_sold);
                }
            }

            // 3. Handle offers if any
            $offerSells = Offer_sell::where('sell_invoice_id', $id)->get();



            foreach ($offerSells as $offerSell) {


                $offer = Offer::with('subOffers')->where('code', $offerSell->code)->firstOrFail();




                if ($offer) {
                    foreach ($offer->subOffers as $subOffer) {
                        $product = Product::find($subOffer->product_id);
                        if ($product) {

                            $product->increment('quantity', $subOffer->quantity * $offerSell->quantity);
                        }
                    }
                }
            }

            // 4. Delete all related records
            SellingProduct::where('sell_invoice_id', $id)->delete();
            Seling_product_info::where('sell_invoice_id', $id)->delete();
            Offer_sell::where('sell_invoice_id', $id)->delete();
            Sell_invoice::where('id', $id)->delete();

            DB::commit();

            flash()->addSuccess('تم حذف الفاتورة بنجاح وإعادة جميع الكميات.');
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('حدث خطأ أثناء حذف الفاتورة: ' . $e->getMessage());
        }
    }



    // قائمة الفواتير المحددة (موجودة غالباً)


    public function deleteSelected()
    {

        DB::beginTransaction();

        try {
            foreach ($this->selectedInvoices as $invoiceId) {
                // نفس منطق حذف الفاتورة المفردة
                $invoice = Sell_invoice::where('num_invoice_sell', $invoiceId)->first();

                $this->deleteInvoiceById($invoice->id);
            }

            DB::commit();
            $this->selectedInvoices = [];
            flash()->addSuccess('تم حذف الفواتير المحددة بنجاح وإعادة الكميات.');
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('حدث خطأ أثناء حذف الفواتير: ' . $e->getMessage());
        }
    }

    private function deleteInvoiceById($id)
    {


        // 1. Handle selling products
        $sellingProducts = SellingProduct::where('sell_invoice_id', $id)->get();
        foreach ($sellingProducts as $sellingProduct) {
            $product = Product::find($sellingProduct->product_id);
            if ($product) {
                $product->increment('quantity', $sellingProduct->quantity);
            }
        }

        // 2. Handle batch quantities
        $productInfos = Seling_product_info::where('sell_invoice_id', $id)->get();
        foreach ($productInfos as $productInfo) {
            $batch = Sub_Buy_Products_invoice::find($productInfo->sub_id);
            if ($batch) {
                $batch->decrement('q_sold', $productInfo->quantity_sold);
            }
        }

        // 3. Offers
        $offerSells = Offer_sell::where('sell_invoice_id', $id)->get();
        foreach ($offerSells as $offerSell) {
            $offer = Offer::with('subOffers')->where('code', $offerSell->code)->first();


            if ($offer) {
                foreach ($offer->subOffers as $subOffer) {
                    $product = Product::find($subOffer->product_id);
                    if ($product) {
                        $product->increment('quantity', $subOffer->quantity * $offerSell->quantity);
                    }
                }
            }
        }

        // 4. حذف السجلات
        SellingProduct::where('sell_invoice_id', $id)->delete();
        Seling_product_info::where('sell_invoice_id', $id)->delete();
        Offer_sell::where('sell_invoice_id', $id)->delete();
        Sell_invoice::where('id', $id)->delete();
    }
    public function printdriver()
    {
        if (!$this->selected_driver) {
            $this->dispatch('show-toast', type: 'error', message: 'يرجى اختيار السائق أولاً');
            return;
        }

        // Get invoice numbers based on driver ID and optional date range
        $invoiceNumbers = Sell_invoice::query()
            ->with('customer.driver')
            ->whereHas('customer', function ($q) {
                $q->where('driver_id', $this->selected_driver);
            })
            ->when($this->date_from && $this->date_to, function ($q) {
                $q->whereDate('date_sell', '>=', $this->date_from)
                    ->whereDate('date_sell', '<=', $this->date_to);
            })
            ->pluck('num_invoice_sell')
            ->toArray();
        if (empty($invoiceNumbers)) {
            flash()->addError('لا توجد فواتير لهذا السائق في المدة المحددة.');
            return;
        }

        try {
            $driverName = Driver::find($this->selected_driver)->nameDriver;

            $url = route('print.driver-invoices', [
                'invoiceIds' => implode(',', $invoiceNumbers),
                'driverName' => $driverName,
            ]);

            $this->dispatch('print-driver-invoices', url: $url);
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء محاولة الطباعة: ' . $e->getMessage());
        }
    }
    public $selectedInvoicesData = [];


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
    public function printInvoices(Request $request)
    {
        $invoiceIds = array_filter(explode(',', $request->invoiceIds));

        $invoices = Sell_invoice::with(['customer.driver', 'sell'])
            ->whereIn('num_invoice_sell', $this->selectedInvoices)
            ->get()
            ->filter(); // Remove null values



        if ($invoices->isEmpty()) {
            abort(404, 'No invoices found');
        }

        return view('print.invoices', compact('invoices'));
    }
}
