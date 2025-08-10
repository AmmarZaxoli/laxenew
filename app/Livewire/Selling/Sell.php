<?php

namespace App\Livewire\Selling;

use App\Models\Driver;
use App\Models\Product;
use App\Models\Type;
use App\Models\Seling_product_info;
use App\Models\Sell_invoice;
use App\Models\Sellinfo;
use App\Models\Customer;
use App\Models\Offer;
use App\Models\SellingProduct;
use App\Models\Offer_sell;
use App\Models\Sub_Buy_Products_invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Session;
use Illuminate\Support\Facades\DB;


class Sell extends Component
{
    use WithPagination;

    public $search_code_name = '';
    #[Session('sellInvoice')]
    public $sellInvoice;
    public $types = '';

    #[Session('selected_driver')]
    public $selected_driver;
    public $drivers = '';
    #[Session('mobile')]
    public $mobile = '';
    #[Session('address')]
    public $address = '';
    public $phoneSuggestions = [];

    public $selected_type = '';
    #[Session('numsellinvoice')]
    public $numsellinvoice = 0;
    #[Session('showNewButton')]
    public $showNewButton = true;

    #[Session('selectedProducts')]
    public $selectedProducts = [];
    #[Session('selectedoffer')]
    public $selectedoffer = [];
    #[Session('pricetaxi')]
    public $pricetaxi = 0;
    #[Session('subtotal')]
    public $subtotal = 0;
    #[Session('discount')]
    public $discount = 0;
    #[Session('generalprice')]
    public $generalprice = 0;
    #[Session('generalpriceoffer')]
    public $generalpriceoffer = 0;
    public $totalProfit = 0;
    public $netProfit = 0;
    #[Session('date_sell')]
    public $date_sell = "";
    #[Session(key: 'note')]
    public $note = "";

    #[Session(key: 'cashornot')]
    public $cashornot = false;

    protected $casts = [
        'cashornot' => 'boolean',
    ];
    public $offers = [];
    public $search_offer = '';
    public function offersshow()
    {
        $this->offers = Offer::all();
    }
    public function updatedSearchOffer()
    {
        if (empty($this->search_offer)) {
            $this->offers = []; // Optional: or Offer::all() if you want default load
            return;
        }

        $this->offers = Offer::where('nameoffer', 'like', '%' . $this->search_offer . '%')
            ->orWhere('code', 'like', '%' . $this->search_offer . '%')
            ->get();
    }


    public function updatedCashornot($value)
    {
        if ($value) {
            // Do something when checked (true)
            $this->cashornot = true;
        } else {
            // Do something when unchecked (false)
            $this->cashornot = false;
        }
    }

    public $showSuggestions = true;
    public function updatedMobile()
    {
        $this->showSuggestions = true;

        if (strlen($this->mobile) >= 1) {
            $this->phoneSuggestions = DB::table('customers as c1')
                ->select('c1.mobile', 'c1.address')
                ->where('c1.mobile', 'like', "%{$this->mobile}%")
                ->whereRaw('c1.id = (SELECT MAX(c2.id) FROM customers c2 WHERE c2.mobile = c1.mobile)')
                ->limit(5)
                ->get();
        } else {
            $this->phoneSuggestions = [];
        }

        $match = Customer::where('mobile', $this->mobile)
            ->orderByDesc('id')
            ->first();

        $this->address = $match ? $match->address : '';
    }


    public function selectPhone($phone)
    {
        $customer = Customer::where('mobile', $phone)->orderByDesc('id')->first();

        if ($customer) {
            $this->mobile = $customer->mobile;
            $this->address = $customer->address;
            $this->phoneSuggestions = [];
            $this->showSuggestions = false;
        }
        if ($customer->is_block) {
            flash()->success('This customer is blocked!');
        }
    }




    public function makesellInvoice()
    {

        $max = sell_invoice::max('num_invoice_sell');
        $this->numsellinvoice = $max ? $max + 1 : 1;

        // Optionally save:
        sell_invoice::create([
            'num_invoice_sell' => $this->numsellinvoice,
            'date_sell' => $this->date_sell,
        ]);
        $this->showNewButton = false;
    }

    public function refresh()
    {
        $this->clearCart();
        $this->clearOffersCart();

        $this->reset(
            'numsellinvoice',
            'selectedProducts',
            'showNewButton',
            'sellInvoice',
            'mobile',
            'address',
            'pricetaxi',
            'selected_driver',
            'search_code_name',
            'discount',
            'generalprice',
            'totalProfit',
            'netProfit',
            'subtotal',
            'note',
            'cashornot',
            'generalpriceoffer',
            'selectedoffer',
        );
        $this->date_sell = now()->format('Y-m-d\TH:i');
    }

    public function ref()
    {


        $this->reset(
            'numsellinvoice',
            'selectedProducts',
            'showNewButton',
            'sellInvoice',
            'mobile',
            'address',
            'pricetaxi',
            'selected_driver',
            'search_code_name',
            'discount',
            'generalprice',
            'totalProfit',
            'netProfit',
            'subtotal',
            'note',
            'cashornot',
            'generalpriceoffer',
            'selectedoffer',
        );
        $this->date_sell = now()->format('Y-m-d\TH:i');
    }

    public $dd;

    public function updateQuantity($productId, $newQty)
    {


        DB::beginTransaction();

        try {
            $product = Product::lockForUpdate()->find($productId);

            if (!$product) {
                DB::rollBack();
                flash()->addError('Product not found.');
                return;
            }

            $index = collect($this->selectedProducts)->search(fn($item) => $item['id'] == $productId);

            if ($index === false) {
                DB::rollBack();
                flash()->addError('Product not found in cart.');
                return;
            }

            $cartItem = $this->selectedProducts[$index];
            $oldQty = $cartItem['quantity'];
            $availableStock =  $product->quantity + $oldQty;

            $this->dd = $availableStock;



            // Validate new quantity
            if ($newQty < 1) {
                $newQty = 1;
                flash()->addError('Quantity cannot be less than 1.');
            } elseif ($newQty > $availableStock) {
                $newQty = $availableStock;

                flash()->addError('Maximum available quantity is ' . $availableStock);
            }

            // Calculate the actual change needed
            $quantityChange = $newQty - $oldQty;

            // Update product stock (only if quantity actually changed)
            if ($quantityChange != 0) {
                $product->decrement('quantity', $quantityChange);
            }

            // Update cart item
            $this->selectedProducts[$index]['quantity'] = $newQty;
            $this->selectedProducts[$index]['total'] = $newQty * $cartItem['price'];

            DB::commit();
            $this->calculateGeneralPrice();
        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('updateQuantity error: ' . $e->getMessage());
            flash()->addError('Error updating quantity.');
        }
    }


    public function addOffer($offerId)
    {
        $offer = Offer::with('subOffers')->findOrFail($offerId);


        $exists = collect($this->selectedoffer)->contains(fn($item) => $item['id'] === $offerId);

        if ($exists) {
            flash()->warning('لا يمكن إضافة العرض، لأنه موجود بالفعل في السلة.');
            return;
        }


        DB::beginTransaction();

        try {
            foreach ($offer->subOffers as $suboffer) {
                $product = Product::lockForUpdate()->find($suboffer->product_id); // lock row

                if (!$product || $product->quantity < $suboffer->quantity) {
                    DB::rollBack();
                    flash()->addError('لا يمكن تنفيذ العرض: بعض المنتجات غير متوفرة بالكمية المطلوبة.');
                    return;
                }


                $product->decrement('quantity', $suboffer->quantity);
            }


            DB::commit();


            $this->selectedoffer[] = [
                'id' => $offer->id,
                'nameoffer' => $offer->nameoffer,
                'quantity' => 1,
                'code' => $offer->code,
                'price' => $offer->price,
            ];

            $this->getTotalPriceProperty();
            $this->calculateGeneralPrice();
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('حدث خطأ أثناء إضافة العرض: ' . $e->getMessage());
        }
    }



    public function removeOffer($offerId)
    {
        // Step 1: Find the offer in the cart
        $index = collect($this->selectedoffer)->search(fn($item) => $item['id'] == $offerId);

        if ($index === false) {
            return;
        }

        $cartItem = $this->selectedoffer[$index];

        // Step 2: Restore product quantities from sub-offers
        DB::beginTransaction();

        try {
            $offer = Offer::with('subOffers')->findOrFail($offerId);

            foreach ($offer->subOffers as $suboffer) {
                $product = Product::lockForUpdate()->find($suboffer->product_id);

                if ($product) {
                    $product->increment('quantity', $suboffer->quantity * $cartItem['quantity']);
                }
            }

            DB::commit();

            // Step 3: Remove offer from cart
            unset($this->selectedoffer[$index]);
            $this->selectedoffer = array_values($this->selectedoffer); // reindex

            $this->calculateGeneralPrice();
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('حدث خطأ أثناء حذف العرض: ' . $e->getMessage());
        }
    }

    public function incrementOffer($offerId)
    {


        $index = collect($this->selectedoffer)->search(fn($item) => $item['id'] === $offerId);

        if ($index === false) return;

        $offer = Offer::with('subOffers')->findOrFail($offerId);


        DB::beginTransaction();

        try {
            foreach ($offer->subOffers as $suboffer) {
                $product = Product::lockForUpdate()->find($suboffer->product_id);

                if (!$product || $product->quantity < $suboffer->quantity) {
                    DB::rollBack();
                    flash()->addError('لا يمكن زيادة الكمية: المنتج غير متوفر بالكمية المطلوبة.');
                    return;
                }

                $product->decrement('quantity', $suboffer->quantity);
            }

            $this->selectedoffer[$index]['quantity'] += 1;

            DB::commit();
            $this->calculateGeneralPrice();
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }

    public function decrementOffer($offerId)
    {
        $index = collect($this->selectedoffer)->search(fn($item) => $item['id'] === $offerId);

        if ($index === false) return;

        // Prevent going below 1
        if ($this->selectedoffer[$index]['quantity'] <= 1) {
            flash()->warning('لا يمكن تقليل الكمية لأقل من 1.');
            return;
        }

        $offer = Offer::with('subOffers')->findOrFail($offerId);

        DB::beginTransaction();

        try {
            foreach ($offer->subOffers as $suboffer) {
                $product = Product::lockForUpdate()->find($suboffer->product_id);

                if ($product) {
                    $product->increment('quantity', $suboffer->quantity);
                }
            }

            $this->selectedoffer[$index]['quantity'] -= 1;

            DB::commit();
            $this->calculateGeneralPrice();
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }
    public function addProduct($productId)
    {
        // Get product with definition
        $product = Product::with('definition')->lockForUpdate()->find($productId);
        if (!$product) return;

        DB::beginTransaction();

        try {
            // Re-check live stock
            $availableStock = $product->quantity;

            // Already in cart?
            $index = collect($this->selectedProducts)->search(fn($item) => $item['id'] == $productId);
            if ($index !== false) {
                flash()->warning('المنتج مضاف مسبقًا.');
                DB::rollBack();
                return;
            }

            if ($availableStock < 1) {
                flash()->error('الكمية غير متوفرة.');
                DB::rollBack();
                return;
            }

            // Decrease stock in database
            $product->quantity -= 1;
            $product->save();

            DB::commit();

            // Add to cart
            $this->selectedProducts[] = [
                'id' => $product->id,
                'name' => $product->definition->name ?? '',
                'code' => $product->definition->code ?? '',
                'barcode' => $product->definition->barcode ?? '',
                'type_id' => $product->definition->type_id ?? '',
                'quantity' => 1,
                'stock' => $availableStock - 1, // live updated stock
                'price' => $product->price_sell,
                'total' => $product->price_sell,
            ];
            $this->calculateGeneralPrice();
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('حدث خطأ أثناء إضافة المنتج.');
        }
    }


    public $test = true;
    public function errorMsg()
    {
        if ($this->numsellinvoice === 0) {
            flash()->error('يجب عليك أولاً إنشاء فاتورة بيع');
            return false;
        }

        if (empty($this->date_sell)) {
            flash()->error('إنشاء تاريخ البيع');
            return false;
        }

        if (empty($this->mobile) || empty($this->address)) {
            flash()->error('يجب إنشاء معلومات العميل');
            return false;
        }

        if (empty($this->selected_driver)) {
            flash()->error('الرجاء تحديد اسم السائق');
            return false;
        }
        if (empty($this->pricetaxi) || $this->pricetaxi === 0) {
            flash()->error('الرجاء تحديد اسم السائق');
            return false;
        }

        if (empty($this->selectedProducts) && empty($this->selectedoffer)) {
            flash()->error('لم يتم إضافة أي منتج إلى السلة');
            return false;
        }

        return true;
    }

    public function calculateOfferProfit()
    {
        $totalProfit = 0;

        foreach ($this->selectedoffer as $offerItem) {
            $offer = Offer::with('subOffers')->find($offerItem['id']);
            if (!$offer) continue;

            $offerQty = $offerItem['quantity'];
            $offerSellPrice = $offerItem['price'] * $offerQty;
            $totalBuyCost = 0;

            foreach ($offer->subOffers as $subOffer) {
                $productId = $subOffer->product_id;
                $neededQty = $subOffer->quantity * $offerQty;

                $batches = sub_Buy_Products_invoice::where('product_id', $productId)
                    ->whereRaw('quantity - q_sold > 0')
                    ->orderBy('created_at', 'asc')
                    ->get(['id', 'buy_price', 'quantity', 'q_sold']);

                $remainingQty = $neededQty;

                foreach ($batches as $batch) {
                    $availableQty = $batch->quantity - $batch->q_sold;
                    if ($availableQty <= 0) continue;

                    $takeQty = min($availableQty, $remainingQty);

                    // تحديث الكمية المباعة
                    sub_Buy_Products_invoice::where('id', $batch->id)
                        ->increment('q_sold', $takeQty);

                    $cost = $takeQty * $batch->buy_price;
                    $totalBuyCost += $cost;

                    $remainingQty -= $takeQty;


                    seling_product_info::create([
                        'product_id' => $productId,
                        'quantity_sold' => $takeQty,
                        'buy_price' => $batch->buy_price,
                        'total_sell' => 0, // أو يمكنك إسناد السعر الإجمالي للعروض هنا
                        'profit' => 0,     // سنحسب الربح بعد قليل
                        'sub_id' => $batch->id,
                        'sell_invoice_id' => Sell_invoice::where('num_invoice_sell', $this->numsellinvoice)->first()->id,
                    ]);

                    if ($remainingQty <= 0) break;
                }
            }

            $offerProfit = $offerSellPrice - $totalBuyCost;
            $totalProfit += $offerProfit;
        }

        return $totalProfit;
    }

    public function sell_offers($idInvoice)
    {
        $sellInvoice = Sell_invoice::find($idInvoice);


        foreach ($this->selectedoffer as $cartItem) {
            $neededQty = $cartItem['quantity'];
            $offerPrice = $cartItem['price'];


            offer_sell::create([
                'nameoffer' => $cartItem['nameoffer'],
                'code' => $cartItem['code'],
                'quantity' => $neededQty,
                'price' => $offerPrice,
                'sell_invoice_id' => $sellInvoice->id,
            ]);
        }
    }



    public function gitprofit()
    {
        if (!$this->errorMsg()) {
            return;
        }
        $sellInvoice = Sell_invoice::where('num_invoice_sell', $this->numsellinvoice)->first();

        $this->totalProfit = 0;
        $this->netProfit = 0;

        foreach ($this->selectedProducts as $cartItem) {
            $productId = $cartItem['id'];
            $neededQty = $cartItem['quantity'];
            $priceSell = $cartItem['price'];

            $batches = sub_Buy_Products_invoice::where('product_id', $productId)
                ->whereRaw('quantity - q_sold > 0')
                ->orderBy('created_at', 'asc')
                ->get(['id', 'buy_price', 'quantity', 'q_sold']);

            $remainingQty = $neededQty;
            $productProfit = 0;

            foreach ($batches as $batch) {
                $availableQty = $batch->quantity - $batch->q_sold;

                if ($availableQty <= 0) continue;

                $takeQty = min($availableQty, $remainingQty);

                sub_Buy_Products_invoice::where('id', $batch->id)
                    ->increment('q_sold', $takeQty);

                $cost = $takeQty * $batch->buy_price;
                $sell = $takeQty * $priceSell;
                $profit = $sell - $cost;

                $productProfit += $profit;
                $remainingQty -= $takeQty;


                seling_product_info::create([
                    'product_id' => $productId,
                    'quantity_sold' => $takeQty,
                    'buy_price' => $batch->buy_price,
                    'total_sell' => $sell,
                    'profit' => $profit,
                    'sub_id' => $batch->id,
                    'sell_invoice_id' => $sellInvoice->id,
                ]);

                if ($remainingQty <= 0) break;
            }


            $this->totalProfit += $productProfit;
        }
        $offerProfit = $this->calculateOfferProfit();
        $this->totalProfit += $offerProfit;
        $this->netProfit = $this->totalProfit - (float)($this->discount ?? 0);

        $this->storecustomerinfo($sellInvoice);
    }



    public function storecustomerinfo($sellInvoice)
    {
        Customer::create([
            'mobile' => $this->mobile,
            'address' => $this->address,
            'date_sell' => $this->date_sell,
            'driver_id' => $this->selected_driver,
            'profit_invoice' => $this->totalProfit,
            'profit_invoice_after_discount' => $this->netProfit,
            'sell_invoice_id' => $sellInvoice->id,
            'note' => $this->note,
            'is_block' => false,
        ]);


        // Update invoice fields
        $sellInvoice->total_price = $this->generalprice;
        $sellInvoice->selling = true;
        $sellInvoice->save();


        $this->sell($sellInvoice->id);
        $this->sellingproduct($sellInvoice->id);
    }

    public function sell($idInvoice)
    {
        // $totalprice = collect($this->selectedProducts)->sum('total');
        sellinfo::create([
            'taxi_price' => $this->pricetaxi,
            'total_Price_invoice' => $this->generalprice + (float)($this->discount ?? 0),
            'discount' => (float)($this->discount ?? 0),
            'total_price_afterDiscount_invoice' => $this->generalprice,
            'cash' => $this->cashornot,
            'user' => "developer",
            'sell_invoice_id' => $idInvoice,
        ]);
    }


    public function sellingproduct($idInvoice)
    {
        $productsData = [];

        foreach ($this->selectedProducts as $product) {
            sellingProduct::create([
                'name' => $product['name'],
                'code' => $product['code'],
                'barcode' => $product['barcode'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total_price' => $product['total'],
                'type_id' => $product['type_id'],
                'product_id' => $product['id'],
                'sell_invoice_id' => $idInvoice,

            ]);
            $productsData[] = [
                'name' => $product['name'],
                'code' => $product['code'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total_price' => $product['total'],
            ];
        }

        $this->sell_offers($idInvoice);
        $invoiceData = [
            'invoice_id' => $idInvoice,
            'products' => $productsData,
            'total' => array_sum(array_column($productsData, 'total_price')),
            'date' => now()->format('Y-m-d'),
            // add any other info like customer name if you want
        ];



        flash()->success('تمت عملية البيع بنجاح');

        $this->ref();
    }




    public function removeProduct($productId)
    {
        // Step 1: Find the product in the cart
        $index = collect($this->selectedProducts)->search(fn($item) => $item['id'] == $productId);

        if ($index !== false) {
            $cartItem = $this->selectedProducts[$index];

            // Step 2: Restore quantity to DB
            $product = Product::lockForUpdate()->find($productId);
            if ($product) {
                $product->quantity += $cartItem['quantity']; // restore full cart quantity
                $product->save();
            }

            // Step 3: Remove product from cart
            unset($this->selectedProducts[$index]);
            $this->selectedProducts = array_values($this->selectedProducts); // reindex

            $this->calculateGeneralPrice();
        }
    }
    public function removeProductmulti()
    {

        foreach ($this->selectedProducts as $product) {
            // dd($product['quantity']);
            $product = Product::lockForUpdate()->find($product['id']);
            if ($product) {
                $product->quantity += $product['quantity']; // restore full cart quantity
                $product->save();
            }
        }

        //  $this->calculateGeneralPrice();



        // Step 1: Find the product in the cart
        // $index = collect($this->selectedProducts)->search(fn($item) => $item['id'] == $productId);

        // if ($index !== false) {
        //     $cartItem = $this->selectedProducts[$index];

        //     // Step 2: Restore quantity to DB
        //     $product = Product::lockForUpdate()->find($productId);
        //     if ($product) {
        //         $product->quantity += $cartItem['quantity']; // restore full cart quantity
        //         $product->save();
        //     }

        //     // Step 3: Remove product from cart
        //     unset($this->selectedProducts[$index]);
        //     $this->selectedProducts = array_values($this->selectedProducts); // reindex

        //     $this->calculateGeneralPrice();
        // }
    }

    public function clearCart()
    {
        foreach ($this->selectedProducts as $cartItem) {
            $product = Product::lockForUpdate()->find($cartItem['id']);
            if ($product) {
                $product->quantity += $cartItem['quantity']; // Restore quantity
                $product->save();
            }
        }

        // Clear the cart
        $this->selectedProducts = [];

        // Recalculate totals
        $this->calculateGeneralPrice();
    }
    public function clearOffersCart()
    {

        DB::beginTransaction();

        try {
            foreach ($this->selectedoffer as $cartItem) {
                $offerId = $cartItem['id'];
                $offer = Offer::with('subOffers')->findOrFail($offerId);

                foreach ($offer->subOffers as $suboffer) {
                    $product = Product::lockForUpdate()->find($suboffer->product_id);
                    if ($product) {
                        $product->increment('quantity', $suboffer->quantity * $cartItem['quantity']);
                    }
                }
            }

            // Clear the selected offers cart
            $this->selectedoffer = [];

            DB::commit();

            // Recalculate totals
            $this->calculateGeneralPrice();
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('حدث خطأ أثناء إفراغ العروض: ' . $e->getMessage());
        }
    }




    public function mount()
    {
        $this->types = Type::all();
        $this->drivers = driver::all();
        $this->date_sell = now()->format('Y-m-d\TH:i');
    }

    public function updatedDiscount()
    {
        $this->calculateGeneralPrice();
    }

    public function calculateGeneralPrice()
    {
        $subtotal = collect($this->selectedProducts)->sum('total');

        $priceoffer = collect($this->selectedoffer)->sum(function ($offer) {
            return $offer['quantity'] * $offer['price'];
        });

        $this->generalprice = $subtotal + $priceoffer - (float)($this->discount ?? 0);
    }

    public function getTotalPriceProperty()
    {
        $productsTotal = collect($this->selectedProducts)->sum(function ($product) {
            return $product['quantity'] * $product['price'];
        });

        $offersTotal = collect($this->selectedoffer)->sum(function ($offer) {
            return $offer['quantity'] * $offer['price'];
        });

        return $productsTotal + $offersTotal;
    }






    public function updatingSearchCodeName()
    {
        $this->resetPage();
    }




    public function updatedSelectedDriver($driverId)
    {
        if (empty($driverId)) {
            $this->pricetaxi = 0;
            return;
        }

        $driver = Driver::find($driverId);
        if (!$driver) {
            $this->pricetaxi = 0;
            return;
        }

        $this->pricetaxi = $driver->taxiprice ?? 0;
        $this->calculateGeneralPrice();
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


        return view('livewire.selling.sell', [
            'products' => $products,
            'totalPrice' => $this->totalPrice,
            'generalpriceoffer' => $this->generalpriceoffer,
            'pricetaxi' => $this->pricetaxi,
        ]);
    }
}
