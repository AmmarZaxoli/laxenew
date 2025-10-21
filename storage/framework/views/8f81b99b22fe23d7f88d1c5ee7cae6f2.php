<div>
    <div class="row">
        <!-- Driver Select -->
        <div class="col-md-3 mb-3">
            <label for="username" class="form-label">اسم السائق</label>
            <select id="username" class="form-control" wire:model="username">
                <option value="">اختر السائق</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $usernames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $username): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($username->name); ?>"><?php echo e($username->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="text-danger"><?php echo e($message); ?></small>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Payment -->
        <div class="col-md-3 mb-3">
            <label for="payment" class="form-label">المبلغ</label>
            <input type="number" id="payment" class="form-control" wire:model="payment">
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['payment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="text-danger"><?php echo e($message); ?></small>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Date -->
        <div class="col-md-3 mb-3">
            <label for="date" class="form-label">التاريخ والوقت</label>
            <input type="datetime-local" id="date" class="form-control" wire:model="date">
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="text-danger"><?php echo e($message); ?></small>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Save Button -->
        <div class="col-md-3 d-flex align-items-end mb-3" style="margin-top: 47px">
            <button class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center"
                wire:click="save" wire:loading.attr="disabled" type="button">

                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2" role="status"
                    aria-hidden="true"></span>


                <i class="fas fa-plus-circle me-2"></i> دفع
            </button>
        </div>

    </div>

    <style>
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: #fff;
            transform: translateY(-2px);
            border: none;
        }
    </style>

    <div class="row">
        <!-- From Date -->
        <div class="col-md-3 mb-3">
            <label for="date_from" class="form-label">من تاريخ</label>
            <input type="date" id="date_from" class="form-control" wire:model="date_from">
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['date_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="text-danger"><?php echo e($message); ?></small>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- To Date -->
        <div class="col-md-3 mb-3">
            <label for="date_to" class="form-label">إلى تاريخ</label>
            <input type="date" id="date_to" class="form-control" wire:model="date_to">
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['date_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="text-danger"><?php echo e($message); ?></small>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Filter Button -->
        <div class="col-md-3 d-flex align-items-end mb-3" style="margin-top: 47px">
            <button class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center"
                wire:click="filterPayments" wire:loading.attr="disabled" type="button">


                <span wire:loading wire:target="filterPayments" class="spinner-border spinner-border-sm me-2"
                    role="status" aria-hidden="true"></span>


                <i class="fas fa-search me-2"></i> عرض
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th width="40" class="text-center">#</th>
                    <th class="text-center">اسم المستخدم</th>
                    <th class="text-center" width="100">المبلغ</th>
                    <th class="text-center" width="180">التاريخ</th>
                    <th class="text-center">المسؤول</th>
                    <th width="250" class="text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $userpayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="align-middle">
                        <td class="text-center"><?php echo e($loop->iteration); ?></td>
                        <td class="fw-medium text-center"><?php echo e($payment->nameuser); ?></td>
                        <td class="text-center">
                            <span class="badge bg-success bg-opacity-10 text-success fs-6">
                                <?php echo e(number_format($payment->payment)); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <?php echo e(\Carbon\Carbon::parse($payment->date)->format('Y-m-d')); ?>

                        </td>


                        <td class="text-center"><?php echo e($payment->admin); ?></td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Delete Button -->
                                <button wire:click="$dispatch('confirmDelete', { id: <?php echo e($payment->id); ?> })"
                                    class="btn btn-sm btn-icon btn-outline-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                <span class="text-muted">لا توجد بيانات دفع متاحة</span>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>

        <!-- Pagination -->
        
    </div>
        <?php
        $__scriptKey = '2111740549-0';
        ob_start();
    ?>
        <script>
            $wire.on('confirmDelete', (event) => {
                Swal.fire({
                    title: "تأكيد الحذف",
                    text: "هل أنت متأكد من رغبتك في حذف هذا العنصر ؟ ",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "نعم",
                    cancelButtonText: "إلغاء",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.delete(event.id);
                    }
                });
            });
        </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/userpayment/show.blade.php ENDPATH**/ ?>