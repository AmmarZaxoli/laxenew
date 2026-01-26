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
use Illuminate\Support\Facades\Auth;
use App\Models\DeleteInvoice;
use App\Models\DeleteItemInvoice;

class Show extends Component
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
    private function resetSelection()
    {
        $this->selectedInvoices = [];
        $this->selectAll = false;
    }
    public function updatedSearch()
    {
        $this->resetSelection();
    }

    public function updatedSelectedDriver()
    {
        $this->resetSelection();
    }

    public function updatedDateFrom()
    {
        $this->resetSelection();
    }

    public function updatedDateTo()
    {
        $this->resetSelection();
    }

    public function openDateFilterModal()
    {
        $today = now()->format('Y-m-d');
        $this->date_from = $this->date_from ?? $today;
        $this->date_to = $this->date_to ?? $today;
        $this->filteredByDate = false;
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
        $user = Auth::guard('account')->user();
        if ($user->role !== 'admin') {

            flash()->error('يمكن للمسؤول فقط حذف الفواتير');
            return;
        }
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
        $user = Auth::guard('account')->user();
        if ($user->role !== 'admin') {

            flash()->error('يمكن للمسؤول فقط حذف الفواتير');
            return;
        }
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
                            fn($q) => $q->where('mobile', 'like', '%' . $this->search . '%')
                        );
                });
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

        $this->driverInvoices = $query->get();

        $driverInvoices = $this->driverInvoices;
        $invoices = $driverInvoices;

        return view('livewire.drivers.invoice-controls.show', compact('driverInvoices', 'invoices'));
    }






    public function print($id) {}
    public function edit($id) {}

    public function payment($id)
    {
        $user = Auth::guard('account')->user();
        if ($user->role !== 'admin') {

            flash()->error('يمكن للمسؤول فقط حذف الفواتير');
            return;
        }
        $sell = Sellinfo::where('sell_invoice_id', $id)->first();

        if ($sell) {
            $sell->cash = true;
            $sell->save();
        }
    }

    public function paymentmulti()
    {
        $this->updatedSelectedInvoices();
        $this->paymentselected();
    }




    public function paymentselected()
    {
        $user = Auth::guard('account')->user();
        if ($user->role !== 'admin') {

            flash()->error('يمكن للمسؤول فقط حذف الفواتير');
            return;
        }
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
        $user = Auth::guard('account')->user();
        if ($user->role !== 'admin') {

            flash()->error('يمكن للمسؤول فقط حذف الفواتير');
            return;
        }
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

        $user = Auth::guard('account')->user();
        if ($user->role !== 'admin') {

            flash()->error('يمكن للمسؤول فقط حذف الفواتير');
            return;
        }

        DB::beginTransaction();

        $invoice = Sell_invoice::with('customer')->findOrFail($id);



        // $user = Auth::guard('account')->user();

        $deletedInvoice = DeleteInvoice::create([
            'num_invoice_sell' => $invoice->num_invoice_sell,
            'totalprice'      => $invoice->totalprice ?? $invoice->total_price ?? 0,
            'customermobile'  => optional($invoice->customer)->mobile,
            'address'         => optional($invoice->customer)->address,
            'user'            => Auth::guard('account')->user()->name ?? 'System',
        ]);

        // Get selling products
        $sellingProducts = SellingProduct::where('sell_invoice_id', $invoice->id)->get();

        // Create deleted items using the relationship
        foreach ($sellingProducts as $item) {
            DeleteItemInvoice::create([
                'sell_invoice_id' => $deletedInvoice->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->price,
            ]);
        }


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
        $user = Auth::guard('account')->user();
        if ($user->role !== 'admin') {

            flash()->error('يمكن للمسؤول فقط حذف الفواتير');
            return;
        }
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


        $invoice = Sell_invoice::with('customer')->findOrFail($id);


        // $user = Auth::guard('account')->user();

        $deletedInvoice = DeleteInvoice::create([
            'num_invoice_sell' => $invoice->num_invoice_sell,
            'totalprice'      => $invoice->total_price ?? 0,
            'customermobile'  => optional($invoice->customer)->mobile,
            'address'         => optional($invoice->customer)->address,
            'user'            => Auth::guard('account')->user()->name ?? 'admin',
        ]);


        $sellingProducts = SellingProduct::where('sell_invoice_id', $invoice->id)->get();

        foreach ($sellingProducts as $item) {
            $deletedInvoice->items()->create([
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->price,
            ]);
        }


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
        if (empty($this->driverInvoices) || $this->driverInvoices->isEmpty()) {
            flash()->addError('لا توجد بيانات للطباعة.');
            return;
        }

        $invoiceNumbers = $this->driverInvoices->pluck('num_invoice_sell')->toArray();
        $driverName = optional($this->driverInvoices->first()->customer->driver)->nameDriver ?? '—';

        $url = route('print.driver-invoices', [
            'invoiceIds' => implode(',', $invoiceNumbers),
            'driverName' => $driverName,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
        ]);

        $this->dispatch('print-driver-invoices', url: $url);
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
}
