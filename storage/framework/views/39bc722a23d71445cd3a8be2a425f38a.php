<div>
    <div class="container-fluid p-0">
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row g-3 mb-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label small text-muted mb-1">بحث</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" wire:model.live="search" class="form-control" id="search"
                            placeholder="ابحث بالاسم أو الكود..." autocomplete="off">
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="selected_type" class="form-label small text-muted mb-1">تصفية حسب النوع</label>
                    <select class="form-control" wire:model.live="selected_type" id="selected_type">
                        <option value="">جميع الأنواع</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->typename); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                <div class="col-md-1">
                    <label for="count" class="form-label small text-muted mb-1">عدد العناصر</label>
                    <select class="form-control" wire:model.live="count" id="count">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>


                <style>
                    .btn {
                        border-radius: 8px;
                        padding: 10px 20px;
                        font-weight: 500;
                        transition: var(--transition);
                    }

                    .btn-primary {
                        background-color: var(--primary);
                        border-color: var(--primary);
                    }

                    .btn-primary:hover {
                        background-color: var(--secondary);
                        border-color: var(--secondary);
                        transform: translateY(-2px);
                    }

                    .btn-outline-primary:hover {
                        background-color: var(--primary);
                        color: white;
                        transform: translateY(-2px);
                    }

                    .btn-outline-secondary:hover {
                        color: white;
                        transform: translateY(-2px);
                    }
                </style>
                <!-- Batch Actions Section (Visible when rows are selected) -->
                <!--[if BLOCK]><![endif]--><?php if(count($selectedRows) > 0): ?>
                    <div class="col-md-5">
                        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded">
                            <span class="small text-muted"><?php echo e(count($selectedRows)); ?> عنصر محدد</span>

                            <div class="ms-auto d-flex gap-2">
                                <!-- Button to open the batch update modal -->
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#batchUpdateTypeModal">
                                    <i class="fas fa-check-circle me-1"></i> تحديث النوع للمحدد
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" wire:click="$set('selectedRows', [])">
                                    <i class="fas fa-times me-1"></i> إلغاء التحديد
                                </button>
                            </div>
                        </div>

                        <!-- Current Selection Info -->
                        <!--[if BLOCK]><![endif]--><?php if($currentSelectedType): ?>
                            <div class="mt-2 p-2 bg-info bg-opacity-10 rounded">
                                <small class="text-info">
                                    <i class="fas fa-info-circle me-1"></i>
                                    العناصر المحددة كلها من نوع:
                                    <strong><?php echo e($types->where('id', $currentSelectedType)->first()->typename ?? 'غير محدد'); ?></strong>
                                </small>
                            </div>
                        <?php elseif(count($selectedRows) > 1): ?>
                            <div class="mt-2 p-2 bg-warning bg-opacity-10 rounded">
                                <small class="text-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    العناصر المحددة تحتوي على أكثر من نوع
                                </small>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- Same Type Filter Indicator -->
            <!--[if BLOCK]><![endif]--><?php if($showSameTypeOnly && $currentSelectedType): ?>
                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-filter me-2"></i>
                        <span>
                            جاري عرض العناصر من نوع
                            <strong>"<?php echo e($types->where('id', $currentSelectedType)->first()->typename ?? 'غير محدد'); ?>"</strong>
                            فقط
                        </span>
                        <button type="button" class="btn-close ms-auto" wire:click="showAllTypes"></button>
                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!-- Table Section -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="40" class="text-center">
                            </th>
                            <th width="40" class="text-center">#</th>
                            <th class="text-center">الاسم</th>
                            <th class="text-center" width="100">الكود</th>
                            <th class="text-center" width="180">الباركود</th>
                            <th class="text-center" width="240">النوع</th>
                            <th width="250" class="text-center">صورة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $definitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $definition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="align-middle" style="cursor: pointer;"
                                wire:key="definition-<?php echo e($definition->id); ?>">
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRows"
                                            value="<?php echo e($definition->id); ?>" id="row-<?php echo e($definition->id); ?>">
                                        <label class="form-check-label" for="row-<?php echo e($definition->id); ?>"></label>
                                    </div>
                                </td>
                                <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                <td class="fw-medium"><?php echo e($definition->name); ?></td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success fs-6">
                                        <?php echo e($definition->code); ?>

                                    </span>
                                </td>
                                <td class="text-center"><?php echo e($definition->barcode); ?></td>
                                <td class="text-center">
                                    <span class="text-center">
                                        <?php echo e($definition->type->typename ?? 'غير محدد'); ?>

                                    </span>
                                </td>


                                <td class="text-center">
                                    <!--[if BLOCK]><![endif]--><?php if($definition->image && file_exists(public_path('storage/' . $definition->image))): ?>
                                        <img src="<?php echo e(asset('storage/' . $definition->image)); ?>" width="40"
                                            height="40" class="rounded-circle object-fit-cover border"
                                            data-bs-toggle="modal" data-bs-target="#imageModal<?php echo e($definition->id); ?>"
                                            style="cursor: pointer;" alt="صورة المنتج">
                                    <?php else: ?>
                                        <span class="text-muted small">لا يوجد</span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                            </tr>

                            <!-- Image Modal -->
                            <!--[if BLOCK]><![endif]--><?php if($definition->image && file_exists(public_path('storage/' . $definition->image))): ?>
                                <div class="modal fade" id="imageModal<?php echo e($definition->id); ?>" tabindex="-1"
                                    aria-labelledby="imageModalLabel<?php echo e($definition->id); ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">صورة <?php echo e($definition->name); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="إغلاق"></button>
                                            </div>
                                            <div class="modal-body text-center p-0">
                                                <img src="<?php echo e(asset('storage/' . $definition->image)); ?>"
                                                    class="img-fluid rounded" alt="صورة المنتج">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!-- Edit Modal -->
                            <div class="modal fade" id="Edit<?php echo e($definition->id); ?>" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="editModalLabel<?php echo e($definition->id); ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">تعديل التعريف</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('definitions.edit', ['definitionId' => $definition->id,'definition_id' => $definition->id]);

$__html = app('livewire')->mount($__name, $__params, 'definition-edit-' . $definition->id, $__slots ?? [], get_defined_vars());

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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                        <span class="text-muted">لا توجد تعريفات متاحة</span>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>

                <!-- Pagination -->
                <?php echo e($definitions->links()); ?>

            </div>
        </div>
    </div>

    <!-- Batch Update Type Modal -->
    <div class="modal fade" id="batchUpdateTypeModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="batchUpdateTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="batchUpdateTypeModalLabel">تحديث النوع للمحدد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p class="text-muted small">
                            سيتم تحديث النوع لـ <strong><?php echo e(count($selectedRows)); ?></strong> عنصر محدد
                        </p>

                        <!-- Show current common type if exists -->
                        <!--[if BLOCK]><![endif]--><?php if($currentSelectedType): ?>
                            <div class="alert alert-info py-2">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    النوع الحالي:
                                    <strong><?php echo e($types->where('id', $currentSelectedType)->first()->typename ?? 'غير محدد'); ?></strong>
                                </small>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="col-md-12">
                        <label for="batch_type" class="form-label small text-muted mb-1">اختر النوع الجديد</label>
                        <select class="form-control" wire:model="batchType" id="batch_type">
                            <option value="">اختر النوع</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>"><?php echo e($type->typename); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['batchType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger small"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-outline-primary" wire:click="updateSelectedType"
                        wire:loading.attr="disabled" data-bs-dismiss="modal">
                        <span wire:loading.remove>تحديث النوع</span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin me-1"></i> جاري التحديث...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong class="me-auto">نجاح</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <?php echo e(session('message')); ?>

                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <?php if(session()->has('error')): ?>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong class="me-auto">خطأ</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <?php echo e(session('error')); ?>

                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Auto-hide toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => {
                    const bsToast = new bootstrap.Toast(toast);
                    bsToast.hide();
                }, 5000);
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/changetypeitem/show.blade.php ENDPATH**/ ?>