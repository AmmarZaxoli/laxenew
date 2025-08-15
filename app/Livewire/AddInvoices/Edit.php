<?php

namespace App\Livewire\AddInvoices;

use Livewire\Component;
use App\Models\Buy_invoice;
use App\Models\Buy_Products_invoice;
use App\Models\Sub_Buy_Products_invoice;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

use Exception;

class Edit extends Component
{

    public $showAddForm = false;
    public $newProduct = [
        'product_id' => null,
        'name' => '',
        'barcode' => '',
        'quantity' => 1,
        'buy_price' => 0,
        'dateex' => null,
        'q_sold' => 0,
        'profit' => 0
    ];

    public $showUpdateButton = true; // initially visible

    public function toggleAddForm()
    {
        $this->showAddForm = !$this->showAddForm;
        $this->showUpdateButton = !$this->showAddForm;
    }

    public $invoiceId;
    public $invoice;
    public $namecompany;
    public $products = [];

    public $discount = 0;
    public $cash = 0;
    public $note = '';

    // Add this method to your Livewire component
    public function updatedProducts($value, $key)
    {
        // Parse the index and field from the key (e.g., "0.quantity")
        $parts = explode('.', $key);
        $index = $parts[0];
        $field = $parts[1];

        // Only validate if quantity is being updated
        if ($field === 'quantity') {
            $qSold = $this->products[$index]['q_sold'] ?? 0;
            $newQuantity = $value;

            if ($newQuantity < $qSold) {
                // Reset to the previous valid quantity or q_sold, whichever is higher
                $this->products[$index]['quantity'] = max($qSold, $this->products[$index]['quantity']);

                // Show error message
                session()->flash('error', 'لا يمكن أن تكون الكمية أقل من الكمية المباعة (' . $qSold . ')');
            }
        }
    }
    public function mount($invoiceId)
    {
        try {
            $this->invoiceId = $invoiceId;

            $this->invoice = Buy_invoice::findOrFail($invoiceId);
            $this->namecompany = $this->invoice->name_invoice;

            $this->products = Sub_Buy_Products_invoice::where('num_invoice_id', $invoiceId)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'product_id' => $product->product_id,
                        'name' => $product->name,
                        'barcode' => $product->barcode,
                        'quantity' => (float)$product->quantity,
                        'q_sold' => (float)$product->q_sold,
                        'buy_price' => (float)$product->buy_price,
                        'profit' => (float)$product->profit,
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
        // Validate quantities before saving
        foreach ($this->products as $index => $product) {
            if ($product['quantity'] < $product['q_sold']) {
                session()->flash('error', 'لا يمكن أن تكون الكمية أقل من الكمية المباعة للمنتج: ' . $product['name']);
                return;
            }
        }

        try {
            DB::transaction(function () {
                try {
                    foreach ($this->products as $updatedProduct) {
                        $invoiceProducto = Buy_Products_invoice::find($updatedProduct['id']);


                        if ($invoiceProducto) {
                            $productModel = Product::find($invoiceProducto->product_id);

                            if ($productModel) {
                                // ارجع الكمية القديمة
                                $productModel->quantity -= (float)$invoiceProducto->quantity;
                            }



                            if ($productModel) {
                                // اضف الكمية الجديدة
                                $productModel->quantity += (float)$updatedProduct['quantity'];
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
                                'q_sold' => (float)$updatedProduct['q_sold'],
                                'buy_price' => (float)$updatedProduct['buy_price'],
                                'profit' => (float)$updatedProduct['profit'],
                                'dateex' => $updatedProduct['dateex'] ?? null,
                            ]);
                        }
                    }
                    foreach ($this->products as $updatedProduct) {
                        $invoiceProduct = Buy_Products_invoice::find($updatedProduct['id']);

                        if ($invoiceProduct) {
                            $invoiceProduct->update([
                                'quantity' => (float)$updatedProduct['quantity'],
                                'q_sold' => (float)$updatedProduct['q_sold'],
                                'buy_price' => (float)$updatedProduct['buy_price'],
                                'profit' => (float)$updatedProduct['profit'],
                                'dateex' => $updatedProduct['dateex'] ?? null,
                            ]);
                        }
                    }
                } catch (Exception $e) {
                    throw new Exception('Failed to update sub invoice: ' . $e->getMessage());
                }
            });


            // // ✅ Cleanup step AFTER saving
            // DB::transaction(function () {
            //     // 1. Remove products with quantity = 0 and q_sold = 0
            //     $productsToDelete = Buy_Products_invoice::where('num_invoice_id', $this->invoiceId)
            //         ->where('quantity', 0)
            //         ->where('q_sold', 0)
            //         ->get();
            //     foreach ($productsToDelete as $prod) {
            //         Sub_Buy_Products_invoice::where('id', $prod->id)->delete();
            //         $prod->delete();
            //     }

            //     // 2. Remove invoice if total_price = 0
            //     $invoice = Buy_invoice::find($this->invoiceId);
            //     if ($invoice && $invoice->total_price == 0) {
            //         // Also delete related products just in case
            //         Buy_Products_invoice::where('num_invoice_id', $invoice->id)->delete();
            //         Sub_Buy_Products_invoice::where('num_invoice_id', $invoice->id)->delete();
            //         $invoice->delete();
            //     }
            // });

            session()->flash('success', 'تم تحديث الفاتورة بنجاح.');
            return redirect()->route('show_Invoices.create');
        } catch (Exception $e) {
            session()->flash('error', 'Failed to update invoice: ' . $e->getMessage());
        }
    }

    public $id;

    public function deleteConfirmation($id)
    {
        $this->id = $id;
        // This sends the event to the browser (JS)
        $this->dispatch('show-delete-confirmation');
    }

    #[On('deleteConfirmed')]
    public function removeProduct()
    {
        $productInfo = Sub_Buy_Products_invoice::where('buy_product_invoice_id', $this->id)->firstOrFail();

        if (!$productInfo) {
            session()->flash('error', 'المنتج غير موجود');
            return;
        }

        if ($productInfo->q_sold === 0) {
            DB::transaction(function () use ($productInfo) {
                $invoice = Buy_invoice::find($this->invoiceId);
                if ($invoice) {
                    $amount = $productInfo->buy_price * $productInfo->quantity;
                    $invoice->total_price -= $amount;
                    $invoice->afterDiscountTotalPrice -= $amount;
                    $invoice->residual -= $amount;
                    $invoice->save();
                }
                // Get the last sell_price for the same product from Sub_Buy_Products_invoice


                // Update product quantity
                Product::where('definition_id', $productInfo->product_id)
                    ->decrement('quantity', $productInfo->quantity ?? 0);

                // Delete from related tables
                Buy_Products_invoice::where('id', $productInfo->id)->delete();
                Sub_Buy_Products_invoice::where('buy_product_invoice_id', $productInfo->id)->delete();
                $productInfo->delete();


                $lastSellPrice = Sub_Buy_Products_invoice::where('product_id', $productInfo->product_id)
                    ->orderBy('created_at', 'desc')
                    ->value('sell_price');

                if ($lastSellPrice) {
                    Product::where('definition_id', $productInfo->product_id)
                        ->update(['price_sell' => $lastSellPrice]);
                }
            });

            flash()->success('تم حذف المنتج وتحديث الكمية والسعر بنجاح');
            return redirect()->route('show_Invoices.create');
        } else {
            flash()->warning('لا يمكن حذف المنتج لأنه تم بيع جزء منه');
        }
    }


    public function render()
    {
        return view('livewire.add-invoices.edit');
    }
}
