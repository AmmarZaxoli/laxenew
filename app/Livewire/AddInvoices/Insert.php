<?php

namespace App\Livewire\AddInvoices;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Buy_invoice;
use App\Models\Buy_Products_invoice;
use App\Models\Sub_Buy_Products_invoice;
use App\Models\Company;
use App\Models\Paymentinvoce;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class Insert extends Component
{
    protected $listeners = ['productSelected'];

    // public $invoicevisibale = false;
    public $product_id = '';
    public $invoice = '';
    #[Session('info_invoice')]
    public $info_invoice;
    public $name = '';
    public $barcode = '';
    public $code = '';
    public $type_id = '';
    public $dateex = '';
    public $tprice = 0;
    public $profit = 0;

    #[Validate('required|numeric|min:1')]

    public $quantity = 0;

    #[Validate('required|numeric|min:0.01')]
    public $buy_price = 0;

    #[Validate('required|numeric|min:0.01')]
    public $sell_price = 0;

    #[Validate('required|string|max:255')]
    #[Session('num_invoice')]
    public $num_invoice = '';



    public $datecreate = '';
    #[Session('products')]
    public $products = [];

    public $Totalprice = 0;
    #[Session('discount')]
    public $discount = 0;
    #[Session('cash')]
    public $cash = 0;
    public $note = '';
    public $afterDiscountTotalPrice = 0;
    public $aftercash = 0;

    public function getTotalTpriceProperty()
    {
        return collect($this->products)->sum('tprice');
    }

    // السعر بعد الخصم
    public function getAfterDiscountTotalPriceProperty()
    {
        $total = $this->totalTprice;
        $discount = floatval($this->discount);
        return $this->afterDiscountTotalPrice = $total - ($total * $discount / 100);
    }
    // المتبقي بعد الدفع
    public function getAfterCashProperty()
    {
        return $this->getAfterDiscountTotalPriceProperty() - floatval($this->cash);
    }






    public function productSelected($product)
    {
        $this->product_id = $product['id'];
        $this->name = $product['name'];
        $this->code = $product['code'];
        $this->barcode = $product['barcode'];
        $this->type_id = $product['type_id'];



        $this->buy_price = 0;
        $this->sell_price = 0;
        $this->quantity = 0;
        $this->updated('quantity');
    }

    public function updated($key)
    {
        $qty = max(0, floatval($this->quantity ?? 0));
        $buy = max(0, floatval($this->buy_price ?? 0));
        $sell = max(0, floatval($this->sell_price ?? 0));

        $this->tprice = $qty * $buy;
        $this->profit = $buy > 0 ? round((($sell - $buy) / $buy) * 100, 2) : 0;
    }

    public function mount()
    {
        $this->datecreate = now()->format('Y-m-d\TH:i');
    }

    public function storeinvoice()
    {
        try {
            $this->validate([
                'num_invoice' => [
                    'required',
                    'string',
                    Rule::unique('buy_invoices')->where(function ($query) {
                        return $query->where('name_invoice', $this->name_invoice);
                    }),
                ],
                'name_invoice' => 'required|string|max:255',
                'datecreate' => 'required|date',
            ]);

            if (empty($this->name_invoice)) {
                sweetalert()->error('الرجاء الاختيار اسم شريكة');
                return;
            }

            if (trim($this->search) === '') {
                sweetalert()->error('الرجاء الاختيار اسم شريكة');
                return;
            }

            $invoice = Buy_invoice::create([
                'num_invoice' => $this->num_invoice,
                'name_invoice' => $this->search,
                'datecreate' => $this->datecreate,
            ]);

            $this->info_invoice = $invoice;
            $this->invoicevisibale = true;

            sweetalert()->addSuccess('تم إنشاء الفاتورة بنجاح.');
        } catch (\Exception $e) {
            Log::error('فشل في إنشاء الفاتورة: ' . $e->getMessage());
            sweetalert()->error('حدث خطأ أثناء إنشاء الفاتورة. يرجى المحاولة مرة أخرى.');
        }
    }

    public function addproduct()
    {
        try {
            if (empty($this->info_invoice)) {
                sweetalert()->error('يرجى إنشاء الفاتورة أولاً قبل إضافة المنتجات.');
                return;
            }

            if (empty($this->name)) {
                sweetalert()->error('الرجاء اختيار المنتج');
                return;
            }

            $this->validate([
                'product_id' => 'required|exists:products,id',
                'name' => 'required|string',
                'barcode' => 'required|string',
                'code' => 'required|string',
                'type_id' => 'required|exists:types,id',
                'quantity' => 'required|numeric|min:1',
                'buy_price' => 'required|numeric|min:0.01',
                'sell_price' => 'required|numeric|min:0.01',
                'profit' => 'required|numeric',
                'dateex' => 'nullable|date',
            ]);

            $this->products[] = [
                'product_id' => $this->product_id,
                'name' => $this->name,
                'barcode' => $this->barcode,
                'code' => $this->code,
                'type_id' => $this->type_id,
                'quantity' => $this->quantity,
                'buy_price' => $this->buy_price,
                'sell_price' => $this->sell_price,
                'profit' => $this->profit,
                'dateex' => $this->dateex,
                'tprice' => $this->quantity * $this->buy_price,
            ];

            $this->resetProductFields();
            $this->dispatch('clearSearchAndFocus');

            sweetalert()->addSuccess('تمت إضافة المنتج إلى الفاتورة.');
        } catch (\Exception $e) {
            Log::error('خطأ أثناء إضافة المنتج: ' . $e->getMessage());
            sweetalert()->error('حدث خطأ أثناء إضافة المنتج. يرجى المحاولة مرة أخرى.');
        }
    }

    public function store()
    {
        try {
            if (empty($this->products)) {
                sweetalert()->error('لا يوجد منتجات لحفظها.');
                return;
            }

            if ($this->cash === '' || $this->cash === null) {
                $this->cash = 0;
            }

            if ($this->discount === '' || $this->discount === null) {
                $this->discount = 0;
            }

            DB::transaction(function () {
                foreach ($this->products as $product) {
                    // Save product to invoice items
                    $buyProductInvoice = Buy_Products_invoice::create([
                        'product_id'     => $product['product_id'],
                        'name'           => $product['name'],
                        'barcode'        => $product['barcode'],
                        'code'           => $product['code'],
                        'type_id'        => $product['type_id'],
                        'datecreate'     => $this->datecreate,
                        'quantity'       => $product['quantity'],
                        'buy_price'      => $product['buy_price'],
                        'sell_price'     => $product['sell_price'],
                        'profit'         => $product['profit'],
                        'dateex'         => $product['dateex'] ?: null,
                        'q_sold'         => 0,
                        'num_invoice_id' => $this->info_invoice->id,
                    ]);

                    // Update stock in product table
                    $productModel = Product::find($product['product_id']);
                    if ($productModel) {
                        $productModel->quantity += $product['quantity'];
                        $productModel->price_sell = $product['sell_price'];
                        $productModel->save();
                    }

                    // Create sub invoice entry
                    sub_Buy_Products_invoice::create([
                        'product_id'              => $product['product_id'],
                        'name'                    => $product['name'],
                        'barcode'                 => $product['barcode'],
                        'code'                    => $product['code'],
                        'type_id'                 => $product['type_id'],
                        'datecreate'              => $this->datecreate,
                        'quantity'                => $product['quantity'],
                        'buy_price'               => $product['buy_price'],
                        'sell_price'              => $product['sell_price'],
                        'profit'                  => $product['profit'],
                        'dateex'                  => $product['dateex'] ?: null,
                        'q_sold'                  => 0,
                        'num_invoice_id'          => $this->info_invoice->id,
                        'buy_product_invoice_id'  => $buyProductInvoice->id,
                    ]);
                }

                // Update Buy_invoice totals
                $invoice = Buy_invoice::find($this->info_invoice->id);
                if ($invoice) {
                    $invoice->update([
                        'total_price'             => $this->totalTprice,
                        'discount'                => $this->discount,
                        'cash'                    => $this->cash,
                        'afterDiscountTotalPrice' => $this->getAfterDiscountTotalPriceProperty(),
                        'residual'                => $this->getAfterCashProperty(),
                        'note'                    => $this->note,
                    ]);
                }

                // Create payment record
                paymentinvoce::create([
                    'date_payment' => $this->datecreate,
                    'cashpayment'  => $this->cash,
                    'invoce_id'    => $this->info_invoice->id,
                ]);

                // Reset form state
                $this->products = [];
                $this->invoicevisibale = false;
                $this->reset(
                    'num_invoice',
                    'name_invoice',
                    'search',
                    'discount',
                    'cash'
                );

                sweetalert()->addSuccess('تم حفظ جميع المنتجات بنجاح.');
            });
        } catch (\Exception $e) {
            Log::error('فشل حفظ الفاتورة: ' . $e->getMessage());
            sweetalert()->error('حدث خطأ أثناء حفظ المنتجات. يرجى المحاولة مرة أخرى.');
        }
    }


    protected function resetProductFields()
    {
        $this->reset([
            'product_id',
            'name',
            'barcode',
            'code',
            'type_id',
            'quantity',
            'buy_price',
            'sell_price',
            'profit',
            'tprice',
            'dateex',

        ]);
    }

    public function removeProduct($index)
    {
        if (isset($this->products[$index])) {
            unset($this->products[$index]);
            $this->products = array_values($this->products);
        }
    }

    #[Session('search')]
    public $search = '';
    public $companys = [];
    public $showDropdown = false;
    #[Session('invoicevisibale')]
    public $invoicevisibale = false;
    #[Session('name_invoice')]
    public $name_invoice = '';

    public function showCompanies()
    {
        // Load initial companies when input is clicked
        $this->companys = Company::limit(10)->get();
        $this->showDropdown = true;
    }

    public function updatedSearch()
    {
        try {
            if (strlen($this->search) >= 1) {
                $this->companys = Company::where('companyname', 'like', '%' . $this->search . '%')
                    ->limit(10)
                    ->get();
            } else {
                $this->showCompanies(); // fallback to first 10 if search is empty
            }

            $this->showDropdown = true;
        } catch (\Exception $e) {
            Log::error('خطأ أثناء البحث عن الشركات: ' . $e->getMessage());
            sweetalert()->error('حدث خطأ أثناء البحث، يرجى المحاولة لاحقاً.');
        }
    }

    public function selectCompany($id)
    {
        try {
            $company = Company::find($id);

            if ($company) {
                $this->search = $company->companyname;
                $this->name_invoice = $company->companyname;
                $this->showDropdown = false;

                $this->dispatch('companySelected', companyId: $id); // optional event
            } else {
                sweetalert()->error('الشركة غير موجودة.');
            }
        } catch (\Exception $e) {
            Log::error('خطأ في اختيار الشركة: ' . $e->getMessage());
            sweetalert()->error('حدث خطأ أثناء تحديد الشركة، حاول مرة أخرى.');
        }
    }

    public function hideDropdown()
    {
        $this->showDropdown = false;
    }
}
