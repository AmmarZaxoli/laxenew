<div>
    <div class="table-responsive" style="border-radius: 10px; background-color:white; padding: 20px">
        <!-- Filters Section -->
        <div class="d-flex justify-content-between mb-3 flex-wrap">
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <!-- Bulk actions when items are selected -->
                <?php if(count($selectedExpenses) > 0): ?>
                <div class="d-flex align-items-center gap-2 me-3 p-2 bg-light rounded">
                    <span class="text-primary fw-bold"><?php echo e(count($selectedExpenses)); ?> عنصر محدد</span>
                    <button wire:click="openBulkModal" class="btn btn-sm btn-primary">
                        <i class="fas fa-calendar-alt"></i> تغيير التاريخ
                    </button>
                    <button wire:click="$set('selectedExpenses', [])" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times"></i> إلغاء
                    </button>
                </div>
                <?php endif; ?>

                <!-- Search by name -->
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" wire:model.live.debounce.200ms="searchName" class="form-control shadow-sm"
                        placeholder="بحث بالاسم" autocomplete="off">
                </div>

                <!-- Start Date -->
                <div class="input-group" style="width: 200px;">
                    <span class="input-group-text"><i class="fas fa-calendar"></i> </span>
                    <input type="date" wire:model="createdAt" autocomplete="off" class="form-control shadow-sm">
                </div>

                <!-- End Date -->
                <label for="priceInput" class="form-label"> إلى : </label>
                <div class="input-group" style="width: 200px;">
                    <span class="input-group-text"><i class="fas fa-calendar"></i> </span>
                    <input type="date" wire:model="createdAt1" class="form-control shadow-sm">
                </div>

                <!-- Load data button -->
                <button wire:click="getdatabtdate" style="margin-top: 5px" class="btn btn-outline-primary"
                    <?php if(!$showResults): ?> disabled <?php endif; ?> wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-search"></i> عرض البيانات
                    </span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري
                        التحميل...
                    </span>
                </button>

                <!-- Reset button -->
                <button wire:click="resetSearch" class="btn btn-outline-secondary" style="margin-top: 5px">
                    <i class="fas fa-undo"></i> إعادة تعيين
                </button>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" width="50">
                        <input type="checkbox" wire:model.live="selectAll">
                    </th>
                    <th class="text-center">#</th>
                    <th>الاسم</th>
                    <th class="text-center">ثمن المصروف</th>
                    <th>وصف المصروف</th>
                    <th class="text-center">تاريخ الإنشاء</th>
                    <th class="text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php if($showResults): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="<?php if(in_array($expense->id, $selectedExpenses)): ?> table-active <?php endif; ?>">
                            <td class="text-center">
                                <input type="checkbox" 
                                    wire:model.live="selectedExpenses" 
                                    value="<?php echo e($expense->id); ?>">
                            </td>
                            <td class="text-center"><?php echo e($loop->iteration + ($expenses->currentPage() - 1) * $expenses->perPage()); ?></td>
                            <td><?php echo e($expense->name); ?></td>
                            <td class="text-center"><?php echo e(number_format($expense->price)); ?></td>
                            <td><?php echo e($expense->namething); ?></td>
                            <td class="text-center"><?php echo e($expense->created_at->format('Y-m-d')); ?></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button (opens modal) -->
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal<?php echo e($expense->id); ?>"
                                        class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <button wire:click="$dispatch('confirmDelete', { id: <?php echo e($expense->id); ?> })"
                                        class="btn btn-sm btn-icon btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo e($expense->id); ?>" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel<?php echo e($expense->id); ?>"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="padding: 10px">
                                    <div class="modal-header" class="card-header  text-black py-3"
                                        style="background-color: rgb(231, 231, 231)">
                                        <h4 class="modal-title">تعديل المصروف</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('expenses.edit', ['expenseId' => $expense->id]);

$__html = app('livewire')->mount($__name, $__params, $expense->id, $__slots ?? [], get_defined_vars());

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
                            <td colspan="8" class="text-center text-muted py-4">لا توجد نتائج مطابقة</td>
                        </tr>
                    <?php endif; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">الرجاء تحديد التاريخ ثم الضغط على عرض
                            البيانات
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if($showResults): ?>
            <div class="d-flex gap-3 flex-wrap mt-2">
                <div class="alert alert-info text-center" style="min-width: 200px;">
                    <strong>إجمالي المصروفات:</strong><br>
                    <?php echo e(number_format($totalPrice)); ?>

                </div>

                <?php if($searchName): ?>
                    <div class="alert alert-secondary text-center" style="min-width: 200px;">
                        <strong>إجمالي نتائج البحث:</strong><br>
                        <?php echo e(number_format($searchTotalPrice)); ?>

                    </div>
                <?php endif; ?>
                
                <?php if(count($selectedExpenses) > 0): ?>
                    <div class="alert alert-warning text-center" style="min-width: 200px;">
                        <strong>العناصر المحددة:</strong><br>
                        <?php echo e(count($selectedExpenses)); ?> عنصر
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Bulk Update Modal -->
        <?php if($showBulkModal): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تغيير تاريخ العناصر المحددة</h5>
                        <button type="button" class="btn-close" wire:click="closeBulkModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulkDate" class="form-label">التاريخ الجديد</label>
                            <input type="date" class="form-control" id="bulkDate" wire:model="bulkDate">
                        </div>
                        <p class="text-muted">سيتم تغيير تاريخ <?php echo e(count($selectedExpenses)); ?> عنصر</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeBulkModal">إلغاء</button>
                        <button type="button" class="btn btn-primary" wire:click="updateBulkDates">تطبيق</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <?php
        $__scriptKey = '1541024197-0';
        ob_start();
    ?>
            <script>
                // Listen for delete confirmation
                $wire.on('confirmDelete', (event) => {
                    Swal.fire({
                        title: "تأكيد الحذف",
                        text: "هل أنت متأكد من رغبتك في حذف هذا العنصر؟ لا يمكن التراجع عن هذه العملية.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "نعم، احذف!",
                        cancelButtonText: "إلغاء",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $wire.delete(event.id);
                        }
                    });
                });

                // Show success message after actions
                $wire.on("showSuccessMessage", (message) => {
                    Toast.fire({
                        icon: 'success',
                        title: message
                    });
                });
                
                // Show error message
                $wire.on("showErrorMessage", (message) => {
                    Toast.fire({
                        icon: 'error',
                        title: message
                    });
                });

                // Initialize Toast
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            </script>
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>

        <!-- Pagination -->
        <?php if($showResults): ?>
            <div class="justify-content-end">
                <?php echo e($expenses->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\expenses\show.blade.php ENDPATH**/ ?>