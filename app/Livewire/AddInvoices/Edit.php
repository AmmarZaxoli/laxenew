<?php

namespace App\Livewire\AddInvoices;

use App\Models\Product;
use Livewire\Component;
use App\Models\Buy_invoice;
use App\Models\Buy_Products_invoice;
use App\Models\Sub_Buy_Products_invoice;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public $search = '';
    public $namecompany = '';

    public $invoiceId;
    public $invoice;
    public $product_id;
    public $products = [];

    // fields for editing
    public $editProductId;
    public $editName;
    public $editCode;
    public $editQuantity;
    public $editBuyPrice;
    public $editDateex;
    public $totalPrice;
    public $discount;
    public $afterDiscountTotalPrice;
    public $cash;
    public $residual;


    public function mount($invoiceId)
    {
        $this->invoiceId = $invoiceId;
        $this->invoice   = Buy_invoice::findOrFail($invoiceId);


        $this->totalPrice = $this->invoice->total_price;
        $this->discount = $this->invoice->discount;
        $this->afterDiscountTotalPrice = $this->invoice->afterDiscountTotalPrice;
        $this->cash = $this->invoice->cash;
        $this->residual = $this->invoice->residual;


        $this->loadProducts();
    }

    public function loadProducts()
    {
        $query = Sub_Buy_Products_invoice::where('num_invoice_id', $this->invoiceId);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%')
                    ->orWhere('barcode', 'like', '%' . $this->search . '%');
            });
        }

        $this->products = $query->get();
    }

    public function updatedSearch()
    {
        $this->loadProducts();
    }

    public function editProduct($id)
    {
        $product = Sub_Buy_Products_invoice::where('buy_product_invoice_id', $id)->first();

        $this->editProductId = $product->buy_product_invoice_id;
        $this->product_id = $product->product_id;
        $this->editName      = $product->name;
        $this->editCode      = $product->code;
        $this->editQuantity  = $product->quantity;
        $this->editBuyPrice  = $product->buy_price;
        $this->editDateex    = $product->dateex;

        $this->dispatch('open-edit-modal'); // fire event to JS
    }

    public function updateProduct()
    {

        $product = Sub_Buy_Products_invoice::where('buy_product_invoice_id', $this->editProductId)->first();

        // Check if the new quantity is less than q_sold
        if ($this->editQuantity < $product->q_sold) {


            flash()->warning("الكمية لا يمكن أن تكون أقل من المباعة ({$product->q_sold})");
            return;
        }

        // Update the Sub_Buy_Products_invoice record
        $product->update([
            'name'      => $this->editName,
            'code'      => $this->editCode,
            'quantity'  => $this->editQuantity,
            'buy_price' => $this->editBuyPrice,
            'dateex'    => $this->editDateex,
        ]);

        // Update Buy_Products_invoice
        $product1 = Buy_Products_invoice::findOrFail($this->editProductId);
        $product1->update([
            'name'      => $this->editName,
            'code'      => $this->editCode,
            'quantity'  => $this->editQuantity,
            'buy_price' => $this->editBuyPrice,
            'dateex'    => $this->editDateex,
        ]);

        $rows = Sub_Buy_Products_invoice::where('product_id', $this->product_id)
            ->whereColumn('q_sold', '<', 'quantity')
            ->get();

        $totals = $rows->reduce(function ($carry, $row) {
            $carry['total_quantity'] += $row->quantity;
            $carry['total_sold']     += $row->q_sold;
            return $carry;
        }, ['total_quantity' => 0, 'total_sold' => 0]);

        $remaining = $totals['total_quantity'] - $totals['total_sold'];



        // Update Product quantity
        $product2 = Product::where('definition_id', $this->product_id)->first();
        if ($product2) {
            $product2->update([
                'quantity' => $remaining,
            ]);
        }


        $invoiceId = $product->num_invoice_id ?? null;

        if ($invoiceId) {
            // Calculate total (before discount) for all items in this invoice
            $totalPrice = Sub_Buy_Products_invoice::where('num_invoice_id', $invoiceId)
                ->sum(DB::raw('quantity * buy_price'));

            // Fetch the invoice
            $invoice = Buy_invoice::find($invoiceId);


            if ($invoice) {
                // Get discount % (if null, set to 0)
                $discount = floatval($invoice->discount ?? 0);

                // Apply discount
                $afterDiscountTotal = $totalPrice - ($totalPrice * $discount / 100);

                // Get cash (if not passed in, use invoice->cash)
                $cash = floatval($cash ?? $invoice->cash ?? 0);

                // Calculate residual = cash - afterDiscountTotal
                $residual = $afterDiscountTotal - $cash;

                // Update invoice
                $invoice->update([
                    'total_price'          => $totalPrice,
                    'afterDiscountTotalPrice' => $afterDiscountTotal,
                    'residual'             => $residual,
                ]);
            }
        }


        $this->invoice->refresh();
        $this->totalPrice              = $this->invoice->total_price;
        $this->discount                = $this->invoice->discount;
        $this->afterDiscountTotalPrice = $this->invoice->afterDiscountTotalPrice;
        $this->cash                    = $this->invoice->cash;
        $this->residual                = $this->invoice->residual;

        $this->loadProducts();


        $this->reset(['editProductId', 'editName', 'editCode', 'editQuantity', 'editBuyPrice', 'editDateex']);

        $this->dispatch('close-edit-modal'); // close modal
    }



    public $id;
    public function deleteConfirmationproduct($id)
    {
        $this->id = $id;
        $this->dispatch('show-delete-productofinvoicebuy');
    }

    #[On('deleteProduct')]
    public function deleteProduct()
    {
        $product = Sub_Buy_Products_invoice::where('buy_product_invoice_id', $this->id)->first();

        $this->product_id = $product->product_id;

        if ($product->q_sold != 0) {

            flash()->warning('لا يمكنك حذفه لأنه تم بيع بعض منه');
            return;
        }

        Sub_Buy_Products_invoice::where('buy_product_invoice_id', $this->id)->delete();
        Buy_Products_invoice::where('id', $this->id)->delete();



        $rows = Sub_Buy_Products_invoice::where('product_id', $this->product_id)
            ->whereColumn('q_sold', '<', 'quantity')
            ->get();

        $totals = $rows->reduce(function ($carry, $row) {
            $carry['total_quantity'] += $row->quantity;
            $carry['total_sold']     += $row->q_sold;
            return $carry;
        }, ['total_quantity' => 0, 'total_sold' => 0]);

        $remaining = $totals['total_quantity'] - $totals['total_sold'];



        // Update Product quantity
        $product2 = Product::where('definition_id', $this->product_id)->first();
        if ($product2) {
            $product2->update([
                'quantity' => $remaining,
            ]);
        }


        $invoiceId = $product->num_invoice_id ?? null;

        if ($invoiceId) {
            // Calculate total (before discount) for all items in this invoice
            $totalPrice = Sub_Buy_Products_invoice::where('num_invoice_id', $invoiceId)
                ->sum(DB::raw('quantity * buy_price'));

            // Fetch the invoice
            $invoice = Buy_invoice::find($invoiceId);


            if ($invoice) {
                // Get discount % (if null, set to 0)
                $discount = floatval($invoice->discount ?? 0);

                // Apply discount
                $afterDiscountTotal = $totalPrice - ($totalPrice * $discount / 100);

                // Get cash (if not passed in, use invoice->cash)
                $cash = floatval($cash ?? $invoice->cash ?? 0);

                // Calculate residual = cash - afterDiscountTotal
                $residual = $afterDiscountTotal - $cash;

                // Update invoice
                $invoice->update([
                    'total_price'          => $totalPrice,
                    'afterDiscountTotalPrice' => $afterDiscountTotal,
                    'residual'             => $residual,
                ]);
            }
        }


        
        
        
        $this->invoice->refresh();
        $this->totalPrice              = $this->invoice->total_price;
        $this->discount                = $this->invoice->discount;
        $this->afterDiscountTotalPrice = $this->invoice->afterDiscountTotalPrice;
        $this->cash                    = $this->invoice->cash;
        $this->residual                = $this->invoice->residual;
        
        $this->loadProducts();
        flash()->success('تم الحذف بنجاح');
    }

    public function render()
    {
        return view('livewire.add-invoices.edit', [
            'invoice'  => $this->invoice,
            'products' => $this->products,
        ]);
    }
}
