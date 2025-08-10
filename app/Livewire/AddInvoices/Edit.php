<?php

namespace App\Livewire\AddInvoices;

use Livewire\Component;
use App\Models\Buy_invoice;
use App\Models\Buy_Products_invoice;
use App\Models\Sub_Buy_Products_invoice;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class Edit extends Component
{
    public $invoiceId;
    public $invoice;
    public $products = [];

    public $discount = 0;
    public $cash = 0;
    public $note = '';

    public function mount($invoiceId)
    {
        try {
            $this->invoiceId = $invoiceId;

            $this->invoice = Buy_invoice::findOrFail($invoiceId);

            $this->products = Buy_Products_invoice::where('num_invoice_id', $invoiceId)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'product_id' => $product->product_id,
                        'name' => $product->name,
                        'barcode' => $product->barcode,
                        'quantity' => (float)$product->quantity, // Ensure numeric type
                        'buy_price' => (float)$product->buy_price, // Ensure numeric type
                        'sell_price' => (float)$product->sell_price, // Ensure numeric type
                        'profit' => (float)$product->profit, // Ensure numeric type
                        'dateex' => $product->dateex,
                    ];
                })->toArray();

            $this->discount = (float)$this->invoice->discount;
            $this->cash = (float)$this->invoice->cash;
            $this->note = $this->invoice->note;
        } catch (Exception $e) {
            session()->flash('error', 'Failed to load invoice data: ' . $e->getMessage());
        }
    }

    // السعر الكلي قبل الخصم
    public function getTotalPriceProperty()
    {
        try {
            return collect($this->products)->sum(function ($item) {
                // Ensure both values are numeric before multiplication
                $quantity = is_numeric($item['quantity']) ? (float)$item['quantity'] : 0;
                $buyPrice = is_numeric($item['buy_price']) ? (float)$item['buy_price'] : 0;
                return $quantity * $buyPrice;
            });
        } catch (Exception $e) {
            session()->flash('error', 'Failed to calculate total price: ' . $e->getMessage());
            return 0;
        }
    }

    // السعر بعد الخصم
    public function getAfterDiscountTotalPriceProperty()
    {
        try {
            $total = $this->totalPrice;
            $discount = is_numeric($this->discount) ? (float)$this->discount : 0;
            return $total - ($total * $discount / 100);
        } catch (Exception $e) {
            session()->flash('error', 'Failed to calculate after discount price: ' . $e->getMessage());
            return 0;
        }
    }

    // المتبقي بعد الدفع
    public function getResidualProperty()
    {
        try {
            $afterDiscount = $this->afterDiscountTotalPrice;
            $cash = is_numeric($this->cash) ? (float)$this->cash : 0;
            return $afterDiscount - $cash;
        } catch (Exception $e) {
            session()->flash('error', 'Failed to calculate residual amount: ' . $e->getMessage());
            return 0;
        }
    }

    public function updateInvoice()
    {
        try {
            DB::transaction(function () {
                try {
                    foreach ($this->products as $updatedProduct) {
                        $invoiceProduct = Buy_Products_invoice::find($updatedProduct['id']);

                        if ($invoiceProduct) {
                            $productModel = Product::find($invoiceProduct->product_id);

                            if ($productModel) {
                                // ارجع الكمية القديمة
                                $productModel->quantity -= (float)$invoiceProduct->quantity;
                            }

                            $invoiceProduct->update([
                                'quantity' => (float)$updatedProduct['quantity'],
                                'buy_price' => (float)$updatedProduct['buy_price'],
                                'sell_price' => (float)$updatedProduct['sell_price'],
                                'profit' => (float)$updatedProduct['profit'],
                                'dateex' => $updatedProduct['dateex'] ?? null,
                            ]);

                            if ($productModel) {
                                // اضف الكمية الجديدة
                                $productModel->quantity += (float)$updatedProduct['quantity'];
                                $productModel->price_sell = (float)$updatedProduct['sell_price'];
                                $productModel->save();
                            }
                        }
                    }

                    $invoice = Buy_invoice::find($this->invoiceId);
                    if ($invoice) {
                        $invoice->update([
                            'total_price' => (float)$this->totalPrice,
                            'discount' => (float)$this->discount,
                            'cash' => (float)$this->cash,
                            'afterDiscountTotalPrice' => (float)$this->afterDiscountTotalPrice,
                            'residual' => (float)$this->residual,
                            'note' => $this->note,
                        ]);
                    }
                } catch (Exception $e) {
                    throw new Exception('Failed to update main invoice: ' . $e->getMessage());
                }
            });

            DB::transaction(function () {
                try {
                    foreach ($this->products as $updatedProduct) {
                        $invoiceProduct = Sub_Buy_Products_invoice::find($updatedProduct['id']);

                        if ($invoiceProduct) {
                            $invoiceProduct->update([
                                'quantity' => (float)$updatedProduct['quantity'],
                                'buy_price' => (float)$updatedProduct['buy_price'],
                                'sell_price' => (float)$updatedProduct['sell_price'],
                                'profit' => (float)$updatedProduct['profit'],
                                'dateex' => $updatedProduct['dateex'] ?? null,
                            ]);
                        }
                    }
                } catch (Exception $e) {
                    throw new Exception('Failed to update sub invoice: ' . $e->getMessage());
                }
            });

            session()->flash('success', 'تم تحديث الفاتورة بنجاح.');
            // $this->dispatch('close-driver-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Failed to update invoice: ' );
        }
    }

    public function render()
    {
        try {
            return view('livewire.add-invoices.edit');
        } catch (Exception $e) {
            session()->flash('error', 'Failed to render view: ' . $e->getMessage());
            return view('livewire.error-view');
        }
    }
}