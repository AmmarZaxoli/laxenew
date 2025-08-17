<?php

namespace App\Livewire\Offers;

use App\Models\Offer;
use App\Models\Product;
use App\Models\Type;
use App\Models\Sub_Buy_Products_invoice;
use App\Models\Sub_Offer;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
class Edit extends Component
{
    use WithPagination;

    public $offers;
    public $availableProducts;
    public $selectedProducts = [];
    public $offerId;
    public $search = '';
    public $selectedType = '';
    public $types;
    public $quantities = [];
    public $nameoffer, $barcode, $code, $price;

    public $totalBuy = [];
    public $remainingQty  = 0;
    public $q_s  = 0;
public function confirmRemoveOffer($offerId)
{
    $this->dispatch('confirm-remove-offer', id: $offerId);
}

// Add this attribute above the method
#[On('remove-offer')]
public function removeOffer($offerId)
{
    try {
        // Find the offer
        $offer = Offer::findOrFail($offerId);
        
        // Delete related sub_offers first
        Sub_Offer::where('offer_id', $offerId)->delete();
        
        // Then delete the offer
        $offer->delete();
        
        // Refresh the offers list
        $this->mount();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'تم حذف الاوفر بنجاح'
        ]);
    } catch (\Exception $e) {
        $this->dispatch('notify', [
            'type' => 'error',
            'message' => 'حدث خطأ أثناء حذف الاوفر: ' . $e->getMessage()
        ]);
    }
}
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

    public function mount()
    {
        $this->types = Type::all();
        $this->offers = Offer::with(['products.definition'])->get();
        $this->availableProducts = Product::with(['definition', 'definition.type'])
            ->where('quantity', '>', 0)->get();
    }

    public function storeOffer()
    {
        $this->validate([
            'nameoffer' => 'required|string|max:255',
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

        session()->flash('success', 'تم الإضافة بنجاح.');
        $this->reset(['nameoffer', 'code', 'price', 'selectedProducts']);

        $this->mount();
    }

    public function addProduct($productId)
    {
        $product = Product::with(['definition', 'type'])->find($productId);
        if (!$product || !$product->definition) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'المنتج غير موجود أو لا يحتوي على تعريف'
            ]);
            return;
        }

        $sub = sub_Buy_Products_invoice::where('product_id', $productId)->latest()->first();

        // Check if product already exists in selectedProducts
        $exists = collect($this->selectedProducts)->contains('id', $productId);

        if (!$exists) {
            $this->selectedProducts[] = [
                'id' => $productId,
                'name' => $product->definition->name ?? 'N/A',
                'code' => $product->definition->code ?? 'N/A',
                'barcode' => $product->definition->barcode ?? 'N/A',
                'quantity' => 1,
                'stock' => $product->quantity ?? 0,
                'type' => $product->type->typename ?? 'غير محدد',
                'price' => $sub->buy_price ?? 0,
            ];
        }
    }

    public function removeProduct($index)
    {
        if (isset($this->selectedProducts[$index])) {
            unset($this->selectedProducts[$index]);
            $this->selectedProducts = array_values($this->selectedProducts);
        }
    }
    public function getGrandTotalBuy()
    {
        $total = 0;
        foreach ($this->selectedProducts as $product) {
            $productId = $product['id'];
            $pricePerUnit = $this->totalBuy[$productId] ?? 0;
            $qty = $product['quantity'] ?? 0;
            $total += $pricePerUnit * $qty;
        }
        return $total;
    }
    public function validateQuantity($index, $value)
    {
        if (!isset($this->selectedProducts[$index])) return;

        $productId = $this->selectedProducts[$index]['id'];
        $product = Product::find($productId);
        if (!$product) return;

        $requestedQty = (int) $value;
        $availableQty = $product->quantity;

        if ($requestedQty > $availableQty) {
            $this->selectedProducts[$index]['quantity'] = $availableQty;
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => "الكمية المدخلة ($requestedQty) تتجاوز المخزون المتاح ($availableQty)! تم ضبط الكمية إلى $availableQty"
            ]);
        } elseif ($requestedQty <= 0) {
            $this->selectedProducts[$index]['quantity'] = 1;
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => "الكمية يجب أن تكون على الأقل 1! تم ضبط الكمية إلى 1"
            ]);
        }
        $buyPrice = $this->totalBuy[$productId] ?? 0;
        $this->totalBuy[$productId] = $buyPrice; // price per unit remains same

    }

    public function editOffer($offerId)
    {
        $offer = Offer::with(['products.definition', 'products.type'])->find($offerId);
        if (!$offer) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'الاوفر غير موجود'
            ]);
            return;
        }

        $this->offerId = $offerId;
        $this->nameoffer = $offer->nameoffer;
        $this->code = $offer->code;
        $this->price = $offer->price;

        $this->selectedProducts = [];
        foreach ($offer->products as $product) {
            $sub = sub_Buy_Products_invoice::where('product_id', $product->id)->latest()->first();

            $this->selectedProducts[] = [
                'id' => $product->id,
                'name' => $product->definition->name ?? 'N/A',
                'code' => $product->definition->code ?? 'N/A',
                'barcode' => $product->definition->barcode ?? 'N/A',
                'quantity' => $product->pivot->quantity ?? 1,
                'stock' => $product->quantity ?? 0,
                'type' => $product->type->typename ?? 'غير محدد',
                'price' => $sub->buy_price ?? 0
            ];
            $this->getTotalBuyByProductId($product->id); // ✅ Add this line

        }
    }

    public function updateOffer()
    {
        $this->validate([
            'nameoffer' => 'required',
            'code' => 'required|unique:offers,code,' . $this->offerId,
            'price' => 'required|integer',
        ]);

        $offer = Offer::findOrFail($this->offerId);
        $offer->update([
            'nameoffer' => $this->nameoffer,
            'code' => $this->code,
            'price' => $this->price,
        ]);

        Sub_Offer::where('offer_id', $this->offerId)->delete();
        foreach ($this->selectedProducts as $product) {
            Sub_Offer::create([
                'offer_id' => $this->offerId,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
            ]);
        }

        session()->flash('success', 'تم تحديث الاوفر بنجاح');
        return redirect()->route('offers.edit');
    }

    public function render()
    {
        $products = collect();
        $query = Product::with(['definition', 'type'])
            ->whereHas('definition', fn($q) => $q->where('is_active', '1'));

        if (trim($this->search)) {
            $term = '%' . $this->search . '%';
            $query->whereHas(
                'definition',
                fn($q) => $q
                    ->where('name', 'like', $term)
                    ->orWhere('code', 'like', $term)
                    ->orWhere('barcode', 'like', $term)
            );
        }

        if ($this->selectedType) {
            $query->whereHas(
                'definition',
                fn($q) =>
                $q->where('type_id', $this->selectedType)
            );
        }

        return view('livewire.offers.edit', [
            'types' => $this->types,
            'products' => $products,
            'filteredProducts' => $query->paginate(10),
        ]);
    }
}
