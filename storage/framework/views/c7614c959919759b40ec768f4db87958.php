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
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('returnproducts.show', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1790511044-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
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
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('addproduct.add-invoice-product', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1790511044-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
    </div>







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
        </div>
    </div>

    <!-- Action Buttons Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="card-body p-0">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 bg-light border-bottom gap-2 gap-md-0">
                    <div class="order-2 order-md-1 text-muted text-center text-md-start">
                        
                    </div>

                    <div
                        class="order-1 order-md-2 d-flex flex-wrap justify-content-center justify-content-md-end gap-3 w-100 w-md-auto">
                        <!-- Delete Button -->
                        <button class="btn btn-outline-danger" wire:click="$dispatch('confirmDeleteSelected')"
                            <?php if(count($selectedInvoices) === 0): echo 'disabled'; endif; ?>>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-trash-alt me-2"></i>
                                <span>حذف المحدد</span>
                            </div>
                        </button>



                        <!-- Payment Button -->
                        <button class="btn btn-outline-success" wire:click="$dispatch('confirm-payment')"
                            <?php if(count($selectedInvoices) === 0): echo 'disabled'; endif; ?>>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-credit-card me-2"></i>
                                <span>إرجاع الدفع المحدد</span>
                            </div>
                        </button>


                        <!-- Edit Date Button -->
                        <button class="btn btn-outline-primary" wire:click="openBulkDateModal"
                            <?php if(count($selectedInvoices) === 0): echo 'disabled'; endif; ?>>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>تعديل تاريخ للمحدد</span>
                            </div>
                        </button>



                    </div>
                </div>
            </div>

            <!-- Selected Invoices Display -->
            <div class="p-3 bg-light">
                <?php $__empty_1 = true; $__currentLoopData = $selectedInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num_invoice_sell): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <span class="badge bg-primary me-1"><?php echo e($num_invoice_sell); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <span class="text-muted">لا توجد فواتير مختارة</span>
                <?php endif; ?>
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
                        <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                    <?php echo e($invoice->customer?->address ?? '—'); ?></td>
                                <td class="text-center align-middle"><?php echo e($invoice->customer?->mobile ?? '—'); ?></td>
                                <td class="text-center align-middle text-nowrap">
                                    <?php echo e(number_format($invoice->sell?->taxi_price ?? 0)); ?> </td>
                                <td class="text-center align-middle fw-bold text-nowrap">
                                    <?php echo e(number_format($invoice->sell?->total_price_afterDiscount_invoice)); ?> </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center">
                                        <?php echo e($invoice->date_sell ? date('Y-m-d', strtotime($invoice->date_sell)) : ''); ?>

                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center">
                                        <?php echo e(number_format($invoice->customer?->profit_invoice ?? 0)); ?><br>
                                        <?php echo e(number_format($invoice->customer?->profit_invoice_after_discount ?? 0)); ?>


                                </td>
                               <td class="text-center">
    <div class="dropstart">  
        <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Invoice actions">
            <i class="fas fa-ellipsis-h"></i>
        </button>
       <ul class="dropdown-menu shadow p-2" style="width: 270px; white-space: nowrap; margin-right: 10px;">
<div class="d-flex flex-nowrap gap-3">
             <li class="d-inline-block">
                <!-- Print -->
                <button class="btn btn btn-outline-primary px-2"
                        wire:click="print(<?php echo e($invoice->id); ?>)"
                        title="طباعة الفاتورة">
                    <i class="fas fa-print me-1"></i>
                </button>
            </li>
             
             <li class="d-inline-block">
                <!-- Add Products -->
                <button class="btn btn btn-outline-success px-2"
                        data-bs-toggle="modal" data-bs-target="#addinvoiceproduct"
                        wire:click="numinvoice(<?php echo e($invoice->num_invoice_sell); ?>)"
                        title="إضافة منتجات">
                    <i class="fas fa-cart-plus me-1"></i>
                </button>
            </li>
             <li class="d-inline-block">
                <!-- Mark as Paid -->
            <button class="btn btn-outline-danger px-2"
        wire:click="payment(<?php echo e($invoice->id); ?>)"
        title="إرجاع الدفع">
    <i class="fas fa-money-bill-wave me-1"></i>
</button>

            </li>
             <li class="d-inline-block">
                <!-- Edit Invoice -->
                <button class="btn btn btn-outline-warning px-2"
                        data-bs-toggle="modal" data-bs-target="#EditInvoice"
                        wire:click="numinvoice(<?php echo e($invoice->num_invoice_sell); ?>)"
                        title="تعديل الفاتورة">
                    <i class="fas fa-edit me-1"></i>
                </button>
            </li>
             <li class="d-inline-block">
                <!-- Delete -->
                <button class="btn btn btn-outline-danger px-2"
                        wire:click.prevent="$dispatch('confirmDelete', { id: <?php echo e($invoice->id); ?> })"
                        title="حذف الفاتورة">
                    <i class="fas fa-trash-alt me-1"></i>
                </button>
            </li>
            
                </div>
                
               
                
               
                
               
                
               
           
        </ul>
    </div>
</td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="11" class="text-center py-5 text-muted">
                                    <i class="fas fa-file-invoice fa-3x opacity-25 mb-3"></i>
                                    <h5 class="fw-light">لا توجد فواتير لعرضها</h5>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bulk Date Edit Modal -->
        <?php if($showBulkDateModal): ?>
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
                            <button type="button" wire:click="updateBulkDateSell"
                                class="btn btn-outline-primary shadow-sm">
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
        <?php endif; ?>



        <script>
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

            <?php
        $__scriptKey = '1790511044-0';
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
        $__scriptKey = '1790511044-1';
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
        $__scriptKey = '1790511044-2';
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
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\return-sell\show.blade.php ENDPATH**/ ?>