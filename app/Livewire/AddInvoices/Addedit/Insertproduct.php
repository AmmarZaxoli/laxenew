<?php

namespace App\Livewire\AddInvoices\Addedit;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Buy_invoice;
use App\Models\Buy_Products_invoice;
use App\Models\Sub_Buy_Products_invoice;
use App\Models\Company;
use App\Models\Paymentinvoce;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class Insertproduct extends Component
{
    protected $listeners = ['productSelected'];

    // public $invoicevisibale = false;
    public $product_id = '';
    public $invoice = '';
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

    public $num_invoice = '';



    public $datecreate = '';

    public $products = [];

    public $Totalprice = 0;

    public $discount = 0;

    public $cash = 0;
    public $note = '';
    public $afterDiscountTotalPrice = 0;
    public $aftercash = 0;

    public $invoiceId;
    public $companyName;

    public function mount($invoiceId, $companyName)
    {
        $this->datecreate = now()->format('Y-m-d\TH:i');
        $this->invoiceId = $invoiceId;
        $this->companyName = $companyName;
    }

    public function getTotalTpriceProperty()
    {
        return collect($this->products)->sum('tprice');
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




    public function addproduct()
    {

        try {


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
                        'num_invoice_id' => $this->invoiceId,
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
                        'num_invoice_id'          => $this->invoiceId,
                        'buy_product_invoice_id'  => $buyProductInvoice->id,
                    ]);
                }

                // Update Buy_invoice totals
                $invoice = Buy_invoice::find($this->invoiceId);

                if ($invoice) {
                    $total    = $invoice->total_price + $this->totalTprice;
                    $discount = floatval($invoice->discount);

                    $afterDiscountTotal = $total - ($total * $discount / 100);
                    $residual           = $afterDiscountTotal - $invoice->cash;

                    $invoice->update([
                        'total_price'             => $total,
                        'afterDiscountTotalPrice' => $afterDiscountTotal,
                        'residual'                => $residual,
                    ]);
                }
                // Reset form state
                $this->products = [];
                $this->reset(
                    'num_invoice',
                    'name_invoice',
                    'search',
                    'discount',
                    'cash'
                );

                sweetalert()->addSuccess('تم حفظ جميع المنتجات بنجاح.');
                return redirect()->route('show_Invoices.create');
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
    public $search = '';
    public $name_invoice = '';
    public function render()
    {
        return view('livewire.add-invoices.addedit.insertproduct');
    }
}
