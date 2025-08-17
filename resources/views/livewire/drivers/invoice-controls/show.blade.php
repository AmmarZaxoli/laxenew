<div x-data="{ counter: 0 }">
    <!-- Modal Edit invoice -->
    <div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="EditInvoice" tabindex="-1"
        aria-labelledby="EditInvoice" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mb-0">معلومات الفاتورة</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <livewire:returnproducts.show>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add products to invoice -->
    <div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="addinvoiceproduct" tabindex="-1"
        aria-labelledby="addinvoiceproduct" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mb-0">إضافة منتج</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <livewire:addproduct.add-invoice-product>
                </div>
            </div>
        </div>
    </div>


    <!-- Bulk Driver Edit Modal -->
    @if ($showBulkDriverModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-light  text-black">
                        <h5 class="modal-title">تغيير السائق للفواتير المحددة</h5>
                        <button type="button" class="btn-close btn-close-black"
                            wire:click="$set('showBulkDriverModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <label for="bulkDriverId" class="form-label">اختر السائق الجديد</label>
                        <select id="bulkDriverId" wire:model.live="bulkDriverId" class="form-select shadow-sm">
                            <option value="">-- اختر السائق --</option>
                            @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}"> {{ $driver->nameDriver }} </option>
                            @endforeach
                        </select>
                        @error('bulkDriverId')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button wire:click="updateBulkDriver" class="btn btn-outline-primary shadow-sm">
                            <i class="fas fa-save me-2"></i> تحديث
                        </button>
                        <button type="button" class="btn btn-outline-secondary shadow-sm"
                            wire:click="$set('showBulkDriverModal', false)">
                            <i class="fas fa-times me-2"></i> إلغاء
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif




    <!-- Search and Filter Section -->
    <div class="row mb-3 g-3 align-items-end">
        <!-- Search by Invoice Number -->
        <div class="col-md-3">
            <label for="search" class="form-label">البحث برقم الفاتورة او الهاتف</label>
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-light">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" id="search" wire:model.live="search" autocomplete="off" class="form-control"
                    placeholder="أدخل رقم الفاتورة أو الكود...">
            </div>
        </div>

        <!-- Filter by Driver -->
        <div class="col-md-3">
            <label for="nameDriver" class="form-label">أسماء السائقين</label>
            <select id="nameDriver" wire:model.live="selected_driver" class="form-select shadow-sm">
                <option value="">اختر السائق</option>
                @foreach ($drivers as $driver)
                    <option value="{{ $driver->id }}">
                        {{ $driver->nameDriver }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3"></div>

        <!-- Total Summary -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-2 d-flex justify-content-between bg-light rounded">
                    <span>المجموع الفواتير:</span>
                    <span class="fw-bold fs-6 text-primary">
                        {{ number_format($invoices->sum(fn($i) => $i->sell?->total_price_afterDiscount_invoice ?? 0)) }}
                    </span>
                </div>
                <div class="card-body py-2 d-flex justify-content-between">
                    <span>المجموع التوصيل:</span>
                    <span class="fw-bold fs-6 text-danger">
                        {{ number_format($invoices->sum(fn($i) => $i->sell?->taxi_price ?? 0)) }}
                    </span>
                </div>
                <div class="card-body py-2 d-flex justify-content-between bg-light rounded">
                    <span>المجموع الكلي:</span>
                    <span class="fw-bold fs-5 text-black">
                        {{ number_format($invoices->sum(fn($i) => ($i->sell?->total_price_afterDiscount_invoice ?? 0) + ($i->sell?->taxi_price ?? 0))) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Range Section -->
    <div class="row mb-3 g-3 align-items-start">
        <div class="col-md-3">
            <label for="dateRange" class="form-label">من تاريخ</label>
            <input type="date" id="dateRange" wire:model="date_from" class="form-control shadow-sm">
        </div>

        <div class="col-md-3">
            <label for="dateRange" class="form-label">إلى تاريخ</label>
            <input type="date" id="dateRange" wire:model="date_to" class="form-control shadow-sm">
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-outline-primary  py-2 px-4 shadow-sm" wire:loading.attr="disabled"
                style="margin-top: 41px" wire:target="filterByDate" wire:click="filterByDate">
                <span wire:loading.remove wire:target="filterByDate">
                    <i class="fas fa-search me-2"></i> بحث
                </span>
                <span wire:loading wire:target="filterByDate">
                    <i class="fas fa-spinner fa-spin me-2"></i>
                    جاري البحث...
                </span>
            </button>
            <button type="button" class="btn btn-outline-secondary py-2 px-4 shadow-sm" style="margin-top: 41px"
                onclick="location.reload();">
                <i class="fas fa-sync-alt me-1"></i> تحديث </button>
        </div>
    </div>

    <!-- Action Buttons Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="card-body p-0">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 bg-light border-bottom gap-2 gap-md-0">
                    <div class="order-2 order-md-1 text-muted text-center text-md-start">
                        {{-- <span class="fw-semibold">{{ $invoices->count() }}</span> عدد الفواتير --}}
                    </div>

                    <div
                        class="order-1 order-md-2 d-flex flex-wrap justify-content-center justify-content-md-end gap-3 w-100 w-md-auto">
                        <!-- Delete Button -->
                        <button class="btn btn-outline-danger" wire:click="$dispatch('confirmDeleteSelected')"
                            @disabled(count($selectedInvoices) === 0)>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-trash-alt me-2"></i>
                                <span>حذف المحدد</span>
                            </div>
                        </button>



                        <!-- Payment Button -->
                        <button class="btn btn-outline-success" wire:click="$dispatch('confirm-payment')"
                            @disabled(count($selectedInvoices) === 0)>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-credit-card me-2"></i>
                                <span>الدفع المحدد</span>
                            </div>
                        </button>


                        <!-- Edit Date Button -->
                        <button class="btn btn-outline-primary" wire:click="openBulkDateModal"
                            @disabled(count($selectedInvoices) === 0)>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>تعديل تاريخ للمحدد</span>
                            </div>
                        </button>

                        <!-- Change Driver Button -->
                        <button class="btn btn-outline-primary" wire:click="openBulkDriverModal"
                            @disabled(count($selectedInvoices) === 0)>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-tie me-2"></i>
                                <span>تغيير السائق للمحدد</span>
                            </div>
                        </button>
                        <button wire:click="printdriver" wire:loading.attr="disabled" class="btn btn-outline-primary"
                            @disabled(empty($selected_driver))>
                            <span wire:loading.remove wire:target="printdriver">
                                <i class="fas fa-print me-2"></i>
                                طباعة حسب السائق
                                @if (!empty($invoicesCount))
                                    ({{ $invoicesCount }})
                                @endif
                            </span>
                            <span wire:loading wire:target="printdriver">
                                <i class="fas fa-spinner fa-spin me-2"></i>
                                جاري تجهيز الطباعة...
                            </span>
                        </button>

                    </div>

                </div>
            </div>
        </div>

        <!-- Selected Invoices Display -->
        <div class="p-3 bg-light">
            @forelse ($selectedInvoices as $num_invoice_sell)
                <span class="badge bg-primary me-1">{{ $num_invoice_sell }}</span>
            @empty
                <span class="text-muted">لا توجد فواتير مختارة</span>
            @endforelse
            : الفواتير المختارة
        </div>

        <!-- Invoices Table -->
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40" class="ps-3 align-middle">
                            <input type="checkbox" class="form-check-input shadow-sm" id="selectAll"
                                style="cursor: pointer" wire:model.live="selectAll">

                        </th>
                        <th width="50" class="align-middle">#</th>
                        <th class="text-center align-middle">رقم الفاتورة</th>
                        <th class="text-center align-middle">السائق</th>
                        <th class="text-center align-middle">العنوان</th>
                        <th class="text-center align-middle">الجوال</th>
                        <th class="text-center align-middle">التوصيل</th>
                        <th class="text-center align-middle">الإجمالي</th>
                        <th class="text-center align-middle">التاريخ</th>
                        <th class="text-center align-middle">profit</th>
                        <th class="text-center align-middle pe-3">خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input shadow-sm" style="cursor: pointer"
                                    wire:model.live="selectedInvoices" value="{{ $invoice->num_invoice_sell }}"
                                    @checked(in_array((string) $invoice->num_invoice_sell, $selectedInvoices))>
                            </td>
                            <td class="text-muted align-middle">{{ $loop->iteration }}</td>
                            <td class="text-center align-middle fw-semibold">
                                <span class="badge bg-success bg-opacity-10 text-success fs-6 fw-bold">
                                    {{ $invoice->num_invoice_sell }}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                {{ $invoice->customer?->driver?->nameDriver ?? '—' }}
                            </td>
                            <td class="text-center align-middle text-truncate" style="max-width:150px;">
                                {{ $invoice->customer?->address ?? '—' }}
                            </td>
                            <td class="text-center align-middle">{{ $invoice->customer?->mobile ?? '—' }}</td>
                            <td class="text-center align-middle text-nowrap">
                                {{ number_format($invoice->sell?->taxi_price ?? 0) }}
                            </td>
                            <td class="text-center align-middle fw-bold text-nowrap">
                                {{ number_format($invoice->sell?->total_price_afterDiscount_invoice) }}
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    {{ $invoice->date_sell ? date('Y-m-d', strtotime($invoice->date_sell)) : '' }}
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    {{ number_format($invoice->customer?->profit_invoice ?? 0) }}<br>
                                    {{ number_format($invoice->customer?->profit_invoice_after_discount ?? 0) }}

                            </td>
                            <td class="text-center">
                                <div class="dropstart">
                                    <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false" aria-label="Invoice actions">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow p-2"
                                        style="width: auto; white-space: nowrap; margin-right: 10px;">
                                        <li class="d-inline-block">
                                            <button type="button" class="btn btn-outline-primary mx-1" title="طباعة"
                                                onclick="printInvoice({{ $invoice->id }})">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        </li>
                                        <li class="d-inline-block">
                                            <button class="btn btn-outline-success mx-1" data-bs-toggle="modal"
                                                data-bs-target="#addinvoiceproduct"
                                                wire:click="numinvoice({{ $invoice->num_invoice_sell }})"
                                                title="إضافة منتجات">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </li>
                                        <li class="d-inline-block">
                                            <button class="btn btn-outline-dark mx-1"
                                                wire:click="payment({{ $invoice->id }})" title="تم الدفع">
                                                <i class="fas fa-dollar-sign"></i>
                                            </button>
                                        </li>
                                        <li class="d-inline-block">
                                            <button class="btn btn-outline-warning mx-1" data-bs-toggle="modal"
                                                data-bs-target="#EditInvoice"
                                                wire:click="numinvoice({{ $invoice->num_invoice_sell }})"
                                                title="تعديل الفاتورة">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </li>
                                        <li class="d-inline-block">
                                            <button class="btn btn-outline-info mx-1"
                                                wire:click="openDriverModal({{ $invoice->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editDriverModal" title="تعديل السائق">
                                                <i class="fas fa-user-edit"></i>
                                            </button>
                                        </li>
                                        <li class="d-inline-block">
                                            <button class="btn btn-outline-danger mx-1"
                                                wire:click.prevent="$dispatch('confirmDelete', { id: {{ $invoice->id }} })"
                                                title="حذف الفاتورة">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                <i class="fas fa-file-invoice fa-3x opacity-25 mb-3"></i>
                                <h5 class="fw-light">لا توجد فواتير لعرضها</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bulk Date Edit Modal -->
    @if ($showBulkDateModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-light text-black">
                        <h5 class="modal-title">تعديل تاريخ البيع للفواتير المحددة</h5>
                        <button type="button" class="btn-close btn-close-black"
                            wire:click="$set('showBulkDateModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <label for="bulkNewDateSell" class="form-label">اختر التاريخ الجديد</label>
                        <input type="datetime-local" wire:model="bulkNewDateSell" id="bulkNewDateSell"
                            class="form-control shadow-sm">
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="updateBulkDateSell" class="btn btn-outline-primary shadow-sm">
                            <i class="fas fa-save me-2"></i>حفظ التغيير
                        </button>
                        <button type="button" class="btn btn-outline-secondary shadow-sm"
                            wire:click="$set('showBulkDateModal', false)">
                            <i class="fas fa-times me-2"></i>إلغاء
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Driver Modal -->
    <div wire:ignore.self class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="editDriverModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">تعديل السائق</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="driver" class="form-label">اختر السائق</label>
                        <select wire:model="selectedDriverId" class="form-select shadow-sm" id="driver">
                            <option value="">-- اختر السائق --</option>
                            @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->nameDriver }}</option>
                            @endforeach
                        </select>
                        @error('selectedDriverId')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="updateDriver" class="btn btn-outline-primary shadow-sm">
                        <i class="fas fa-save me-2"></i>تحديث
                    </button>
                    <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>إلغاء
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('print-single-invoice-browser', e => {
            Livewire.dispatch('print-single-invoice', e.detail);
        });
        document.addEventListener('livewire:init', () => {
            Livewire.on('close-driver-modal', () => {
                const modalEl = document.getElementById('editDriverModal');
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();
            });
        });

        window.addEventListener('close-modal', event => {
            const modalEl = document.getElementById('EditInvoice');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.hide();
        });
        window.addEventListener('close-modal', event => {
            const modalEl = document.getElementById('addinvoiceproduct');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.hide();
        });


        // document.addEventListener('livewire:load', () => {
        //     Livewire.on('close-driver-modal', () => {
        //         const modalEl = document.getElementById('editDriverModal');
        //         const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        //         modal.hide();
        //     });
        // });
    </script>

    <style>
        /* Counter Styles */
        .counter-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .counter-btn:hover {
            transform: scale(1.1);
        }

        /* Table Styles */
        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        /* Badge Styles */
        .badge {
            padding: 0.5em 0.75em;
            font-weight: 600;
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(13, 110, 253, 0.1);
        }

        /* Modal Styles */
        .modal-header {
            border-bottom: none;
        }

        /* Button Styles */
        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        /* Shadow Utility */
        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @script
    <script>
        $wire.on("confirmDelete", (event) => {
            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من التراجع!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم، احذفه!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.call("delete", event.id);
                }
            });
        });
    </script>
    @endscript


    @script
    <script>
        $wire.on('confirm-payment', () => {
            Swal.fire({
                title: "تأكيد الدفع",
                text: "هل تريد تأكيد دفع الفواتير المحددة؟",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "نعم، تأكيد",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.call('paymentmulti');
                }
            });
        });
    </script>
    @endscript
    @script
    <script>
        $wire.on('confirmDeleteSelected', () => {
            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "سيتم حذف جميع الفواتير المحددة ولا يمكن التراجع!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم، احذفهم!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.call('deleteSelected');
                }
            });
        });
    </script>
    @endscript
</div>