<?php

namespace App\Livewire\Returnproducts;

use App\Models\Type;
use Livewire\Component;
use App\Models\Product;
use App\Models\Seling_product_info;
use App\Models\Sell_invoice;
use App\Models\Offer;
use App\Models\Offer_sell;
use App\Models\SellingProduct;
use App\Models\Sub_Buy_Products_invoice;
use Livewire\WithPagination;
use Livewire\Attributes\Session;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class Show extends Component
{
    use WithPagination;

    public $search_code_name = '';
    public $sell_invoice_id;
    public $num_invoice;
    public $types = '';
    public $mobile = '';
    public $address = '';
    public $selected_type = '';
    public $gitproducts = [];
    public $gitoffers = [];
    public $gitosell = [];
    public $pricetaxi = 0;
    public $discount = 0;
    public $generalpriceoffer = 0;

    public $total_price_invoice = 0;

    #[Session(key: 'note')]
    public $note = "";
    public $totalPrice = 0;
    public $offers = [];
    public $search_offer = '';

    public $Sell_invoice;
    public $customer;
    public $sell;
    public $totalprofit;
    public $startDate;
    public $endDate;

    #[Session('selectedoffer')]
    public $selectedoffer = [];
    public function offersshow()
    {
        $this->offers = Offer::all();
    }


    #[On('loadInvoiceData')]
    public function loadInvoiceData($data)
    {
        $this->num_invoice = $data['num_invoice'];

        $this->returnproduct();
    }


    public function mount()
    {
        $this->types = Type::all();

        $today = now()->format('Y-m-d');
        $this->startDate = $today;
        $this->endDate = $today;
    }




    public function decrementProduct($productId, $price)
    {
        $index = collect($this->gitproducts)->search(fn($item) => $item['product_id'] === $productId);

        if ($index === false) return;

        DB::beginTransaction();

        $product = Product::lockForUpdate()->where('definition_id', $productId)->first();
        $sellingpro = sellingProduct::where('sell_invoice_id', $this->Sell_invoice->id)
            ->where('product_id', $productId)
            ->first();



        if (!$product || !$sellingpro || $sellingpro->quantity <= 0) {
            DB::rollBack();
            flash()->addError('لا يمكن تقليل الكمية: لا توجد كمية صالحة.');
            return;
        }

        // Increase quantity in stock
        $product->increment('quantity', 1);

        // Reduce quantity in invoice
        $sellingpro->quantity -= 1;
        $sellingpro->total_price = $sellingpro->quantity * $sellingpro->price;

        if ($sellingpro->quantity == 0) {
            $sellingpro->delete();
        } else {
            $sellingpro->save();
        }

        $batch = sub_Buy_Products_invoice::where('product_id', $productId)
            ->where('q_sold', '>', 0)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($batch) {
            $batch->decrement('q_sold', 1);
        }

        $profit = $price - $batch->buy_price;

        $sellinfo = seling_product_info::where('sub_id', $batch->id)
            ->where('sell_invoice_id', $this->Sell_invoice->id)
            ->where('product_id', $productId)
            ->orderBy('id', 'desc')
            ->first();

        if ($sellinfo) {
            $sellinfo->quantity_sold -= 1;
            $sellinfo->total_sell -= $batch->sell_price;
            $sellinfo->profit -= $profit;

            if ($sellinfo->quantity_sold <= 0) {
                $sellinfo->delete();
            } else {
                $sellinfo->save();
            }
        }

        if ($this->customer) {
            $this->customer->profit_invoice -= $profit;
            $this->customer->profit_invoice_after_discount = $this->customer->profit_invoice - (float)($this->discount ?? 0);
            $this->customer->save();
        }

        DB::commit();
        $this->sell->discount = (float)($this->discount ?? 0);
        $this->sell->save();
        $this->returnproduct();

        $this->sell->total_price_invoice = $this->total_price_invoice;
        // $this->sell->discount = (float)($this->discount ?? 0);
        $this->sell->total_price_afterDiscount_invoice = $this->total_price_invoice - (float)($this->discount ?? 0);
        $this->sell->save();

        $this->Sell_invoice->total_price = $this->total_price_invoice - (float)($this->discount ?? 0);
        $this->Sell_invoice->save();
    }


    public function incrementProduct($productId, $price)
    {
        $index = collect($this->gitproducts)->search(fn($item) => $item['product_id'] === $productId);


        if ($index === false) return;

        DB::beginTransaction();


        $product = Product::lockForUpdate()->where('definition_id', $productId)->first();


        if (!$product || $product->quantity < 1) {
            DB::rollBack();
            flash()->addError('لا يمكن زيادة الكمية: المنتج غير متوفر.');
            return;
        }

        // Decrease quantity from database
        $product->decrement('quantity', 1);


        $sellingpro = sellingProduct::where('sell_invoice_id', $this->Sell_invoice->id)
            ->where('product_id', $productId)
            ->first();



        if ($sellingpro) {
            $sellingpro->quantity += 1;
            $sellingpro->total_price = $sellingpro->quantity * $sellingpro->price;
            $sellingpro->save();


            $batch = sub_Buy_Products_invoice::where('product_id', $productId)
                ->whereRaw('quantity - q_sold > 0')
                ->orderBy('created_at', 'asc')
                ->first();

            if (!$batch) {
                flash()->error('لديها مشاكل في مخزن والقائمات الشراء');
                return;
            }
            if ($batch) {
                $batch->increment('q_sold', 1);
            }
            $profit = $price - $batch->buy_price;
            $sellinfo = seling_product_info::where('sub_id', $batch->id)
                ->where('sell_invoice_id', $this->Sell_invoice->id)
                ->where('product_id', $batch->product_id)
                ->orderBy('id', 'desc')
                ->first();




            if ($sellinfo) {
                $sellinfo->quantity_sold += 1;
                $sellinfo->total_sell += $batch->sell_price;
                $sellinfo->profit += $profit;
                $sellinfo->save();
            } else {
                seling_product_info::create([
                    'product_id' => $productId,
                    'quantity_sold' => 1,
                    'buy_price' => $batch->buy_price,
                    'total_sell' => $batch->sell_price,
                    'profit' => $profit,
                    'sub_id' => $batch->id,
                    'sell_invoice_id' => $this->Sell_invoice->id,
                ]);
            }





            if ($this->customer) {
                $this->customer->profit_invoice += $profit;
                $this->customer->profit_invoice_after_discount = $this->customer->profit_invoice - (float)($this->discount ?? 0);
                $this->customer->save();
            }


            $this->sell->discount = (float)($this->discount ?? 0);
            $this->sell->save();

            $this->returnproduct();

            $this->sell->total_price_invoice = $this->total_price_invoice;
            // $this->sell->discount = (float)($this->discount ?? 0);
            $this->sell->total_price_afterDiscount_invoice = $this->total_price_invoice - (float)($this->discount ?? 0);

            $this->sell->save();


            $this->Sell_invoice->total_price = $this->total_price_invoice - (float)($this->discount ?? 0);
            $this->Sell_invoice->save();
        } else {
            flash()->addError('المنتج غير موجود في الفاتورة.');
        }



        DB::commit();
    }

    public function incrementOffer($offerId)
    {
        $index = collect($this->gitoffers)->search(fn($item) => $item['id'] == $offerId);
        if ($index === false) return;

        $code = $this->gitoffers[$index]['code'];
        $OrginalOffer = Offer::where('code', $code)->first();
        $offer = Offer::with('subOffers')->findOrFail($OrginalOffer->id);

        DB::beginTransaction();

        try {
            // التأكد من توفر الكمية لكل منتج في العرض
            foreach ($offer->subOffers as $suboffer) {
                $product = Product::lockForUpdate()->find($suboffer->product_id);

                if (!$product || $product->quantity < $suboffer->quantity) {
                    DB::rollBack();
                    flash()->addError('لا يمكن زيادة الكمية: المنتج غير متوفر بالكمية المطلوبة.');
                    return;
                }
            }

            // زيادة كمية العرض
            $this->gitoffers[$index]->quantity++;
            $this->gitoffers[$index]->save();

            // خصم الكميات من المنتجات
            foreach ($offer->subOffers as $suboffer) {
                Product::where('id', $suboffer->product_id)
                    ->decrement('quantity', $suboffer->quantity);
            }


            // حساب الربح
            $price = $this->gitoffers[$index]['price'];
            $this->offerprofit($offer, $price);

            $this->calculate();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }
    public function offerprofit(offer $offer, $price)
    {
        $totalProfit = 0;
        $totalBuyPrice = 0;
        foreach ($offer->subOffers as $suboffer) {
            $product_id = $suboffer->product_id;
            $qty_needed = $suboffer->quantity;
            $remainingQty = $qty_needed;

            $pricePerUnit = $suboffer->price;

            $batches = sub_Buy_Products_invoice::where('product_id', $product_id)
                ->orderBy('created_at', 'asc')
                ->get(['id', 'buy_price', 'quantity', 'q_sold']);

            foreach ($batches as $batch) {
                if ($remainingQty <= 0) break;

                $availableQty = $batch->quantity - $batch->q_sold;
                if ($availableQty <= 0) continue;

                $useQty = min($availableQty, $remainingQty);
                $totalBuyPrice += $useQty * $batch->buy_price;

                $totalSell = $pricePerUnit * $useQty;
                // $profit = $totalSell - ($batch->buy_price * $useQty);

                sub_Buy_Products_invoice::where('id', $batch->id)
                    ->increment('q_sold', $useQty);

                $sellinfo = seling_product_info::where('sub_id', $batch->id)
                    ->where('sell_invoice_id', $this->Sell_invoice->id)
                    ->where('product_id', $product_id)
                    ->first();

                if ($sellinfo) {
                    $sellinfo->quantity_sold += $useQty;
                    // $sellinfo->profit += $profit;
                    $sellinfo->save();
                } else {
                    seling_product_info::create([
                        'product_id' => $product_id,
                        'quantity_sold' => $useQty,
                        'buy_price' => $batch->buy_price,
                        'total_sell' => 0,
                        'profit' => 0,
                        'sub_id' => $batch->id,
                        'sell_invoice_id' => $this->Sell_invoice->id,
                    ]);
                }

                $remainingQty -= $useQty;
            }

            // تحقق من وجود كمية كافية
            if ($remainingQty > 0) {
                flash()->addError("الكمية غير كافية للمنتج (ID: {$product_id}) داخل العرض.");
                throw new \Exception("نقص في الكمية للمنتج ID {$product_id}");
            }
        }
        // dd($totalBuyPrice);
        $totalProfit = $price - $totalBuyPrice;
        // dd($totalProfit);

        // إضافة الربح للزبون

        if ($this->customer) {
            $this->customer->profit_invoice += $totalProfit;

            $this->customer->save();
        }
        if ($this->sell) {
            $this->sell->discount = (float)($this->discount ?? 0);
            $this->sell->save();
        }






        $this->returnproduct();

        $this->sell->total_price_invoice = $this->total_price_invoice;
        // $this->sell->discount = (float)($this->discount ?? 0);
        $this->sell->total_price_afterDiscount_invoice = $this->total_price_invoice - (float)($this->discount ?? 0);

        $this->sell->save();


        $this->Sell_invoice->total_price = $this->total_price_invoice - (float)($this->discount ?? 0);
        $this->Sell_invoice->save();




        return $totalProfit;
    }


    public function decrementOffer($offerId)
    {
        $index = collect($this->gitoffers)->search(fn($item) => $item['id'] == $offerId);
        if ($index === false) return;

        $code = $this->gitoffers[$index]['code'];
        $OrginalOffer = Offer::where('code', $code)->first();
        $offer = Offer::with('subOffers')->findOrFail($OrginalOffer->id);

        if ($this->gitoffers[$index]->quantity <= 0) {
            flash()->addError('لا يمكن تقليل الكمية: الكمية صفر بالفعل.');
            return;
        }

        DB::beginTransaction();

        try {
            // تقليل كمية العرض
            $this->gitoffers[$index]->quantity--;
            $this->gitoffers[$index]->save();

            // استرجاع الكميات إلى المنتجات
            foreach ($offer->subOffers as $suboffer) {
                Product::where('id', $suboffer->product_id)
                    ->increment('quantity', $suboffer->quantity);
            }

            // عكس الربح
            $price = $this->gitoffers[$index]['price'];
            $this->reverseOfferProfit($offer, $price, $offerId);



            $this->calculate();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('حدث خطأ أثناء تقليل العرض: ' . $e->getMessage());
        }
    }



    public function reverseOfferProfit(Offer $offer, $price, $offerId)
    {
        // $totalReversedProfit = 0;
        $total_buyPrice = 0;

        foreach ($offer->subOffers as $suboffer) {
            $product_id = $suboffer->product_id;
            $qtyToReverse = $suboffer->quantity;
            $remainingQty = $qtyToReverse;
            $pricePerUnit = $suboffer->price;

            $batches = sub_Buy_Products_invoice::where('product_id', $product_id)
                ->where('q_sold', '>', 0)
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($batches as $batch) {
                if ($remainingQty <= 0) break;

                $usedQty = min($batch->q_sold, $remainingQty);
                $batch->decrement('q_sold', $usedQty);
                $total_buyPrice += $batch->buy_price * $usedQty;


                $profit = ($pricePerUnit - $batch->buy_price) * $usedQty;
                $totalReversedProfit = $profit;
                // dd($totalReversedProfit);

                $sellinfo = seling_product_info::where('sub_id', $batch->id)
                    ->where('sell_invoice_id', $this->Sell_invoice->id)
                    ->where('product_id', $product_id)
                    ->first();

                if ($sellinfo) {
                    $sellinfo->quantity_sold -= $usedQty;
                    // $sellinfo->profit -= $profit;

                    if ($sellinfo->quantity_sold <= 0) {
                        $sellinfo->delete();
                    } else {
                        $sellinfo->save();
                    }
                }

                $remainingQty -= $usedQty;
            }



            if ($remainingQty > 0) {
                flash()->addError("لا يمكن عكس كامل الكمية للمنتج (ID: {$product_id}).");
                throw new \Exception("نقص في q_sold لعكس الكمية للمنتج ID {$product_id}");
            }
        }


        $selloffer = Offer_sell::where('sell_invoice_id', $this->Sell_invoice->id)
            ->where('id', $offerId)
            ->first();



        if ($selloffer && $selloffer->quantity == 0) {
            $selloffer->delete();
        }


        // خصم الربح من الزبون والفاتورة
        if ($this->customer) {
            $this->customer->profit_invoice += $total_buyPrice - $price;
            $this->customer->profit_invoice_after_discount = $this->customer->profit_invoice - (float)($this->discount ?? 0);
            $this->customer->save();
        }

        if ($this->sell) {
            $this->sell->discount = (float)($this->discount ?? 0);
            $this->sell->save();
        }




        $this->returnproduct();

        $this->sell->total_price_invoice = $this->total_price_invoice;
        // $this->sell->discount = (float)($this->discount ?? 0);
        $this->sell->total_price_afterDiscount_invoice = $this->total_price_invoice - (float)($this->discount ?? 0);

        $this->sell->save();


        $this->Sell_invoice->total_price = $this->total_price_invoice - (float)($this->discount ?? 0);
        $this->Sell_invoice->save();




        return $totalReversedProfit;
    }


    public function calculate()
    {
        $this->total_price_invoice = 0;

        foreach ($this->gitproducts as $product) {
            $this->total_price_invoice += $product['total_price'] ?? 0;
        }
        foreach ($this->gitoffers as $offer) {
            $this->total_price_invoice += $offer['price'] * $offer['quantity'] ?? 0;
        }
    }



    protected function updateProductTotal($product)
    {
        // Update the total price calculation
        $product['total_price'] = $product['quantity'] * $product['price'];
        // Trigger any necessary events or calculations
    }







    public function returnproduct()
    {
        $this->Sell_invoice = Sell_invoice::where('num_invoice_sell', $this->num_invoice)->first();


        if (! $this->Sell_invoice) {
            $this->gitproducts = [];
            return;
        }

        $this->gitproducts =  $this->Sell_invoice->products;


        $offers = $this->Sell_invoice?->offersell ?? collect();

        $this->gitoffers = $offers->isEmpty() ? [] : $offers;

        $this->gitoffers = $offers;



        $this->customer = $this->Sell_invoice->customer;
        $this->mobile = $this->customer?->mobile ?? '';
        $this->address = $this->customer?->address ?? '';
        $this->totalprofit = $this->customer?->profit_invoice ?? '';


        $this->sell = $this->Sell_invoice?->sell;

        $this->pricetaxi = $this->sell?->taxi_price ?? 0;
        $this->discount = $this->sell?->discount ?? 0;

        $this->calculate();
    }
    public function EditInvoice()
    {
        if(empty($this->discount)){
            $this->discount=0;
        }
        
        $this->customer->mobile = $this->mobile;
        $this->customer->address = $this->address;
        $this->customer->note = $this->note;
        $this->customer->profit_invoice_after_discount = $this->totalprofit - $this->discount ?? 0;
        $this->customer->save();

        $this->sell->taxi_price = $this->pricetaxi;
        $this->sell->discount = (float)($this->discount ?? 0);
        $this->sell->total_price_invoice = $this->total_price_invoice;
        $this->sell->total_price_afterDiscount_invoice = $this->total_price_invoice - (float)($this->discount ?? 0);
        $this->sell->save();


        $this->Sell_invoice->total_price = $this->total_price_invoice - (float)($this->discount ?? 0);
        $this->Sell_invoice->save();

        $this->dispatch('invoiceUpdated');

        $this->returnproduct();

        $this->dispatch('close-modal');
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


        return view('livewire.returnproducts.show', [
            'products' => $products,
            'totalPrice' => $this->totalPrice,
            'generalpriceoffer' => $this->generalpriceoffer,
        ]);
    }
}
