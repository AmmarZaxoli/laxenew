<div x-data>
    <div class="row mb-3">
        <!-- Customer Information Card -->
        <div class="card h-100 shadow-sm border-0">

            <div class="card-body">
                <div class="text-center mb-3">
                    <h4 class="text-primary">الفاتورة #: <?php echo e($num_invoice); ?></h4>
                </div>

                <div class="row g-3">
                    <!-- Mobile Input -->
                    <div class="col-md-3">
                        <label for="mobileInput" class="form-label fw-semibold">الجوال</label>
                        <div class="input-group">
                            <input type="text" id="mobileInput" wire:model.live="mobile" class="form-control"
                                autocomplete="off" placeholder="أدخل رقم الجوال">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-mobile-alt"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Address Input -->
                    <div class="col-md-3">
                        <label for="address" class="form-label fw-semibold">العنوان</label>
                        <div class="input-group">
                            <input type="text" wire:model="address" class="form-control" placeholder="أدخل العنوان">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Taxi Price Input -->
                    <div class="col-md-3">
                        <label for="pricetaxi" class="form-label fw-semibold">سعر التاكسي</label>
                        <div class="input-group">
                            <input type="number" id="pricetaxi" name="price" class="form-control"
                                wire:model.live="pricetaxi" min="0" step="1000" placeholder="0">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-taxi"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Note Input -->
                    <div class="col-md-3">
                        <label for="customerNote" class="form-label fw-semibold">ملاحظة</label>
                        <div class="input-group">
                            <input type="text" name="note" id="customerNote" class="form-control"
                                wire:model="note" placeholder="إضافة ملاحظة">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-sticky-note"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Discount Input -->
                    <div class="col-md-3">
                        <label for="customerdiscount" class="form-label fw-semibold">الخصم</label>
                        <div class="input-group">
                            <input type="number" name="discount" id="discount" class="form-control"
                                wire:model.live="discount" placeholder="الخصم">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-percentage"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Products Section -->
    <div class="row g-3">
        <!-- Selected Products Card -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">المنتجات المختارة</h5>
                    <span class="badge bg-primary"><?php echo e(count($gitproducts)); ?> عناصر</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th class="text-center">الكود</th>
                                    <th class="text-center">الكمية</th>
                                    <th class="text-center">السعر</th>
                                    <th class="text-center">المجموع</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $gitproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gitproduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="align-middle">
                                        <td><?php echo e($gitproduct->name); ?></td>
                                        <td class="text-center"><?php echo e($gitproduct->code); ?></td>
                                        <td class="text-center">
                                            <div
                                                class="quantity-control d-flex align-items-center justify-content-center">
                                                <!-- Increment Button -->
                                                <button wire:loading.attr="disabled"
                                                    wire:target="incrementProduct(<?php echo e($gitproduct->product_id); ?>,<?php echo e($gitproduct->price); ?>)"
                                                    wire:click="incrementProduct(<?php echo e($gitproduct->product_id); ?>,<?php echo e($gitproduct->price); ?>)"
                                                    class="btn btn-quantity plus" title="زيادة الكمية">

                                                    <span wire:loading.remove
                                                        wire:target="incrementProduct(<?php echo e($gitproduct->product_id); ?>,<?php echo e($gitproduct->price); ?>)">
                                                        <svg width="12" height="12" viewBox="0 0 12 12"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 1V11M1 6H11" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" />
                                                        </svg>
                                                    </span>

                                                    <span wire:loading
                                                        wire:target="incrementProduct(<?php echo e($gitproduct->product_id); ?>,<?php echo e($gitproduct->price); ?>)">
                                                        <i class="fas fa-spinner fa-spin fa-xs"></i>
                                                    </span>
                                                </button>

                                                <!-- Quantity Display -->
                                                <span class="quantity-value mx-2">
                                                    <?php echo e($gitproduct->quantity); ?>

                                                </span>

                                                <!-- Decrement Button -->
                                                <button wire:loading.attr="disabled"
                                                    wire:target="decrementProduct(<?php echo e($gitproduct->product_id); ?>,<?php echo e($gitproduct->price); ?>)"
                                                    wire:click="decrementProduct(<?php echo e($gitproduct->product_id); ?>,<?php echo e($gitproduct->price); ?>)"
                                                    class="btn btn-quantity minus" <?php if($gitproduct->quantity <= 0): echo 'disabled'; endif; ?>
                                                    title="إنقاص الكمية">

                                                    <span wire:loading.remove
                                                        wire:target="decrementProduct(<?php echo e($gitproduct->product_id); ?>,<?php echo e($gitproduct->price); ?>)">
                                                        <svg width="12" height="2" viewBox="0 0 12 2"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11 1H1" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" />
                                                        </svg>
                                                    </span>

                                                    <span wire:loading
                                                        wire:target="decrementProduct(<?php echo e($gitproduct->product_id); ?>,<?php echo e($gitproduct->price); ?>)">
                                                        <i class="fas fa-spinner fa-spin fa-xs"></i>
                                                    </span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-center"><?php echo e(number_format($gitproduct->price)); ?></td>
                                        <td class="text-center fw-bold">
                                            <?php echo e(number_format($gitproduct->price * $gitproduct->quantity)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <div class="empty-state">
                                                <svg width="48" height="48" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3 5H21M5 5V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V5M8 5V3C8 2.44772 8.44772 2 9 2H15C15.5523 2 16 2.44772 16 3V5"
                                                        stroke="#6C757D" stroke-width="1.5" stroke-linecap="round" />
                                                </svg>
                                                <p class="mt-2 mb-0">لا توجد منتجات مختارة بعد</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offers Card -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">العروض الخاصة</h5>
                    <span class="badge bg-success"><?php echo e(count($gitoffers)); ?> عروض</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم العرض</th>
                                    <th class="text-center">الكود</th>
                                    <th class="text-center">الكمية</th>
                                    <th class="text-center">السعر</th>
                                    <th class="text-center">المجموع</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $gitoffers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gitoffer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>

                                        <td><?php echo e($gitoffer['nameoffer']); ?></td>
                                        <td class="text-center"><?php echo e($gitoffer['code']); ?></td>
                                        <td class="text-center">
                                            <div
                                                class="quantity-control d-flex align-items-center justify-content-center">
                                                <!-- زر زيادة الكمية -->
                                                <button class="btn btn-quantity plus" title="زيادة الكمية"
                                                    wire:click="incrementOffer(<?php echo e($gitoffer['id']); ?>)"
                                                    wire:loading.attr="disabled"
                                                    wire:target="incrementOffer(<?php echo e($gitoffer['id']); ?>)">
                                                    <span wire:loading.remove
                                                        wire:target="incrementOffer(<?php echo e($gitoffer['id']); ?>)">
                                                        <svg width="12" height="12" viewBox="0 0 12 12"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 1V11M1 6H11" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" />
                                                        </svg>
                                                    </span>
                                                    <span wire:loading
                                                        wire:target="incrementOffer(<?php echo e($gitoffer['id']); ?>)">
                                                        <i class="fas fa-spinner fa-spin fa-xs"></i>
                                                    </span>
                                                </button>

                                                <!-- عرض القيمة -->
                                                <span class="quantity-value mx-2"><?php echo e($gitoffer['quantity']); ?></span>

                                                <!-- زر إنقاص الكمية -->
                                                <button class="btn btn-quantity minus" title="إنقاص الكمية"
                                                    wire:click="decrementOffer(<?php echo e($gitoffer['id']); ?>)"
                                                    wire:loading.attr="disabled"
                                                    wire:target="decrementOffer(<?php echo e($gitoffer['id']); ?>)"
                                                    <?php if($gitoffer['quantity'] <= 0): ?> disabled <?php endif; ?>>
                                                    <span wire:loading.remove
                                                        wire:target="decrementOffer(<?php echo e($gitoffer['id']); ?>)">
                                                        <svg width="12" height="2" viewBox="0 0 12 2"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11 1H1" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" />
                                                        </svg>
                                                    </span>
                                                    <span wire:loading
                                                        wire:target="decrementOffer(<?php echo e($gitoffer['id']); ?>)">
                                                        <i class="fas fa-spinner fa-spin fa-xs"></i>
                                                    </span>
                                                </button>
                                            </div>

                                        </td>
                                        <td class="text-center"><?php echo e(number_format($gitoffer['price'])); ?></td>
                                        <td class="text-center fw-bold">
                                            <?php echo e(number_format($gitoffer['quantity'] * $gitoffer['price'])); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-tags fa-2x opacity-50 mb-2"></i>
                                            <p class="mb-0">لا توجد عروض مختارة بعد</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Totals Section -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-uppercase text-muted">إجمالي الخصم:</span>
                        <span class="h4 mb-0 text-danger fw-bold">
                            <?php echo e(number_format((float) str_replace(',', '', $discount ?? 0))); ?>

                            <small class="text-muted fs-6">دينار</small>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="fw-bold text-uppercase text-muted">المبلغ الإجمالي:</span>
                        <span class="h4 mb-0 text-dark fw-bold">
                            <?php echo e(number_format((float) str_replace(',', '', $total_price_invoice) - (float) $discount)); ?>

                            <small class="text-muted fs-6">دينار</small>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Buttons -->
    <div class="modal-footer mt-4 rounded-bottom p-3">
        <button type="submit" class="btn btn-outline-primary" wire:loading.attr="disabled"
            wire:target="EditInvoice" wire:click="EditInvoice">
            <span wire:loading.remove wire:target="EditInvoice">
                <i class="fas fa-save me-2"></i> تحديث الفاتورة
            </span>
            <span wire:loading wire:target="EditInvoice">
                <i class="fas fa-spinner fa-spin me-2"></i> جاري المعالجة...
            </span>
        </button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-2"></i> إلغاء
        </button>
    </div>

    <style>
        /* Rest of your existing styles */
        .card {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        .quantity-control {
            min-width: 120px;
        }

        .btn-quantity {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            padding: 0;
            transition: all 0.2s ease;
            border: 1px solid #E0E0E0;
            background-color: #F8F9FA;
        }
    </style>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\returnproducts\show.blade.php ENDPATH**/ ?>