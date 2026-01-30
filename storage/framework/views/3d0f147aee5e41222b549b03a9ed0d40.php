<div class="card p-3">
    <div x-data="{ counter: 0 }">
        <!-- Modal Edit invoice -->
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
                <select id="nameDriver" wire:model.live="selected_driver" class="form-control">
                    <option value="">اختر السائق</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($driver->id); ?>">
                            <?php echo e($driver->nameDriver); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>

            <div class="col-md-3"></div>

            <!-- Total Summary -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-2 d-flex justify-content-between bg-light rounded">
                        <span>المجموع الفواتير:</span>
                        <span class="fw-bold fs-6 text-primary">
                            <?php echo e(number_format($invoices->sum(fn($i) => $i->sell?->total_price_afterDiscount_invoice ?? 0))); ?>

                        </span>
                    </div>
                    <div class="card-body py-2 d-flex justify-content-between">
                        <span>المجموع التوصيل:</span>
                        <span class="fw-bold fs-6 text-danger">
                            <?php echo e(number_format($invoices->sum(fn($i) => $i->sell?->taxi_price ?? 0))); ?>

                        </span>
                    </div>
                    <div class="card-body py-2 d-flex justify-content-between bg-light rounded">
                        <span>المجموع الكلي:</span>
                        <span class="fw-bold fs-5 text-black">
                            <?php echo e(number_format($invoices->sum(fn($i) => ($i->sell?->total_price_afterDiscount_invoice ?? 0) + ($i->sell?->taxi_price ?? 0)))); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Date Range Section -->
        <div class="row mb-3 g-3 align-items-start">
            <div class="col-md-3">
                <label for="dateFrom" class="form-label">من تاريخ</label>
                <input type="date" id="dateFrom" wire:model="date_from" class="form-control shadow-sm">
            </div>

            <div class="col-md-3">
                <label for="dateTo" class="form-label">إلى تاريخ</label>
                <input type="date" id="dateTo" wire:model="date_to" class="form-control shadow-sm">
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary py-2 px-4 shadow-sm" wire:loading.attr="disabled"
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
        <div class="col-md-5">
            <div class="btn-group w-100" role="group">
                <button wire:click="filterPrinted(null)" type="button" class="btn btn-outline-secondary btn-sm"
                    style="height: 45px">
                    <i class="fas fa-list me-1"></i> الكل
                </button>
                <button wire:click="filterPrinted(1)" type="button" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-check-circle me-1"></i> تمت الطباعة
                </button>
                <button wire:click="filterPrinted(0)" type="button" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-times-circle me-1"></i> لم تتم الطباعة
                </button>
            </div>
        </div>

        <button wire:click="markAllCustomersAsPrinted" class="btn btn-danger">
            إنشاء حالة طباعة الكل
        </button>


        <!-- Action Buttons Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 bg-light border-bottom gap-2 gap-md-0">
                    <div class="order-2 order-md-1 text-muted text-center text-md-start">
                        
                    </div>

                    <div
                        class="order-1 order-md-2 d-flex flex-wrap justify-content-center justify-content-md-end gap-3 w-100 w-md-auto">

                        <button wire:click="printSelected" wire:loading.attr="disabled" class="btn btn-outline-primary"
                            <?php if(count($selectedInvoices) === 0): echo 'disabled'; endif; ?>>
                            <span wire:loading.remove wire:target="printSelected">
                                <i class="fas fa-print me-2"></i>
                                طباعة القائمات (<?php echo e(count($selectedInvoices)); ?>)
                            </span>
                            <span wire:loading wire:target="printSelected">
                                <i class="fas fa-spinner fa-spin me-2"></i>
                                طباعة القائمات...
                            </span>
                        </button>

                    </div>

                </div>
            </div>

            <!-- Selected Invoices Display -->
            <div class="p-3 bg-light">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $selectedInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num_invoice_sell): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <span class="badge bg-primary me-1"><?php echo e($num_invoice_sell); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <span class="text-muted">لا توجد فواتير مختارة</span>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input shadow-sm" style="cursor: pointer"
                                        wire:model.live="selectedInvoices" value="<?php echo e($invoice->num_invoice_sell); ?>"
                                        <?php if(in_array((string) $invoice->num_invoice_sell, $selectedInvoices)): echo 'checked'; endif; ?>>
                                </td>
                                <td class="text-muted align-middle"><?php echo e($loop->iteration); ?></td>
                                <td class="text-center align-middle fw-semibold">
                                    <span class="badge bg-success bg-opacity-10 text-success fs-6 fw-bold">
                                        <?php echo e($invoice->num_invoice_sell); ?>

                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <?php echo e($invoice->customer?->driver?->nameDriver ?? '—'); ?>

                                </td>
                                <td class="text-center align-middle text-truncate" style="max-width:150px;">
                                    <?php echo e($invoice->customer?->address ?? '—'); ?>

                                </td>
                                <td class="text-center align-middle"><?php echo e($invoice->customer?->mobile ?? '—'); ?></td>
                                <td class="text-center align-middle text-nowrap">
                                    <?php echo e(number_format($invoice->sell?->taxi_price ?? 0)); ?>

                                </td>
                                <td class="text-center align-middle fw-bold text-nowrap">
                                    <?php echo e(number_format($invoice->sell?->total_price_afterDiscount_invoice)); ?>

                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center">
                                        <?php echo e($invoice->date_sell ? date('Y-m-d', strtotime($invoice->date_sell)) : ''); ?>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
                <div class="mt-3">
                    <?php echo e($invoices->links()); ?>

                </div>
            </div>
        </div>

        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('close-driver-modal', () => {
                    const modalEl = document.getElementById('editDriverModal');
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();
                });
            });
        </script>

        <style>
            /* Container Styles */
            .container {
                background-color: white;
                border-radius: 0.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                padding: 1.5rem;
                margin-top: 1rem;
                margin-bottom: 1rem;
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

            <?php
        $__scriptKey = '201619956-0';
        ob_start();
    ?>
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
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>

            <?php
        $__scriptKey = '201619956-1';
        ob_start();
    ?>
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
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>

            <?php
        $__scriptKey = '201619956-2';
        ob_start();
    ?>
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
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
    </div>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/print/multiinvoices.blade.php ENDPATH**/ ?>