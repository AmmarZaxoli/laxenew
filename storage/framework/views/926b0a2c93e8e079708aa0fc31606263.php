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

$__html = app('livewire')->mount($__name, $__params, 'lw-3667539297-0', $__slots ?? [], get_defined_vars());

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

$__html = app('livewire')->mount($__name, $__params, 'lw-3667539297-1', $__slots ?? [], get_defined_vars());

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


    <!-- Bulk Driver Edit Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showBulkDriverModal): ?>
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
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->id); ?>"> <?php echo e($driver->nameDriver); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['bulkDriverId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->




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
                                <span>الدفع المحدد</span>
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

                        <!-- Change Driver Button -->
                        <button class="btn btn-outline-primary" wire:click="openBulkDriverModal"
                            <?php if(count($selectedInvoices) === 0): echo 'disabled'; endif; ?>>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-tie me-2"></i>
                                <span>تغيير السائق للمحدد</span>
                            </div>
                        </button>
                        <button wire:click="printdriver" wire:loading.attr="disabled" class="btn btn-outline-primary"
                            <?php if(empty($selected_driver)): echo 'disabled'; endif; ?>>
                            <span wire:loading.remove wire:target="printdriver">
                                <i class="fas fa-print me-2"></i>
                                طباعة حسب السائق
                                <!--[if BLOCK]><![endif]--><?php if(!empty($invoicesCount)): ?>
                                    (<?php echo e($invoicesCount); ?>)
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                        <th class="text-center align-middle">الفاتورة</th>
                        <th class="text-center align-middle">السائق</th>
                        <th class="text-center align-middle">العنوان</th>
                        <th class="text-center align-middle">الجوال</th>
                        <th class="text-center align-middle">التوصيل</th>
                        <th class="text-center align-middle">الإجمالي</th>
                        <th class="text-center align-middle">التاريخ</th>
                        <th class="text-center align-middle">الدفع</th>
                        <th class="text-center align-middle">طلب من</th>
                        <th class="text-center align-middle">بائع</th>
                        <th class="text-center align-middle pe-3">خيارات</th>
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


                            <td class="text-center align-middle"width="30px">
                                <!--[if BLOCK]><![endif]--><?php if($invoice->customer?->waypayment): ?>
                                    <div class="modern-chip">
                                        <span class="chip-icon bg-success"></span>
                                        <span class="chip-text"><?php echo e($invoice->customer->waypayment); ?></span>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>

                            <td class="text-center align-middle" width="30px">
                                <!--[if BLOCK]><![endif]--><?php if($invoice->customer?->buywith): ?>
                                    <div class="modern-chip">
                                        <span class="chip-icon bg-primary"></span>
                                        <span class="chip-text"><?php echo e($invoice->customer->buywith); ?></span>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>



                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    <?php echo e($invoice->sell?->user); ?>

                                </div>
                            </td>
                            
                            <td class="text-center">
                                <div class="dropstart">
                                    <button class="btn btn-outline-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="Invoice actions">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow p-2"
                                        style="width: auto; white-space: nowrap; margin-right: 10px;">
                                        <li class="d-inline-block">
                                            <button type="button" class="btn btn-outline-primary mx-1"
                                                title="طباعة" onclick="printInvoice(<?php echo e($invoice->id); ?>)">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        </li>
                                        <li class="d-inline-block">
                                            <button class="btn btn-outline-success mx-1" data-bs-toggle="modal"
                                                data-bs-target="#addinvoiceproduct"
                                                wire:click="numinvoice(<?php echo e($invoice->num_invoice_sell); ?>)"
                                                title="إضافة منتجات">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </li>
                                        <li class="d-inline-block">
                                            <button class="btn btn-outline-dark mx-1"
                                                wire:click="payment(<?php echo e($invoice->id); ?>)" title="تم الدفع">
                                                <i class="fas fa-dollar-sign"></i>
                                            </button>
                                        </li>
                                        <li class="d-inline-block">
                                            <button class="btn btn-outline-warning mx-1" data-bs-toggle="modal"
                                                data-bs-target="#EditInvoice"
                                                wire:click="numinvoice(<?php echo e($invoice->num_invoice_sell); ?>)"
                                                title="تعديل الفاتورة">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </li>
                                        <li class="d-inline-block">
                                            <button class="btn btn-outline-info mx-1"
                                                wire:click="openDriverModal(<?php echo e($invoice->id); ?>)"
                                                data-bs-toggle="modal" data-bs-target="#editDriverModal"
                                                title="تعديل السائق">
                                                <i class="fas fa-user-edit"></i>
                                            </button>
                                        </li>
                                        <li class="d-inline-block">
                                            <button class="btn btn-outline-danger mx-1"
                                                wire:click.prevent="$dispatch('confirmDelete', { id: <?php echo e($invoice->id); ?> })"
                                                title="حذف الفاتورة">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                <i class="fas fa-file-invoice fa-3x opacity-25 mb-3"></i>
                                <h5 class="fw-light">لا توجد فواتير لعرضها</h5>
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bulk Date Edit Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showBulkDateModal): ?>
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Edit Driver Modal -->
    <div wire:ignore.self class="modal fade" id="editDriverModal" tabindex="-1"
        aria-labelledby="editDriverModalLabel" aria-hidden="true">
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
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->id); ?>"><?php echo e($driver->nameDriver); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['selectedDriverId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
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
    </script>

    
    <style>
        .modern-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            /* full pill */
            background-color: #f8f9fa;
            /* light neutral background */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            font-size: 0.875rem;
            font-weight: 500;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        /* Hover effect */
        .modern-chip:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            cursor: default;
        }

        /* Icon circle */
        .chip-icon {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        /* Colors for different chips */
        .chip-icon.bg-success {
            background-color: #28a745;
        }

        .chip-icon.bg-primary {
            background-color: #0d6efd;
        }

        /* Text inside chip */
        .chip-text {
            color: #212529;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <?php
        $__scriptKey = '3667539297-0';
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
        $__scriptKey = '3667539297-1';
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
        $__scriptKey = '3667539297-2';
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
                        $wire.call('customer-sold-today');
                    }
                });
            });
        </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/drivers/invoice-controls/show.blade.php ENDPATH**/ ?>