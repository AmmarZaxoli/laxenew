<div class="card">
    <div class="card-body">
        <div class="container-fluid p-0">
            <div class="row g-3 mb-4 align-items-end">
                <!-- Search Column -->
                <div class="col-md-8 col-lg-5">
                    <label class="form-label small text-muted mb-1">بحث</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" wire:model.live="search_code_name" placeholder="بحث بالاسم، الكود، ..."
                            class="form-control">
                    </div>
                </div>

                <!-- Type Select Column -->
                <div class="col-md-4 col-lg-3">
                    <label class="form-label small text-muted mb-1">النوع</label>
                    <select wire:model.live="selected_type" class="form-control">
                        <option value="">كل الانواع</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->typename }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Main Products Table -->
            <div class="col-md-7">
                <div class="table-responsive" wire:poll>
                    <table class="table table-striped table-hover mb-0" id="product-table">
                        <thead class="table-light" style="text-align: end">
                            <tr>
                                <th style="text-align: start">#</th>
                                <th style="text-align: start">الاسم</th>
                                <th class="text-center" width="120">Barcode</th>
                                <th class="text-center" width="120">الكود</th>
                                <th class="text-center" width="80">رصيد</th>
                                <th class="text-center" width="100">الصورة</th>
                                <th class="text-center" width="80">إجراء</th>
                            </tr>
                        </thead>
                        <tbody id="product-table-body text-align-center">
                            @forelse ($products as $product)
                                <tr>
                                    <td style="text-align: start">{{ $loop->iteration }}</td>
                                    <td style="text-align: start">{{ $product->definition->name }}</td>
                                    <td class="text-center">{{ $product->definition->barcode }}</td>
                                    <td class="text-center">{{ $product->definition->code }}</td>
                                    <td class="text-center">{{ $product->quantity }}</td>

                                    <td class="text-center">
                                        @if ($product->definition->image && file_exists(public_path('storage/' . $product->definition->image)))
                                            <img src="{{ asset('storage/' . $product->definition->image) }}"
                                                width="40" height="40"
                                                class="rounded-circle object-fit-cover border" data-bs-toggle="modal"
                                                data-bs-target="#imageModal{{ $product->definition->id }}"
                                                style="cursor: pointer;" alt="صورة المنتج">
                                        @else
                                            <span class="text-muted small">لا يوجد</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button class="btn btn-sm btn-primary"
                                            wire:click="addProduct({{ $product->id }})">
                                            <i class="fas fa-plus"></i>

                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-2">
                                        لا توجد نتائج مطابقة للبحث.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Secondary Table -->
            <div class="col-md-5">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الكود</th>
                                <th>رصيد</th>
                                <th>سعر الشراء</th>
                                <th style="text-align: center">الكمية</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selectedProducts as $productId => $product)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $product['name'] }}</td>
                                    <td class="text-center">{{ $product['code'] }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $product['stock'] <= 0 ? 'bg-danger' : ($product['quantity'] < 5 ? 'bg-warning text-dark' : 'bg-light text-dark') }}">
                                            {{ $product['stock'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ number_format($totalBuy[$productId] ?? 0) }}</td>

                                    <td class="text-center">
                                        <input type="number"
                                            wire:model.live="selectedProducts.{{ $productId }}.quantity"
                                            wire:change="validateQuantity({{ $productId }}, $event.target.value)"
                                            min="1" max="{{ $product['stock'] }}"
                                            class="form-control form-control-sm text-center @if ($product['quantity'] > $product['stock']) is-invalid @endif"
                                            style="width: 70px; display: inline-block;"
                                            oninput="this.value = Math.max(1, Math.min(parseInt(this.value) || 1, {{ $product['stock'] }}))">

                                        @if ($product['quantity'] > $product['stock'])
                                            <div class="invalid-feedback d-block small">
                                                الكمية تتجاوز المخزون المتاح ({{ $product['stock'] }})
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="removeProduct({{ $productId }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if (count($selectedProducts) > 0)
                <div class="d-flex justify-content-end mt-3">
                    <div class="bg-light border rounded px-4 py-2 fw-bold text-end">
                        <span>مجموع الشراء:</span>
                        <span class="text-primary">
                            {{ number_format($this->getGrandTotalBuy()) }}

                        </span>
                        <span>د.ع</span>
                    </div>
                </div>
            @endif
            <div class="container mt-4">
                <form wire:submit.prevent='storeOffer'>
                    <div class="row g-4">
                        <!-- اسم العرض -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="nameoffer" class="form-label">اسم الاوفر</label>
                            <input type="text" class="form-control shadow-sm" wire:model="nameoffer"
                                autocomplete="off">
                            @error('nameoffer')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- الكود -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="code" class="form-label">الكود</label>
                            <input type="text" class="form-control shadow-sm" wire:model="code" id="code"
                                autocomplete="off">
                            @error('code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- سعر الاوفر -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="price" class="form-label">سعر الاوفر</label>
                            <input type="text" class="form-control shadow-sm" wire:model.lazy="price"
                                id="name" autocomplete="off">
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" >
                            <label class="form-label">التوصيل مجاني ؟</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    wire:model.live="delivery" id="deliverableSwitch"
                                    style="width: 3em; height: 1.5em; cursor: pointer;">
                                <label class="form-check-label ms-2" for="deliverableSwitch">
                                    <span class="fw-bold {{ $delivery ? 'text-success' : 'text-danger' }}">

                                    </span>
                                </label>
                            </div>
                            @error('delivery')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- زر الحفظ -->
                        <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i> حفظ الاوفر
                                <span wire:loading wire:target="storeOffer">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    جاري الحفظ...
                                </span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
