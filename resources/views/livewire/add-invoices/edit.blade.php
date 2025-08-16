<div>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">
                <i class="fas fa-file-invoice text-primary me-2"></i>
                تعديل الفاتورة رقم: {{ $invoice->num_invoice }}
            </h2>
            <h1>{{ $namecompany }}</h1>
            <div>
                @if ($showUpdateButton)
                    <button wire:click="updateInvoice" class="btn btn-outline-primary me-2">
                        <i class="fas fa-save me-1"></i> حفظ التعديلات
                    </button>
                @endif
                <button wire:click="toggleAddForm" class="btn btn-outline-success">
                    <i class="fas fa-plus me-1"></i> إضافة منتج
                </button>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="search" autocomplete="off" wire:model.live.debounce.500ms="search" class="form-control"
                placeholder="ابحث باسم المنتج أو الباركود...">
            @if ($search)
                <button wire:click="$set('search', '')" class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-times"></i>
                </button>
            @endif
        </div>

        <div wire:loading.delay wire:target="search" class="text-center py-2">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">جاري البحث...</span>
            </div>
        </div>

        @if ($showAddForm)
            <livewire:add-invoices.addedit.insertproduct :invoice-id="$invoiceId" :company-name="$namecompany" />
        @endif

        @if (count($this->filteredProducts) === 0 && $search)
            <div class="alert alert-info text-center">
                لا توجد نتائج مطابقة لبحثك
            </div>
        @endif

        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 25%">الاسم</th>
                                <th class="text-center" style="width: 15%">code</th>
                                <th class="text-center" style="width: 10%">كمية بيع</th>
                                <th class="text-center" style="width: 10%">الكمية</th>
                                <th class="text-center" style="width: 15%">سعر الشراء</th>
                                <th class="text-center" style="width: 20%">تاريخ الانتهاء</th>
                                <th class="text-center" style="width: 20%">delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->filteredProducts as $product)
                                <tr>
                                    
                                    <td>
                                        <input type="text" readonly class="form-control-plaintext text-center"
                                            value="{{ $product['name'] }}">
                                    </td>
                                    <td class="text-center align-middle text-muted">{{ $product['code'] }}</td>
                                    <td>
                                        <input type="number" readonly
                                            wire:model.live="products.{{ $product['__index'] }}.q_sold"
                                            class="form-control text-center">
                                    </td>
                                    <td>
                                        <input type="number" min="0"
                                            wire:model.live="products.{{ $product['__index'] }}.quantity"
                                            class="form-control text-center @error('products.' . $product['__index'] . '.quantity') is-invalid @enderror">
                                        @error('products.' . $product['__index'] . '.quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            wire:model.live="products.{{ $product['__index'] }}.buy_price"
                                            class="form-control text-center">
                                    </td>
                                    <td>
                                        <input type="date"
                                            wire:model.live="products.{{ $product['__index'] }}.dateex"
                                            class="form-control">
                                    </td>
                                    <td>
                                        <button
                                            wire:click="delete({{ $product['buy_product_invoice_id'] }})"
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
        </div>

        <div class="invoice-summary-container mb-5">
            <div class="row gy-3">
                <!-- Total Price -->
                <div class="col-12 col-sm-6 col-lg">
                    <div class="summary-card total-card">
                        <div class="card-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="card-content">
                            <div class="card-label">إجمالي الفاتورة</div>
                            <div class="card-value">{{ number_format($this->totalPrice) }} </div>
                        </div>
                    </div>
                </div>

                <!-- Discount -->
                <div class="col-6 col-sm-3 col-lg">
                    <div class="summary-card discount-card">
                        <div class="card-icon">
                            <i class="fas fa-percent"></i>
                        </div>
                        <div class="card-content">
                            <div class="card-label">الخصم</div>
                            <div class="card-value">{{ $this->discount }}<span>%</span></div>
                        </div>
                    </div>
                </div>

                <!-- After Discount -->
                <div class="col-6 col-sm-3 col-lg">
                    <div class="summary-card net-card">
                        <div class="card-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="card-content">
                            <div class="card-label">الصافي</div>
                            <div class="card-value">{{ number_format($this->afterDiscountTotalPrice) }} </div>
                        </div>
                    </div>
                </div>

                <!-- Paid Amount -->
                <div class="col-6 col-sm-4 col-lg">
                    <div class="summary-card paid-card">
                        <div class="card-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="card-content">
                            <div class="card-label">المدفوع</div>
                            <div class="card-value">{{ number_format($this->cash) }} </div>
                        </div>
                    </div>
                </div>

                <!-- Remaining -->
                <div class="col-6 col-sm-4 col-lg">
                    <div class="summary-card remaining-card">
                        <div class="card-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="card-content">
                            <div class="card-label">المتبقي</div>
                            <div class="card-value">{{ number_format($this->residual) }} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .invoice-summary-container {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .summary-card {
                background: white;
                border-radius: 12px;
                padding: 1rem;
                height: 100%;
                display: flex;
                align-items: center;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                border: 1px solid #f0f0f0;
                transition: all 0.3s ease;
            }

            .summary-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            }

            .card-icon {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-left: 12px;
                flex-shrink: 0;
            }

            .card-content {
                flex-grow: 1;
            }

            .card-label {
                color: #666;
                font-size: 0.9rem;
                margin-bottom: 4px;
            }

            .card-value {
                font-weight: 700;
                font-size: 1.4rem;
                color: #333;
            }

            .card-value span {
                font-size: 0.9rem;
                color: #888;
                margin-right: 4px;
            }

            /* Card Specific Styles */
            .total-card .card-icon {
                background-color: rgba(41, 98, 255, 0.1);
                color: #2962FF;
            }

            .discount-card .card-icon {
                background-color: rgba(255, 171, 0, 0.1);
                color: #FFAB00;
            }

            .net-card .card-icon {
                background-color: rgba(0, 200, 83, 0.1);
                color: #00C853;
            }

            .paid-card .card-icon {
                background-color: rgba(233, 30, 99, 0.1);
                color: #E91E63;
            }

            .remaining-card .card-icon {
                background-color: rgba(156, 39, 176, 0.1);
                color: #9C27B0;
            }

            /* Responsive Adjustments */
            @media (max-width: 576px) {
                .card-value {
                    font-size: 1.2rem;
                }

                .card-icon {
                    width: 40px;
                    height: 40px;
                    font-size: 0.9rem;
                }
            }
        </style>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <label for="note" class="form-label">ملاحظة</label>
                <textarea wire:model="note" class="form-control" id="note" rows="3"
                    placeholder="أضف ملاحظة إذا لزم الأمر..."></textarea>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</div>
