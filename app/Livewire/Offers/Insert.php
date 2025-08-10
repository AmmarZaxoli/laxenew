<?php

namespace App\Livewire\Offers;


use App\Models\Product;
use App\Models\Sub_Buy_Products_invoice;
use App\Models\Type;
use App\Models\Offer;
use App\Models\Sub_Offer;
use Livewire\Component;

class Insert extends Component
{
    public $search_code_name = '';
    public $selected_type = '';
    public $types;
    public $selectedProducts = [];
    public $quantities = [];
    public $nameoffer, $code, $price;

    public function mount()
    {
        $this->types = Type::all();
    }

    public function storeOffer()
    {
        $this->validate([
            'nameoffer' => 'required|string|max:255|unique:offers,nameoffer',
            'code'      => 'required|string|max:255|unique:offers,code',
            'price'     => 'required|integer|min:0',
        ]);


        $offer = Offer::create([
            'nameoffer' => $this->nameoffer,
            'code'      => $this->code,
            'price'     => $this->price,
        ]);

        foreach ($this->selectedProducts as $product) {
            Sub_Offer::create([
                'offer_id'   => $offer->id,
                'product_id' => $product['id'],
                'quantity'   => $product['quantity'],
            ]);
        }

        flash()->success('تم الإضافة بنجاح.');
        $this->reset(['nameoffer', 'code', 'price', 'selectedProducts']);
    }



    public function addProduct($productId)
    {


        $product = Product::with(['type', 'definition'])->find($productId);
        if (!$product) return;

        $sub = Sub_Buy_Products_invoice::where('product_id', $productId)->latest()->first();
        if (!$sub) return;

        if (!isset($this->selectedProducts[$productId])) {
            $this->selectedProducts[$productId] = [
                'id' => $productId,
                'name' => $product->definition->name,
                'code' => $product->definition->code,
                'barcode' => $product->definition->barcode,
                'quantity' => 1,
                'stock' => $product->quantity,
                'type' => $product->type->typename ?? 'غير محدد',
                'price' => $sub->buy_price ?? 0,
            ];
            $this->getTotalBuyByProductId($productId);
        }
    }
    public function validateQuantity($productId, $value)
    {
        if (!isset($this->selectedProducts[$productId])) return;

        $product = Product::find($productId);
        if (!$product) return;

        $requestedQty = (int) $value;
        $availableQty = $product->quantity;

        if ($requestedQty > $availableQty) {
            $this->selectedProducts[$productId]['quantity'] = $availableQty;
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => "الكمية المدخلة ($requestedQty) تتجاوز المخزون المتاح ($availableQty)! تم ضبط الكمية إلى $availableQty"
            ]);
            $requestedQty = $availableQty; // adjust for recalculation
        } elseif ($requestedQty <= 0) {
            $this->selectedProducts[$productId]['quantity'] = 1;
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => "الكمية يجب أن تكون على الأقل 1! تم ضبط الكمية إلى 1"
            ]);
            $requestedQty = 1; // adjust for recalculation
        } else {
            $this->selectedProducts[$productId]['quantity'] = $requestedQty;
        }

        // Recalculate totalBuy for this product, considering new quantity
        $buyPrice = $this->totalBuy[$productId] ?? 0;

        // Actually your totalBuy stores the average buy price, so multiply by quantity
        // So update totalBuy for this product accordingly:
        $this->totalBuy[$productId] = $buyPrice; // price per unit remains same

        // Just to trigger Livewire update, you can also force reassign:

    }


    public function removeProduct($productId)
    {
        unset($this->selectedProducts[$productId]);
    }
    public function getGrandTotalBuy()
    {
        $total = 0;
        foreach ($this->selectedProducts as $productId => $product) {
            $pricePerUnit = $this->totalBuy[$productId] ?? 0;
            $qty = $product['quantity'] ?? 0;
            $total += $pricePerUnit * $qty;
        }
        return $total;
    }

    public $totalBuy = [];
    public $remainingQty  = 0;
    public $q_s  = 0;
    public function getTotalBuyByProductId($productId)
    {
        $records = Sub_Buy_Products_invoice::where('product_id', $productId)->get();

        $remainingQty = 0;
        $q_s = 0;
        $total = 0;

        foreach ($records as $r) {
            if ($r->quantity >= $r->q_sold) {
                $remainingQty += $r->quantity;
                $q_s += $r->q_sold;
                $total += ($r->quantity - $r->q_sold) * $r->buy_price;
            }
        }

        $remainingQty -= $q_s;

        if ($remainingQty > 0) {
            $this->totalBuy[$productId] = $total / $remainingQty;
        } else {
            $this->totalBuy[$productId] = 0;
        }

        return $this->totalBuy[$productId];
    }



    public function render()
    {
        $products = collect(); // Empty by default

        // Only run query if there's a search or selected type
        if (!empty($this->search_code_name) || !empty($this->selected_type)) {
            $products = Product::with(['definition', 'definition.type'])
                ->whereHas('definition', function ($query) {
                    $query->where('is_active', 'active')->where('quantity', '>', 0);

                    if (!empty($this->search_code_name)) {
                        $query->where(function ($subQuery) {
                            $subQuery->where('name', 'like', "%{$this->search_code_name}%")
                                ->orWhere('code', 'like', "%{$this->search_code_name}%");
                        });
                    }

                    if (!empty($this->selected_type)) {
                        $query->where('type_id', $this->selected_type);
                    }
                })
                ->paginate(10);
        }


        return view('livewire.offers.insert', [
            'products' => $products,
        ]);
    }
}
