<div>
    <div class="row">
        <div class="card-body">
            <div class="text-center mb-3">
                <h4 class="text-primary">الفاتورة رقم: {{ $num_invoice }}</h4>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12 mb-3">
            <div class="card h-100">
                <div class="row p-3">
                    <div class="col-md-6 mb-3">
                        <label for="barcode">باركود</label>
                        <input type="text" id="searchInput" class="form-control" placeholder="ادخل كود المنتج">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="productCode">كود</label>
                        <input type="text" name="code" id="productCode" wire:model.live='search_code_name'
                            autocomplete="off" class="form-control" placeholder="كود المنتج">
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-md-6 mb-3">
                        <label for="type-select">النوع</label>
                        <select id="type-select" name="type_id" class="form-select" style="cursor: pointer;"
                            wire:model.live="selected_type">
                            <option value="">اختر النوع</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->typename }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1" style="margin-top: 32px">
                        <button type="button"
                            class="btn btn-outline-danger d-flex align-items-center justify-content-center py-2 px-4"
                            wire:click="offersshow">
                            العروض
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-6 mb-3">
            <div class="card mb-4">
                <div class="card-header  text-black d-flex justify-content-between align-items-center">
                    <h5 class="mb-2">المنتجات المتاحة</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0" id="product-table">
                            <thead class="table-light">
                                <tr>
                                    <th>الاسم</th>
                                    <th class="text-center" width="120">الباركود</th>
                                    <th class="text-center" width="120">الكود</th>
                                    <th class="text-center" width="80">المخزون</th>
                                    <th class="text-center" width="100">السعر</th>
                                    <th class="text-center" width="100">الصورة</th>
                                    <th class="text-center" width="80">إجراء</th>
                                </tr>
                            </thead>
                            <tbody id="product-table-body">
                                @forelse ($products as $product)
                                    <tr>
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
                                            <button class="btn btn-sm btn-primary"
                                                wire:click="addProduct({{ $product->id }})">إضافة
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
                        placeholder="بحث بالاسم أو الكود">
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0" id="product-table">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم العرض</th>
                                    <th class="text-center" width="120">الكود</th>
                                    <th class="text-center" width="100">السعر</th>
                                    <th class="text-center" width="80">إجراء</th>
                                </tr>
                            </thead>
                            <tbody id="selected-offers-body">
                                @if (!empty($offers))
                                    @forelse ($offers as $offer)
                                        <tr>
                                            <td>{{ $offer['nameoffer'] }}</td>
                                            <td class="text-center">{{ $offer['code'] }}</td>
                                            <td class="text-center">{{ number_format($offer['price']) }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary"
                                                    wire:click="addOffer({{ $offer['id'] }})">
                                                    إضافة
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-8">لا توجد عروض</td>
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
                    <h5 class="mb-2">المنتجات المختارة</h5>
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
                                    <th class="text-center" width="120">المجموع</th>
                                    <th class="text-center" width="80">إجراء</th>
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
                                                    } else if (current < this.min) { 
                                                        this.value=this.min;
                                                        this.dispatchEvent(new Event('change')); 
                                                    }">
                                        </td>
                                        <td class="text-center">{{ number_format($product['price']) }}</td>
                                        <td class="text-center">{{ number_format($product['total']) }}</td>
                                        <td>
                                            <button wire:click="removeProduct({{ $product['id'] }})"
                                                class="btn btn-sm btn-danger">حذف</button>
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
                    <h5 class="mb-2">العروض المختارة</h5>
                    <div class="col-5"></div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="selectedProductsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم العرض</th>
                                    <th class="text-center" width="120">الكود</th>
                                    <th class="text-center" width="120">الكمية</th>
                                    <th class="text-center" width="100">السعر</th>
                                    <th class="text-center" width="120">المجموع</th>
                                    <th class="text-center" width="80">إجراء</th>
                                </tr>
                            </thead>
                            <tbody id="selected-products-body">
                                @forelse ($selectedoffer as $offer)
                                    <tr>
                                        <td>{{ $offer['nameoffer'] }}</td>
                                        <td class="text-center">{{ $offer['code'] }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <button wire:click="decrementOffer({{ $offer['id'] }})"
                                                    class="btn btn-sm btn-outline-secondary">-</button>
                                                <span class="mx-1">{{ $offer['quantity'] }}</span>
                                                <button wire:click="incrementOffer({{ $offer['id'] }})"
                                                    class="btn btn-sm btn-outline-secondary">+</button>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ number_format($offer['price']) }}</td>
                                        <td class="text-center">
                                            {{ number_format($offer['quantity'] * $offer['price']) }}
                                        </td>
                                        <td>
                                            <button wire:click="removeOffer({{ $offer['id'] }})"
                                                class="btn btn-sm btn-danger">حذف</button>
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
            <!-- Summary Card -->
            <div class="card border-0 shadow-sm" style="width: 300px;">
                <div class="card-body p-3">
                    <!-- Subtotal -->
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <span class="text-muted small">المجموع الفرعي:</span>
                        <span class="fw-bold">{{ number_format($this->totalPrice) }}</span>
                    </div>

                    <!-- Total -->
                    <div class="pt-2 mt-2 border-top d-flex justify-content-between align-items-center">
                        <span class="fw-semibold small">المجموع الكلي:</span>
                        <span class="fw-bold text-success fs-5">
                            {{ number_format($generalprice) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 flex-wrap align-items-start" style="min-width: 200px;margin-top:50px">
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
                    wire:loading.attr="disabled" wire:target="ref" wire:click="ref">
                    <span wire:loading.remove wire:target="ref">
                        <i class="fas fa-trash-alt me-2"></i> مسح الكل
                    </span>
                    <span wire:loading wire:target="ref">
                        <i class="fas fa-spinner fa-spin me-2"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>