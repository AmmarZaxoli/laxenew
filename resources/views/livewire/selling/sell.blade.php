<div>

    <div class="row mb-3">
        <div class="col-lg-12 mb-3">
            <div class="card h-100">

                <div class="card-body">


                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="Invoice">فاتورة</label>
                            <input type="text" name="numList" id="nextInvoice" class="form-control"
                                value="{{ $numsellinvoice }}" readonly required>
                        </div>

                        <div class="col-md-3 mb-3">
                            @if ($showNewButton)
                                <button id="getNextInvoiceBtn" class="btn btn-primary" wire:click="makesellInvoice"
                                    type="button" style="margin-top: 34px">
                                    جديد
                                </button>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="datetimeNow">التاريخ والوقت</label>
                            <input type="datetime-local" name="dateBuy" id="dateBuy" class="form-control"
                                wire:model="date_sell">
                        </div>
                        <div class="col-md-6 mb-3 position-relative">
                            <label for="mobile">الهاتف</label>
                            <input type="text" id="mobileInput" wire:model.live="mobile" class="form-control"
                                autocomplete="off" placeholder="اكتب رقم الهاتف">

                            @if (!empty($phoneSuggestions) && $showSuggestions)
                                <ul class="list-group position-absolute w-100 mt-1" id="suggestionList"
                                    style="z-index: 1050;cursor: pointer;">
                                    @foreach ($phoneSuggestions as $suggestion)
                                        <li class="list-group-item list-group-item-action border-0 shadow-sm mb-1 rounded"
                                            wire:click="selectPhone('{{ $suggestion->mobile }}')">
                                            <div class="d-flex justify-content-between">
                                                <span>{{ $suggestion->mobile }}</span>
                                                <small class="text-muted">{{ $suggestion->address }}</small>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="address">العنوان</label>
                            <input type="text" wire:model="address" class="form-control"
                                placeholder="يتم ملؤه تلقائياً إن وجد">

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="type-select">اسم السائق</label>
                            <select id="nameDriver" wire:model.live="selected_driver" class="form-select">
                                <option value="">اختر السائق</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->nameDriver }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3 price-taxi-input">
                            <div class="input-wrapper">
                                <label for="pricetaxi" class="input-label">أجرة التكسي</label>

                                <div x-data>
                                    <div class="input-container">
                                        <input type="number" id="pricetaxi" name="price"
                                            class="form-control price-input" wire:model.live="pricetaxi" min="0"
                                            step="1000">

                                        <div class="input-actions">
                                            <button type="button" class="quick-select-btn"
                                                @click="$wire.set('pricetaxi', 3000)">3K</button>
                                            <button type="button" class="quick-select-btn"
                                                @click="$wire.set('pricetaxi', 4000)">4K</button>
                                            <button type="button" class="quick-select-btn"
                                                @click="$wire.set('pricetaxi', 5000)">5K</button>
                                        </div>
                                    </div>
                                </div>




                            </div>
                        </div>




                    </div>



                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="barcode">الباركود</label>
                            <input type="text" id="searchInput" class="form-control" placeholder="أدخل باركود المنتج"
                                autocomplete="off">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="productCode">الكود</label>
                            <input type="text" name="code" id="productCode" wire:model.live='search_code_name'
                                autocomplete="off" class="form-control" placeholder="الكود المنتج">

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="type-select">النوع</label>
                            <select id="type-select" name="type_id" class="form-select" style="cursor: pointer;"
                                wire:model.live="selected_type">
                                <option value="">اختر الأنواع</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->typename }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="customerNote">ملاحظة</label>
                            <input type="text" name="note" id="customerNote" class="form-control"
                                wire:model="note" placeholder="ملاحظة">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1 mb-3">
                            <button type="button"
                                class="btn btn-outline-danger d-flex align-items-center justify-content-center py-2 px-4"
                                wire:click="offersshow">

                                العروض
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="cashToggle"
                                    wire:model.live="cashornot" style="width: 3em; height: 1.5em;">
                                <label class="form-check-label ms-2 fw-bold" for="cashToggle">
                                    <span x-text="$wire.cashornot ? 'نقدي' : 'آجل'"
                                        :class="$wire.cashornot ? 'text-success' : 'text-danger'"></span>
                                    <i
                                        x-bind:class="$wire.cashornot ? 'fas fa-money-bill-wave text-success ms-1' :
                                            'far fa-credit-card text-danger ms-1'"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

    <div class="row mb-3">
        <div class="col-lg-6 mb-3">

            <div class="card mb-4">
                <div class="card-header  text-black d-flex justify-content-between align-items-center">
                    <h5 class="mb-2">المنتج المتوفر</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0" id="product-table">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th class="text-center" width="120">الباركود</th>
                                    <th class="text-center" width="120">الكود</th>
                                    <th class="text-center" width="80">المخزون</th>
                                    <th class="text-center" width="100">السعر</th>
                                    <th class="text-center" width="100">الصورة</th>
                                    <th class="text-center" width="80">الإجراء</th>
                                </tr>
                            </thead>
                            <tbody id="product-table-body">
                                @forelse ($products as $product)
                                    <tr wire:click="addProduct({{ $product->id }})" style="cursor: pointer;">
                                        <td>{{ $product->definition->name }}</td>
                                        <td class="text-center">{{ $product->definition->barcode }}</td>
                                        <td class="text-center">{{ $product->definition->code }}</td>
                                        <td class="text-center">{{ $product->quantity }}</td>
                                        <td class="text-center">{{ number_format($product->price_sell) }}</td>


                                        <td class="text-center">
                                            @if ($product->definition->image && file_exists(public_path('storage/' . $product->definition->image)))
                                                <img src="{{ asset('storage/' . $product->definition->image) }}"
                                                    width="40" height="40"
                                                    class="rounded-circle object-fit-cover border"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal{{ $product->definition->id }}"
                                                    style="cursor: pointer;" alt="صورة المنتج">
                                            @else
                                                <span class="text-muted small">لا يوجد</span>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary"
                                                wire:click.stop="addProduct({{ $product->id }})">إضافة
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



        </div>

        <div class="col-lg-6 mb-3">

            <div class="card mb-4">
                <div class="card-header  text-black d-flex justify-content-between align-items-center">
                    <h5 class="mb-2 p-1">العروض</h5>
                    <input type="text" wire:model.live='search_offer' autocomplete="off" class="form-control"
                        placeholder="Search by name code offer">
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0" id="product-table">
                            <thead class="table-light">
                                <tr>
                                    <th>المنتج</th>
                                    <th class="text-center" width="120">الكود</th>
                                    <th class="text-center" width="100">السعر</th>
                                    <th class="text-center" width="80">الإجراء</th>
                                </tr>
                            </thead>
                            <tbody id="selected-offers-body">
                                @if (!empty($offers))
                                    @forelse ($offers as $offer)
                                        <tr wire:click="addOffer({{ $offer['id'] }})" style="cursor: pointer;">
                                            <td>{{ $offer['nameoffer'] }}</td>
                                            <td class="text-center">{{ $offer['code'] }}</td>
                                            <td class="text-center">{{ number_format($offer['price']) }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-outline-primary"
                                                    wire:click.stop="addOffer({{ $offer['id'] }})">
                                                    إضافة
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-8">لا توجد عروض متاحة.
                                            </td>
                                        </tr>
                                    @endforelse
                                @endif

                            </tbody>



                        </table>
                    </div>
                </div>
            </div>



        </div>
    </div>


    <div class="row" style="margin-top: -50px">
        <!-- First Card -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-black d-flex justify-content-between align-items-center">
                    <h5 class="mb-2">المنتجات المحددة</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="selectedProductsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th class="text-center" width="120">الكود</th>
                                    <th class="text-center" width="120">الكمية</th>
                                    <th class="text-center" width="100">السعر</th>
                                    <th class="text-center" width="120">الإجمالي</th>
                                    <th class="text-center" width="80">الإجراء</th>
                                </tr>
                            </thead>

                            <tbody id="selected-products-body">
                                @forelse ($selectedProducts as $product)
                                    <tr>
                                        <td>{{ $product['name'] }}</td>
                                        <td class="text-center">{{ $product['code'] }}</td>
                                        <td class="text-center">
                                            <input type="number"
                                                wire:change="updateQuantity({{ $product['id'] }}, $event.target.value)"
                                                value="{{ $product['quantity'] }}" min="1"
                                                max="{{ $dd }}"
                                                class="form-control form-control-sm text-center" style="width: 70px;"
                                                onblur="
                                                            const max = parseInt(this.max);
                                                            const current = parseInt(this.value);
                                                            if (current > max) {
                                                            this.value = max;
                                                            this.dispatchEvent(new Event('change'));
                                                            } else if (current < this.min) { this.value=this.min;
                                                                this.dispatchEvent(new Event('change')); }">
                                        </td>
                                        <td class="text-center">{{ number_format($product['price']) }}</td>
                                        <td class="text-center">{{ number_format($product['total']) }}</td>
                                        <td>
                                            <button wire:click="removeProduct({{ $product['id'] }})"
                                                class="btn btn-outline-danger">إزالة</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center text-muted py-8">
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Card -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-black d-flex justify-content-between align-items-center">
                    <h5 class="mb-2">العرض</h5>
                    <div class="col-5">

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="selectedProductsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th class="text-center" width="120">الكود</th>
                                    <th class="text-center" width="120">الكمية</th>
                                    <th class="text-center" width="100">السعر</th>
                                    <th class="text-center" width="120">الإجمالي</th>
                                    <th class="text-center" width="80">الإجراء</th>
                                </tr>
                            </thead>
                            <tbody id="selected-products-body">
                                @forelse ($selectedoffer as $offer)
                                    <tr>
                                        <td>{{ $offer['nameoffer'] }}</td>
                                        <td class="text-center">{{ $offer['code'] }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <!-- Decrement Button -->
                                                <button wire:loading.attr="disabled"
                                                    wire:target="decrementOffer({{ $offer['id'] }})"
                                                    wire:click="decrementOffer({{ $offer['id'] }})"
                                                    class="btn btn-sm btn-outline-secondary"
                                                    @disabled($offer['quantity'] <= 0)>
                                                    <span wire:loading.remove
                                                        wire:target="decrementOffer({{ $offer['id'] }})">-</span>
                                                    <span wire:loading
                                                        wire:target="decrementOffer({{ $offer['id'] }})">
                                                        <i class="fas fa-spinner fa-spin fa-xs"></i>
                                                    </span>
                                                </button>

                                                <!-- Quantity Display -->
                                                <span class="mx-1">{{ $offer['quantity'] }}</span>

                                                <!-- Increment Button -->
                                                <button wire:loading.attr="disabled"
                                                    wire:target="incrementOffer({{ $offer['id'] }})"
                                                    wire:click="incrementOffer({{ $offer['id'] }})"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <span wire:loading.remove
                                                        wire:target="incrementOffer({{ $offer['id'] }})">+</span>
                                                    <span wire:loading
                                                        wire:target="incrementOffer({{ $offer['id'] }})">
                                                        <i class="fas fa-spinner fa-spin fa-xs"></i>
                                                    </span>
                                                </button>
                                            </div>
                                        </td>

                                        <td class="text-center">{{ number_format($offer['price']) }}</td>

                                        <td class="text-center">
                                            {{ number_format($offer['quantity'] * $offer['price']) }}
                                        </td>

                                        <td class="text-center">
                                            <!-- Remove Button -->
                                            <button wire:loading.attr="disabled"
                                                wire:target="removeOffer({{ $offer['id'] }})"
                                                wire:click="removeOffer({{ $offer['id'] }})"
                                                class="btn btn-outline-danger">
                                                <span wire:loading.remove
                                                    wire:target="removeOffer({{ $offer['id'] }})">إزالة</span>
                                                <span wire:loading wire:target="removeOffer({{ $offer['id'] }})">
                                                    <i class="fas fa-spinner fa-spin fa-xs"></i>
                                                </span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center text-muted py-8"></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card h-100">
    <div class="d-flex justify-content-between align-items-start p-3 flex-wrap" style="gap: 20px;">
        
        <!-- Summary Card (اليسار) -->
        <div class="card border-0 shadow-sm" style="width: 300px;">
            <div class="card-body p-3">
                <!-- Subtotal -->
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">الإجمالي الفرعي:</span>
                    <span class="fw-bold">{{ number_format($this->totalPrice) }}</span>
                </div>

                <!-- Discount -->
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">الخصم:</span>
                    <div class="input-group input-group-sm" style="width: 120px;">
                        <input type="number" class="form-control form-control-sm border-danger"
                            wire:model.live="discount" min="0" step="1000">
                    </div>
                </div>

                <!-- Total -->
                <div class="pt-2 mt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="fw-semibold small">الإجمالي:</span>
                    <span class="fw-bold text-success fs-5">
                        {{ number_format($generalprice) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Free Delivery Message (centered) -->
        @if($delivery_type == 1)
            <div class="d-flex align-items-center justify-content-center text-success fw-bold fs-5" 
                 style="min-width: 200px;">
                🚚 توصيل مجاني
            </div>
        @endif

        <!-- Action Buttons (اليمين) -->
        <div class="d-flex gap-2 flex-wrap align-items-start" style="min-width: 200px; margin-top:50px;">
            <button type="submit"
                class="btn btn-outline-primary d-flex align-items-center justify-content-center py-2 px-4"
                wire:loading.attr="disabled" wire:target="gitprofit" wire:click="gitprofit">
                <span wire:loading.remove wire:target="gitprofit">
                    <i class="fas fa-save me-2"></i> حفظ الفاتورة
                </span>
                <span wire:loading wire:target="gitprofit">
                    <i class="fas fa-spinner fa-spin me-2"></i>
                </span>
            </button>

            <button type="button"
                class="btn btn-outline-danger d-flex align-items-center justify-content-center py-2 px-4"
                wire:loading.attr="disabled" wire:target="refresh" wire:click="refresh">
                <span wire:loading.remove wire:target="refresh">
                    <i class="fas fa-trash-alt me-2"></i> مسح
                </span>
                <span wire:loading wire:target="refresh">
                    <i class="fas fa-spinner fa-spin me-2"></i>
                </span>
            </button>
        </div>

    </div>
</div>


    <style>
        .border-green {
            border: 1px solid green;
        }

        .clear {
            color: rgb(187, 51, 51);
            border: 1px solid rgb(187, 51, 51);
        }

        .clear:hover {
            background-color: rgb(187, 51, 51);
            border: none;
        }

        .suggestions-dropdown {
            max-height: 250px;
            overflow-y: auto;
            scrollbar-width: thin;

        }

        .suggestions-dropdown li:hover {
            background-color: #f8f9fa;
            transform: translateX(2px);

        }

        .suggestions-dropdown li:first-child {
            border-top-left-radius: inherit;
            border-top-right-radius: inherit;
        }

        .suggestions-dropdown li:last-child {
            border-bottom-left-radius: inherit;
            border-bottom-right-radius: inherit;
        }

        .price-taxi-input {
            position: relative;
        }

        .input-container {
            position: relative;
        }

        .input-actions {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 5px;
        }

        .quick-select-btn {
            padding: 2px 8px;
            font-size: 0.8rem;
            border-radius: 4px;
            background: #f0f0f0;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .quick-select-btn:hover {
            background: #e0e0e0;
        }
    </style>
    <script>
        document.addEventListener('click', function(event) {
            const input = document.getElementById('mobileInput');
            const suggestionList = document.getElementById('suggestionList');

            if (suggestionList && !suggestionList.contains(event.target) && event.target !== input) {
                @this.set('showSuggestions', false);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.quick-select-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    document.getElementById('pricetaxi').value = value;
                    // Trigger Livewire update if needed
                    Livewire.find().set('pricetaxi', value);
                });
            });
        });
    </script>
</div>
