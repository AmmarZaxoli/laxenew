<div class="content-container" style="position: relative; padding-top: 70px;">
    <!-- Button fixed at the top-center -->
    <button wire:click="toggleModal" class="btn position-fixed"
        style="
            width: 160px;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            background: linear-gradient(to right, #6366f1 0%, #4f46e5 100%);
            border: none;
            border-radius: 25px;
            padding: 6px 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            color: white;
            font-weight: 400;
            transition: all 0.3s ease;
        "
        onmouseover="this.style.transform='translateX(-50%) scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(0, 0, 0, 0.2)'"
        onmouseout="this.style.transform='translateX(-50%)'; this.style.boxShadow='0 4px 15px rgba(0, 0, 0, 0.1)'">
        <i class="fas fa-clipboard-check me-2"></i>
        <span>طلبات السوائق</span>
    </button>

    <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5); z-index:1050;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">عدد الطلبات لكل سائق</h5>
                        <button type="button" class="btn-close" wire:click="toggleModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="createdAt" class="form-label">من تاريخ</label>
                                <input type="date" wire:model="createdAt" id="createdAt"
                                    class="form-control <?php $__errorArgs = ['createdAt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['createdAt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="col-md-6">
                                <label for="updatedAt" class="form-label">إلى تاريخ</label>
                                <input type="date" wire:model="updatedAt" id="updatedAt"
                                    class="form-control <?php $__errorArgs = ['updatedAt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['updatedAt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="col-12 mt-3">
                                <button type="button" class="btn btn-outline-primary py-2 px-4 shadow-sm"
                                    wire:loading.attr="disabled" style="margin-top: 5px"
                                    wire:target="filterByDate" wire:click="filterByDate">
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

                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['dateFilter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger mb-3"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                        <div class="table-responsive">
                            <!-- ✅ Total Orders -->
                            <div class="mb-3">
                                <strong>مجموع عدد الطلبات: </strong> <?php echo e($totalOrders); ?>

                            </div>

                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr style="text-align: center;">
                                        <th>اسم السائق</th>
                                        <th>عدد الطلبات</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr style="text-align: center;">
                                            <td><?php echo e($driver->nameDriver); ?></td>
                                            <td><?php echo e($driver->orders_count); ?></td>
                                            <td>
                                                <?php echo e(optional($driver->customers->first())->date_sell
                                                    ? \Carbon\Carbon::parse($driver->customers->first()->date_sell)->format('Y-m-d')
                                                    : 'N/A'); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <!--[if BLOCK]><![endif]--><?php if($createdAt || $updatedAt): ?>
                                                    لا توجد بيانات في الفترة المحددة
                                                <?php else: ?>
                                                    لا توجد بيانات اليوم
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </td>
                                        </tr>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="toggleModal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\Users\user\Desktop\laxe8-10 (4)\resources\views/livewire/drivers/drivers-order.blade.php ENDPATH**/ ?>