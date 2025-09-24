<?php

namespace App\Livewire\ReturnSell;

use App\Models\Driver;
use App\Models\Sell_invoice;
use App\Models\Sellinfo;
use Livewire\Component;
use App\Models\Offer;
use App\Models\Offer_sell;
use App\Models\Product;
use App\Models\Seling_product_info;
use App\Models\SellingProduct;
use App\Models\Sub_Buy_Products_invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $selectedInvoiceId;

    public function updatingDateFrom()
    {
        $this->resetPage();
    }
    public $search = '';


    public $selectedInvoices = [];
    public array $invoiceNumberToIdMap = [];
    public $selectAll = false;

    public $date_from;
    public $date_to;
    public $filteredByDate = false;

    public $showBulkDateModal = false;
    public $bulkNewDateSell;
    public $drivers = [];
    public $selected_driver;

    public function numinvoice($id)
    {
        $this->dispatch('loadInvoiceData', [
            'num_invoice' => $id,
        ]);
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
            if ($invoice && $invoice->customer) {
                $invoice->date_sell = $this->bulkNewDateSell;
                $invoice->save();
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
        $this->date_from = $today;
        $this->date_to = $today;
    }


    public function filterByDate()
    {
        $this->filteredByDate = true;
    }



    public function updatedSelectAll($value)
    {
        $filteredInvoices = Sell_invoice::with(['customer', 'sell'])
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

        $invoices = $query->orderByDesc('id')->paginate(60);

        return view('livewire.return-sell.show', compact('invoices'));
    
    }
    public function printSelected()
    {
        session()->flash('message', 'Print triggered for selected invoices!');
    }



    public function payment($id)
    {
        $user = Auth::guard('account')->user();
        if ($user->role !== 'admin') {

            flash()->error('يمكن للمسؤول فقط حذف الفواتير');
            return;
        }
        $sell = Sellinfo::where('sell_invoice_id', $id)->first();

        if ($sell) {
            $sell->cash = false;
            $sell->save();
        }
    }

    public function paymentmulti()
    {
        $user = Auth::guard('account')->user();
        if ($user->role !== 'admin') {

            flash()->error('يمكن للمسؤول فقط حذف الفواتير');
            return;
        }
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
            ->update(['cash' => false]);

        session()->flash('message', 'تم تحديث حالة الدفع بنجاح.');

        $this->selectedInvoices = [];
        $this->selectAll = false;
    }










    public function delete($id)
    {
        $user = Auth::guard('account')->user();
        if ($user->role !== 'admin') {

            flash()->error('يمكن للمسؤول فقط حذف الفواتير');
            return;
        }
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
}
