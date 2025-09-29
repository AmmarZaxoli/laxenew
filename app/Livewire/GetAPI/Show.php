<?php

namespace App\Livewire\GetAPI;

use App\Models\Customer;
use App\Models\Definition;
use App\Models\Offer_sell;
use App\Models\Seling_product_info;
use App\Models\Sell_invoice;
use App\Models\Sellinfo;
use App\Models\SellingProduct;
use App\Models\Sub_Offer;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use App\Models\Driver;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Sub_Buy_Products_invoice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Show extends Component
{
    use WithPagination;

    public $email = 'ammarzaxoli95@gmail.com';
    public $password = '12345678';
    public $responseMessage = '';
    public $numsellinvoice;
    public $orders = [];
    public $loading = false;
    public $totalOrders = 0;
    public $perPage = 100;
    public $currentPage = 1;
    public $token;
    public $drivers;
    public $note = null;
    public $waypayment = null;

    public $showModal = false;
    public $modalProducts = [];
    public $selected_driver;
    public $driver_id;
    public $date_sell;
    public $pricetaxi = 0;
    public $discount = 0;
    public $selectedProducts = [];


    public function updatedSelectedDriver($driverId)
    {
        if (empty($driverId)) {
            $this->pricetaxi = 0;
            return;
        }

        $driver = Driver::find($driverId);
        $this->pricetaxi = $driver?->taxiprice ?? 0;
        $this->driver_id = $driverId;
    }


    public function mount()
    {
        $this->authenticateAndFetch();
        $this->drivers = Driver::all();
        $this->date_sell = date('Y-m-d');
    }

    public function authenticateAndFetch()
    {
        $this->loading = true;

        $response = Http::post('https://laxe-backend-production.up.railway.app/api/v1/auth/signin', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            $this->token = $response->json('token');
            $this->responseMessage = 'Successfully authenticated. Loading orders...';
            $this->fetchOrders($this->currentPage);
        } else {
            $this->responseMessage = 'Authentication failed! Please check your credentials.';
            $this->orders = [];
            $this->totalOrders = 0;
        }

        $this->loading = false;
    }

    public function fetchOrders($page = 1)
    {
        if (!$this->token) {
            $this->responseMessage = 'No token available. Please try reloading the page.';
            return;
        }

        $this->loading = true;

        $response = Http::withToken($this->token)
            ->get('https://laxe-backend-production.up.railway.app/api/v1/orders/all', [
                'page' => $page,
                'limit' => $this->perPage,
                'status' => 'PENDING',
            ]);

        if ($response->successful()) {
            $this->orders = $response->json('allOrders') ?? [];
            $this->totalOrders = $response->json('totalOrders') ?? count($this->orders);
            $this->responseMessage = count($this->orders) . ' pending orders found.';
        } else {
            $this->responseMessage = 'Failed to fetch orders!';
            $this->orders = [];
            $this->totalOrders = 0;
        }

        $this->loading = false;
    }

    public function cancel($orderId)
    {
        if (!$this->token) {
            $this->responseMessage = 'No token available. Please try reloading the page.';
            return;
        }

        $cancelationReason = "Cancelled";

        $response = Http::withToken($this->token)
            ->acceptJson()
            ->withHeaders(['Content-Type' => 'application/json'])
            ->patch('https://laxe-backend-production.up.railway.app/api/v1/orders/admin/cancel', [
                'orderId' => (int) $orderId,
                'cancelationReason' => $cancelationReason,
            ]);

        if ($response->successful()) {
            $this->orders = collect($this->orders)
                ->reject(fn($order) => $order['id'] == $orderId)
                ->values()
                ->toArray();

            flash()->success("Order #{$orderId} has been cancelled.");
        } else {
            $status = $response->status();
            $message = $response->json('error') ?? $response->json('message') ?? $response->body();
            flash()->error("Cancel failed ({$status}): {$message}");
        }
    }



    public function confirmAccept($orderId)
    {
        if (!$this->token) {
            flash()->error('No token available. Please reload the page.');
            return;
        }

        $response = Http::withToken($this->token)
            ->acceptJson()
            ->withHeaders(['Content-Type' => 'application/json'])
            ->patch('https://laxe-backend-production.up.railway.app/api/v1/orders/approved', [
                'orderId' => (int) $orderId,
            ]);

        if ($response->successful()) {
            // Remove order from local list
            $this->orders = collect($this->orders)
                ->reject(fn($order) => $order['id'] == $orderId)
                ->values()
                ->toArray();

            flash()->success("Order #{$orderId} has been approved.");
        } else {
            $status = $response->status();
            $message = $response->json('error') ?? $response->json('message') ?? $response->body();
            flash()->error("Approval failed ({$status}): {$message}");
        }
    }


    public function gotoPage($page)
    {
        $this->currentPage = $page;
        $this->fetchOrders($page);
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->fetchOrders($this->currentPage);
        }
    }

    public function nextPage()
    {
        if ($this->currentPage < $this->totalPages()) {
            $this->currentPage++;
            $this->fetchOrders($this->currentPage);
        }
    }

    public function totalPages()
    {
        return $this->totalOrders > 0 ? ceil($this->totalOrders / $this->perPage) : 1;
    }


    public $modalPackages = [];

    public function view($id)
    {
        $order = collect($this->orders)->firstWhere('id', $id);

        if ($order) {
            $products = [];
            $packages = [];
dd($order['items']);
            foreach ($order['items'] as $item) {

                // Normal product (no package)
                if (empty($item['productPackage'])) {
                    $products[] = [
                        'productCode' => $item['product']['productCode'] ?? 'null',
                        'quantity'    => $item['quantity'],
                        'price'       => $item['price'],
                        'total_price' => $item['quantity'] * $item['price'],
                    ];
                }

                // Product package
                if (!empty($item['productPackage'])) {
                    $packages[] = [
                        'packageCode' => $item['productPackage']['packageCode'] ?? 'null',
                        'quantity'    => $item['quantity'],
                        'price'       => $item['price'],
                        'total_price' => $item['quantity'] * $item['price'],
                    ];
                }
            }

            $this->modalProducts = $products;
            $this->modalPackages = $packages;

            // Dispatch browser event to open modal
            $this->dispatch('openOrderModal');
        } else {
            $this->modalProducts = [];
            $this->modalPackages = [];
            session()->flash('error', "Order not found!");
        }
    }

    public function check($id)
    {
        //  Find the order
        $order = collect($this->orders)->firstWhere('id', $id);

        if (!$order) {
            flash()->error("الطلب بالمعرف {$id} غير موجود!");
            return false;
        }

        $missingOffers = [];
        $priceMismatchOffers = [];
        $insufficientQtyOffers = [];

        // Arrays for modal display
        $modalProducts = [];
        $modalPackages = [];

        // 2️⃣ Loop through items in the order
        foreach ($order['items'] as $item) {
            $orderQty   = $item['quantity'] ?? 0;
            $orderPrice = $item['price'] ?? 0;

            // ----- NORMAL PRODUCTS -----
            if (empty($item['productPackage'])) {
                $productCode = $item['product']['productCode'] ?? null;

                $modalProducts[] = [
                    'productCode' => $productCode ?? 'null',
                    'quantity'    => $orderQty,
                    'price'       => $orderPrice,
                    'total_price' => $orderQty * $orderPrice,
                ];

                if (!empty($item['product'])) {
                    $definition = Definition::where('code', $productCode)->first();
                    if (!$definition) {
                        $missingOffers[] = $productCode;
                        continue;
                    }

                    $product = Product::where('definition_id', $definition->id)->first();
                    if (!$product) {
                        $missingOffers[] = $productCode . ' (لا يوجد سجل منتج)';
                        continue;
                    }

                    if ($product->price_sell != $orderPrice) {
                        $priceMismatchOffers[] = $productCode;
                    }

                    if ($product->quantity < $orderQty) {
                        $insufficientQtyOffers[] = "{$productCode} (المتوفر {$product->quantity}، المطلوب {$orderQty})";
                    }
                }
            }
            // ----- PACKAGE / OFFER PRODUCTS -----
            else {
                $packageCode = $item['productPackage']['packageCode'] ?? null;
                $packageName = $item['productPackage']['arName'] ?? $item['productPackage']['enName'] ?? 'null';

                $modalPackages[] = [
                    'packageCode' => $packageCode,
                    'packageName' => $packageName,
                    'quantity'    => $orderQty,
                    'price'       => $orderPrice,
                    'total_price' => $orderQty * $orderPrice,
                ];

                $offer = Offer::with('subOffers')->where('code', $packageCode)->first();
                if (!$offer) {
                    $missingOffers[] = "{$packageCode} ({$packageName})";
                    continue;
                }

                //  Check package price
                if ($offer->price != $orderPrice) {
                    $priceMismatchOffers[] = "{$packageCode} ({$packageName})";
                }

                //  Check stock for each product in the offer
                foreach ($offer->subOffers as $sub) {
                    $neededQty = $sub->quantity * $orderQty;

                    $product = Product::where('definition_id', $sub->product_id)->first();
                    if (!$product) {
                        $missingOffers[] = "{$packageCode} → المنتج {$sub->product_id} غير موجود";
                        continue;
                    }

                    if ($product->quantity < $neededQty) {
                        $insufficientQtyOffers[] =
                            "{$packageCode} يحتوي على {$product->definition->code} (المتوفر {$product->quantity}، المطلوب {$neededQty})";
                    }
                }
            }
        }

        // Set for modal display
        $this->modalProducts = $modalProducts;
        $this->modalPackages = $modalPackages;

        // Show warnings
        if (!empty($missingOffers)) {
            flash()->warning("العناصر التالية غير موجودة: " . implode(', ', $missingOffers));
        }

        if (!empty($priceMismatchOffers)) {
            flash()->warning("العناصر التالية سعر البيع غير مطابق: " . implode(', ', $priceMismatchOffers));
        }

        if (!empty($insufficientQtyOffers)) {
            flash()->warning("العناصر التالية الكمية غير كافية: " . implode(', ', $insufficientQtyOffers));
        }

        // If there are problems, remove from selection
        if (!empty($missingOffers) || !empty($priceMismatchOffers) || !empty($insufficientQtyOffers)) {
            if (($key = array_search($id, $this->selectedOrders)) !== false) {
                unset($this->selectedOrders[$key]);
                $this->selectedOrders = array_values($this->selectedOrders);
            }
            return false;
        }

        return true;
    }



    public $selectedOrders = [];

    public function makesellInvoice()
    {

        $max = Sell_invoice::max('num_invoice_sell');
        $this->numsellinvoice = $max ? $max + 1 : 1;


        sell_invoice::create([
            'num_invoice_sell' => $this->numsellinvoice,
            'date_sell' => $this->date_sell,
        ]);
    }

    public function updatedPricetaxi($value)
    {
        $this->pricetaxi = $value === null || $value === '' ? 0 : $value;
    }

    public function acceptSelected()
    {
        if (empty($this->driver_id)) {
            flash()->error("يرجى اختيار السائق قبل قبول الطلبات.");
            return;
        }

        if (empty($this->selectedOrders)) {
            flash()->warning("لم يتم اختيار أي طلبات.");
            return;
        }

        if ($this->pricetaxi == 0 && empty($this->pricetaxi)) {
            flash()->warning('التحقق من سعر التاكسي لا يكون صفرًا أو فارغًا');
            return;
        }

        $acceptedOrders = [];
        $failedProducts = [];
        $globalProfit = 0;

        foreach ($this->selectedOrders as $orderId) {
            $order = collect($this->orders)->firstWhere('id', $orderId);
            if (!$order) continue;

            [$allAvailable, $productsToUpdate, $itemsData, $errors] = $this->validateOrderItems($order['items']);
            $failedProducts = array_merge($failedProducts, $errors);

            if ($allAvailable) {
                $this->makesellInvoice();
                $sellInvoice = Sell_invoice::where('num_invoice_sell', $this->numsellinvoice)->first();

                // ----- تحقق من التوصيل المجاني لكل عناصر الطلب -----
                $freeDelivery = false;
                foreach ($order['items'] as $item) {
                    // منتجات فردية
                    if (!empty($item['product']) && !empty($item['product']['freeDelivery']) && $item['product']['freeDelivery']) {
                        $freeDelivery = true;
                        break;
                    }

                    // باكيجات / عروض
                    if (!empty($item['productPackage']) && !empty($item['productPackage']['freeDelivery']) && $item['productPackage']['freeDelivery']) {
                        $freeDelivery = true;
                        break;
                    }

                    // جدول Definition
                    if (!empty($item['productId'])) {
                        $definition = Definition::find($item['productId']);
                        if ($definition && $definition->delivery_type === 1) {
                            $freeDelivery = true;
                            break;
                        }
                    }

                    // جدول Offer
                    if (!empty($item['productPackageId'])) {
                        $offer = Offer::find($item['productPackageId']);
                        if ($offer && $offer->delivery === 1) {
                            $freeDelivery = true;
                            break;
                        }
                    }
                }


                if ($freeDelivery) {
                    $this->discount = $this->pricetaxi;
                }

                // ----- Standard products -----
                foreach ($productsToUpdate as $index => $p) {
                    $productModel = $p['model'];
                    $orderQty     = $p['qty'];
                    $sellPrice    = $p['price'];

                    $totalCost = $this->deductProductAndBatches($productModel, $orderQty);
                    $totalSell = $orderQty * $sellPrice;
                    $profit    = $totalSell - $totalCost;

                    $itemsData[$index]['profit'] = $profit;

                    $remainingQty = $orderQty;
                    $batches = Sub_Buy_Products_invoice::where('product_id', $productModel->id)
                        ->whereRaw('quantity - q_sold > 0')
                        ->orderBy('created_at', 'asc')
                        ->get();

                    foreach ($batches as $batch) {
                        $available = $batch->quantity - $batch->q_sold;
                        if ($available <= 0) continue;

                        $takeQty = min($remainingQty, $available);
                        $sell = $takeQty * $sellPrice;

                        Seling_product_info::create([
                            'product_id' => $productModel->id,
                            'quantity_sold' => $takeQty,
                            'buy_price' => $batch->buy_price,
                            'total_sell' => $sell,
                            'profit' => $sell - ($takeQty * $batch->buy_price),
                            'sub_id' => $batch->id,
                            'sell_invoice_id' => $sellInvoice->id,
                        ]);

                        $remainingQty -= $takeQty;
                        if ($remainingQty <= 0) break;
                    }
                }

                // ----- Offers / Packages -----
                $offerProfitTotal = 0;
                foreach ($this->selectedoffer as $offerItem) {
                    $offer = Offer::with('subOffers')->where('code', $offerItem['code'])->first();
                    if (!$offer) continue;

                    $offerQty       = $offerItem['quantity'];
                    $offerTotalSell = $offerItem['price'] * $offerQty;
                    $totalBuyCost   = 0;

                    foreach ($offer->subOffers as $subOffer) {
                        $productId  = $subOffer->product_id;
                        $neededQty  = $subOffer->quantity * $offerQty;
                        $remaining  = $neededQty;


                        $product = Product::find($productId);
                        if ($product) {
                            $product->decrement('quantity', $neededQty);
                        }

                        $batches = Sub_Buy_Products_invoice::where('product_id', $productId)
                            ->whereRaw('quantity - q_sold > 0')
                            ->orderBy('created_at', 'asc')
                            ->get(['id', 'buy_price', 'quantity', 'q_sold']);

                        foreach ($batches as $batch) {
                            $available = $batch->quantity - $batch->q_sold;
                            if ($available <= 0) continue;

                            $takeQty = min($available, $remaining);
                            $batch->increment('q_sold', $takeQty);

                            $totalBuyCost += $takeQty * $batch->buy_price;

                            Seling_product_info::create([
                                'product_id' => $productId,
                                'quantity_sold' => $takeQty,
                                'buy_price' => $batch->buy_price,
                                'total_sell' => 0,
                                'profit' => 0,
                                'sub_id' => $batch->id,
                                'sell_invoice_id' => $sellInvoice->id,
                            ]);

                            $remaining -= $takeQty;
                            if ($remaining <= 0) break;
                        }

                        if ($remaining > 0) {
                            Log::warning("⚠️ لم يتم خصم كل الكمية من المنتج {$productId} في العرض {$offer->code}. المتبقي: {$remaining}");
                        }
                    }

                    $offerProfit = $offerTotalSell - $totalBuyCost;
                    Offer_sell::create([
                        'nameoffer' => $offerItem['name'],
                        'code' => $offerItem['code'],
                        'quantity' => $offerQty,
                        'price' => $offerItem['price'],
                        'profit' => $offerProfit,
                        'sell_invoice_id' => $sellInvoice->id,
                    ]);

                    $offerProfitTotal += $offerProfit;
                }

                $orderProfit = array_sum(array_column($itemsData, 'profit')) + $offerProfitTotal;
                $globalProfit += $orderProfit;

                $acceptedOrders[] = $this->prepareAcceptedOrder($sellInvoice->id, $order, $itemsData, $orderProfit);
            }
        }

        if (empty($acceptedOrders)) {
            $failedList = implode(', ', $failedProducts);
            flash()->error("لم يتم قبول أي طلب، تحقق من الكميات. المنتجات: {$failedList}");
            return;
        }

        flash()->success(
            "تم قبول " . count($acceptedOrders) . " طلب/طلبات بنجاح ✅<br> 
        إجمالي الربح: {$globalProfit}"
        );

        $this->discount = 0;
    }

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



            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('updateQuantity error: ' . $e->getMessage());
            flash()->addError('Error updating quantity.');
        }
    }

    private function validateOrderItems($items)
    {
        $allAvailable = true;
        $productsToUpdate = [];
        $itemsData = [];
        $offersData = [];
        $errors = [];

        foreach ($items as $item) {
            // Check if it's an offer/package
            if (isset($item['productPackage'])) {
                $offer = $item['productPackage'];
                $itemsData[] = [
                    'name'       => $offer['arName'] ?? $offer['enName'] ?? 'غير معروف',
                    'code'       => $offer['packageCode'],
                    'quantity'   => $item['quantity'],
                    'price'      => $offer['packagePrice'],
                    'total'      => $item['quantity'] * $offer['packagePrice'],
                    'is_offer'   => true,
                ];
                $offersData[] = end($itemsData);
                continue;
            }

            // Standard product flow
            $productCode = $item['product']['productCode'] ?? null;
            $orderQty   = $item['quantity'];
            $sellPrice  = $item['price'];

            $definition = Definition::where('code', $productCode)->first();

            if (!$definition) {
                $errors[] = "{$productCode} (غير موجود)";
                $allAvailable = false;
                continue;
            }

            if (!$definition->is_active) {
                $errors[] = "{$productCode} (غير مفعل)";
                $allAvailable = false;
                continue;
            }

            $product = Product::where('definition_id', $definition->id)->first();
            if (!$product) {
                $errors[] = "{$productCode} (لا يوجد سجل منتج)";
                $allAvailable = false;
                continue;
            }

            if ($product->quantity < $orderQty) {
                $errors[] = "{$productCode} (المتوفر {$product->quantity}، المطلوب {$orderQty})";
                $allAvailable = false;
                continue;
            }

            $productsToUpdate[] = [
                'model' => $product,
                'qty'   => $orderQty,
                'price' => $sellPrice,
            ];

            $itemsData[] = [
                'id'       => $definition->id,
                'name'     => $definition->name,
                'code'     => $definition->code,
                'barcode'  => $definition->barcode,
                'type_id'  => $definition->type_id,
                'quantity' => $orderQty,
                'price'    => $sellPrice,
                'total'    => $orderQty * $sellPrice,
                'profit'   => 0,
                'is_offer' => false,
            ];
        }

        $this->selectedoffer = $offersData; // Save offers for later processing
        return [$allAvailable, $productsToUpdate, $itemsData, $errors];
    }


    private function deductProductAndBatches($productModel, $orderQty)
    {
        $productId = $productModel->id;


        $productModel->decrement('quantity', $orderQty);

        $remainingQty = $orderQty;
        $totalCost = 0;

        $batches = Sub_Buy_Products_invoice::where('product_id', $productId)
            ->whereRaw('quantity - q_sold > 0')
            ->orderBy('created_at', 'asc')
            ->get(['id', 'buy_price', 'quantity', 'q_sold']);

        foreach ($batches as $batch) {
            $available = $batch->quantity - $batch->q_sold;

            if ($available <= 0) continue;

            if ($remainingQty <= $available) {
                $batch->increment('q_sold', $remainingQty);
                $totalCost += $remainingQty * $batch->buy_price;
                $remainingQty = 0;
                break;
            } else {
                $batch->increment('q_sold', $available);
                $totalCost += $available * $batch->buy_price;
                $remainingQty -= $available;
            }
        }

        if ($remainingQty > 0) {
            Log::warning("لم يتم خصم كل الكمية من batches للمنتج ID {$productId}. المتبقي: {$remainingQty}");
        }

        return $totalCost;
    }


    private function prepareAcceptedOrder($idinvoice, $order, $itemsData, $orderProfit)
    {

        $this->selectedProducts = array_filter($itemsData, fn($p) => !$p['is_offer']);
        $this->selectedoffer = array_filter($itemsData, fn($p) => $p['is_offer']);


        if ($order['paymentMethod'] !== 'BY_CASH') {
            $this->waypayment = $order['paymentMethod'];
        } else {
            $this->waypayment = null;
        }

        $Application = 'application';
        $customer = Customer::create([
            'mobile' => $order['phoneNumber'],
            'address' => $order['address']['location'],
            'date_sell' => $this->date_sell,
            'driver_id' => $this->driver_id,
            'profit_invoice' => $orderProfit,
            'profit_invoice_after_discount' => $orderProfit - $this->discount,
            'sell_invoice_id' => $idinvoice,
            'waypayment' => $this->waypayment,
            'buywith' => $order['id'],
            'is_block' => false,
        ]);

        $this->confirmAccept($order['id']); 

        $this->sell($idinvoice, $order);
        $this->sellingproduct($idinvoice);

        // Return array with invoice info and order details

        return [
            'invoice_id' => $idinvoice,
            'order' => $order,
            'items' => $itemsData,
            'profit' => $orderProfit,
            'customer_id' => $customer->id,
        ];
    }


    public function sell($idInvoice, $order)
    {

        Sellinfo::create([
            'taxi_price' => $this->pricetaxi,
            'total_Price_invoice' => $order['total'],
            'discount' => $this->discount,
            'total_price_afterDiscount_invoice' => $order['total'] - $this->discount,
            'cash' => 0,
            'user' => auth('account')->user()->name,
            'sell_invoice_id' => $idInvoice,
        ]);
    }
    public function sellingproduct($idInvoice)
    {
        $productsData = [];

        // Standard products
        foreach ($this->selectedProducts as $product) {
            SellingProduct::create([
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

        // Offers
        // $this->sell_offers($idInvoice);

        $this->redirectRoute('getAPI.create');
    }

    public $selectedoffer;
    // public function sell_offers($idInvoice)
    // {
    //     $sellInvoice = Sell_invoice::find($idInvoice);

    //     foreach ($this->selectedoffer as $cartItem) {
    //         $neededQty  = $cartItem['quantity'];
    //         $offerPrice = $cartItem['price'];

    //         Offer_sell::create([
    //             'nameoffer' => $cartItem['name'],
    //             'code'      => $cartItem['code'],
    //             'quantity'  => $neededQty,
    //             'price'     => $offerPrice,
    //             'sell_invoice_id' => $sellInvoice->id,
    //         ]);
    //     }
    // }

    public function render()
    {
        return view('livewire.getAPI.show', [
            'totalPages' => $this->totalPages(),
        ]);
    }
}
