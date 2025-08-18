<div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="d-none border-end">ID</th>
                    <th class="font-weight-bold border-end text-center">#</th>
                    <th class="font-weight-bold border-end">اسم</th>
                    <th class="font-weight-bold border-end">الهاتف</th>
                    <th class="font-weight-bold border-end">رقم السيارة</th>
                    <th class="font-weight-bold border-end">سعر التوصيل</th>
                    <th class="font-weight-bold border-end">عنوان</th>
                    <th class="text-center" style="width: 10%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
                <?php $__empty_1 = true; $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="align-middle" style="height: 42px;">
                        <td class="d-none border-end"><?php echo e($driver->id); ?></td>
                        <td class="font-weight-medium border-end text-center" style="width:5%">
                            <?php echo e($count++); ?>

                        </td>
                        <td class="font-weight-medium border-end"><?php echo e($driver->nameDriver); ?></td>
                        <td class="font-weight-medium border-end" style="width: 10%"><?php echo e($driver->mobile); ?></td>
                        <td class="font-weight-medium border-end"><?php echo e($driver->numcar); ?></td>
                        <td class="font-weight-medium border-end"><?php echo e(number_format($driver->taxiprice)); ?></td>
                        <td class="font-weight-medium border-end"><?php echo e($driver->address); ?></td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Edit Button - Now targets the correct modal -->
                                <button data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($driver->id); ?>"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center py-1">
                                    <i class="fas fa-edit me-1" style="font-size: 1.2rem;"></i>
                                 </button>

                                
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-3 text-muted">
                            <i class="fas fa-info-circle me-2"></i> لا توجد أنواع متاحة
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php echo e($drivers->links('pagination::bootstrap-5')); ?>

    </div>

    <!-- Modals placed outside the table -->
    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="editModal<?php echo e($driver->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="editModalLabel<?php echo e($driver->id); ?>" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="padding: 10px">
                    <div class="modal-header" class="card-header text-black py-3">
                        <h4 class="modal-title">تعديل الحساب</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('drivers.edit', ['driverId' => $driver->id]);

$__html = app('livewire')->mount($__name, $__params, $driver->id, $__slots ?? [], get_defined_vars());

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
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</div>
<?php /**PATH C:\Users\user\Desktop\laxe8-18\resources\views\livewire\drivers\show.blade.php ENDPATH**/ ?>