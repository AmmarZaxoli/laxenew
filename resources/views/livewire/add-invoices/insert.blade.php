<div>
    <div class="container-fluid p-0">
        <!-- Invoice Creation Section -->
        <form wire:submit.prevent="storeinvoice">
            <div class="card shadow-sm" style="margin-top: -25px">
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-2 col-6">
                            <label for="num_invoice" class="form-label fw-bold">رقم القائمة</label>
                            <input type="text" id="num_invoice" class="form-control" wire:model="num_invoice"
                                @if ($this->invoicevisibale) disabled @endif autocomplete="off">
                            @error('num_invoice')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror

                        </div>


                        <div class="col-md-4 col-6 position-relative" x-data @click.away="$wire.hideDropdown()">
                            <label class="form-label fw-bold">اسم الشركة</label>

                            <input type="text" class="form-control me-2" wire:model.live="search"
                                @focus="$wire.call('showCompanies')" autocomplete="off" placeholder="ابحث عن الشركة"
                                @if ($invoicevisibale) disabled @endif>
                            @error('search')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror

                            @if ($showDropdown && count($companys) > 0)
                                <div class="dropdown-menu show"
                                    style="position: absolute; top: 110%; left: 0; right: 0;
                   max-height: 200px; overflow-y: auto; z-index: 1000;">
                                    @foreach ($companys as $company)
                                        <button type="button" class="dropdown-item"
                                            wire:click="selectCompany({{ $company->id }})">
                                            {{ $company->companyname }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>





                        <div class="col-md-3 col-6">
                            <label for="datecreate" class="form-label fw-bold">تاريخ الإنشاء</label>
                            <input type="datetime-local" id="datecreate" wire:model="datecreate"
                                class="form-control text-center">
                        </div>

                        <div class="col-md-3 col-6 align-items-end" style="margin-top: 57px">
                            <button type="submit" class="btn btn-icon btn-outline-primary pulse-hover w-100"
                                wire:loading.attr="disabled" wire:target="storeinvoice" style="height: 40px;"
                                @if ($this->invoicevisibale) disabled @endif>
                                <span wire:loading.remove wire:target="storeinvoice">
                                    <i class="fas fa-plus"></i> حفظ الفاتورة
                                </span>
                                <span wire:loading wire:target="storeinvoice">
                                    <i class="fas fa-spinner fa-spin"></i> جاري الحفظ...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <livewire:add-invoices.search-product>

            <!-- Product Addition Section -->
            <form wire:submit.prevent="addproduct">
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <div class="row g-3">


                            <!-- Quantity -->
                            <div class="col-md-3 col-6">
                                <label for="quantity" class="form-label fw-bold">عدد</label>
                                <input type="number" wire:model.live="quantity"
                                    class="form-control text-center @error('quantity') is-invalid @enderror"
                                    min="1" step="1">
                                @error('quantity')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Buy Price -->
                            <div class="col-md-3 col-6">
                                <label for="buy_price" class="form-label fw-bold">سعر الشراء</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" wire:model.live="buy_price"
                                        class="form-control text-center @error('buy_price') is-invalid @enderror"
                                        min="0.01" step="0.01">
                                    @error('buy_price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sell Price -->
                            <div class="col-md-3 col-6">
                                <label for="sell_price" class="form-label fw-bold">سعر البيع</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" wire:model.live="sell_price"
                                        class="form-control text-center @error('sell_price') is-invalid @enderror"
                                        min="0.01" step="0.01">
                                    @error('sell_price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Profit -->
                            <div class="col-md-3 col-6">
                                <label for="profit" class="form-label fw-bold">نسبة %</label>
                                <input type="text" value="{{ $profit }}%"
                                    class="form-control text-center {{ $profit <= 0 ? 'bg-danger text-white' : 'bg-light' }}"
                                    readonly>
                            </div>

                            <!-- Total Price -->
                            <div class="col-md-3 col-6">
                                <label for="tprice" class="form-label fw-bold">سعر الكلي</label>
                                <input type="text" value="{{ number_format($tprice) }} "
                                    class="form-control bg-light text-center" readonly>
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-md-3 col-6">
                                <label for="dateex" class="form-label fw-bold">التاريخ انتهاء</label>
                                <input type="date" id="dateex" class="form-control text-center"
                                    wire:model="dateex">
                            </div>

                            <!-- Save Button -->
                            <div class="col-md-3 col-6 d-flex align-items-end" style="margin-top: 58px">
                                <button type="submit" class="btn btn-icon btn-outline-primary pulse-hover w-100"
                                    style="height: 40px;" wire:loading.attr="disabled" wire:target="addproduct"
                                    @if (!$invoicevisibale) disabled @endif>
                                    <span wire:loading.remove wire:target="addproduct">
                                        <i class="fas fa-plus"></i> إضافة
                                    </span>
                                    <span wire:loading wire:target="addproduct">
                                        <i class="fas fa-spinner fa-spin"></i> جاري الإضافة...
                                    </span>
                                </button>
                            </div>


                        </div>
                    </div>
                </div>
            </form>

            <!-- Products Table -->
            @if (count($products) > 0)
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="40" class="text-center">#</th>
                                    <th class="text-center">الاسم</th>
                                    <th class="text-center" width="40">الكود</th>
                                    <th class="text-center" width="200">الباركود</th>
                                    <th class="text-center" width="120">الكمية</th>
                                    <th class="text-center" width="120">سعر الشراء</th>
                                    <th class="text-center" width="120">سعر البيع</th>
                                    <th class="text-center" width="100">الربح %</th>
                                    <th class="text-center" width="120">تاريخ الانتهاء</th>
                                    <th width="100" class="text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $product)
                                    <tr class="align-middle">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="fw-medium">{{ $product['name'] }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                {{ $product['code'] }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $product['barcode'] }}</td>
                                        <td class="text-center">{{ $product['quantity'] }}</td>
                                        <td class="text-center">{{ number_format($product['buy_price']) }} </td>
                                        <td class="text-center">{{ number_format($product['sell_price']) }} </td>
                                        <td class="text-center">{{ $product['profit'] }}%</td>
                                        <td class="text-center">{{ $product['dateex'] ?? '-' }}</td>
                                        <td class="text-center">
                                            <button wire:click="removeProduct({{ $index }})"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if (!empty($product) && is_array($product) && count($product))
                <form wire:submit.prevent="update_store_total_invoice">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="row g-3">


                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="min-width:140px">المبلغ الإجمالي</label>
                                    <input type="text" class="form-control text-center" readonly
                                        value="{{ number_format($this->totalTprice) }}">
                                </div>


                                <div class="col-md-2">
                                    <label class="form-label fw-bold">الخصم %</label>
                                    <input type="number" wire:model.live="discount" min="0" max="100"
                                        class="form-control text-center">

                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-bold">بعد الخصم</label>
                                    <input type="text" class="form-control text-center" readonly
                                        value="{{ number_format($this->getAfterDiscountTotalPriceProperty()) }}">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-bold">المدفوع</label>
                                    <input type="number" wire:model.live="cash" min="0"
                                        class="form-control text-center">

                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">المدفوع</label>
                                    <label for="note" class="form-label fw-bold">ملاحظات</label>
                                    <textarea name="note" class="form-control mb-3" wire:model="note" rows="3" style="height: 20px"></textarea>

                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-bold">المتبقي</label>
                                    <input type="text" class="form-control text-center" readonly
                                        value="{{ number_format($this->afterCash) }}">
                                </div>

                                {{-- <div class="col-md-2 d-flex align-items-end" style="margin-top: 57px">
                                    <button type="submit" class="btn btn-primary w-100 py-2"
                                        wire:loading.attr="disabled" wire:target="storeinfoinvoice">
                                        <span wire:loading.remove wire:target="storeinfoinvoice">
                                            حفظ الفاتورة
                                        </span>
                                        <span wire:loading wire:target="storeinfoinvoice">
                                            <i class="fas fa-spinner fa-spin"></i> جاري الحفظ...
                                        </span>
                                    </button>

                                </div> --}}

                                @if (count($products) > 0)
                                    <div class="col-md-3 col-6 d-flex align-items-end">
                                        <button type="button" wire:click="store"
                                            class="btn btn-icon btn-outline-success pulse-hover w-100"
                                            style="height: 40px;" wire:loading.attr="disabled" wire:target="store">
                                            <span wire:loading.remove wire:target="store">
                                                <i class="fas fa-save"></i> حفظ الكل
                                            </span>
                                            <span wire:loading wire:target="store">
                                                <i class="fas fa-spinner fa-spin"></i> جاري الحفظ...
                                            </span>
                                        </button>
                                    </div>
                                @endif
                            </div>

                        </div>

                    </div>
                </form>
            @endif
    </div>

</div>
</div>
