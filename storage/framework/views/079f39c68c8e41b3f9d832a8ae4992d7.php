<div>
    <div class="table-responsive" style="border-radius: 10px; background-color:white; padding: 20px">
        <!-- Filters Section -->
        <div class="d-flex justify-content-between mb-3 flex-wrap">
            <div class="d-flex gap-2 flex-wrap align-items-center">

                <!-- Search by name -->
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" wire:model.live.debounce.200ms="searchName" class="form-control shadow-sm"
                        placeholder="بحث بالاسم" autocomplete="off">
                </div>

                <!-- Start Date -->
                <div class="input-group" style="width: 200px;">
                    <span class="input-group-text"><i class="fas fa-calendar"></i> </span>
                    <input type="date" wire:model="createdAt" autocomplete="off" wire:change="$refresh"
                        class="form-control shadow-sm">
                </div>

                <!-- End Date -->
                <label for="priceInput" class="form-label"> إلى : </label>
                <div class="input-group" style="width: 200px;">

                    <span class="input-group-text"><i class="fas fa-calendar"></i> </span>
                    <input type="date" wire:model="updatedAt" wire:change="$refresh" class="form-control shadow-sm">
                </div>

                <!-- Load data button -->
                <button wire:click="loadExpenses" style="margin-top: 5px" class="btn btn-outline-primary"
                    <?php if(!$canLoadData): ?> disabled <?php endif; ?>>
                    <i class="fas fa-search"></i> عرض البيانات
                </button>


                <!-- Reset button -->
                <button wire:click="resetSearch" class="btn btn-outline-secondary" style="margin-top: 5px">
                    <i class="fas fa-undo"></i> إعادة تعيين
                </button>


            </div>
        </div>

        <!-- Flash Messages -->
        <?php if(session()->has('message')): ?>
            <div class="alert alert-success my-2"><?php echo e(session('message')); ?></div>
        <?php endif; ?>
        <?php if(session()->has('error')): ?>
            <div class="alert alert-danger my-2"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        <?php if($errorMessage): ?>
            <div class="alert alert-danger my-2"><?php echo e($errorMessage); ?></div>
        <?php endif; ?>
        <?php if($successMessage): ?>
            <div class="alert alert-success my-2"><?php echo e($successMessage); ?></div>
        <?php endif; ?>

        <!-- Table -->
        <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">#</th>
                    <th>الاسم</th>
                    <th class="text-center">ثمن المصروف</th>
                    <th>وصف المصروف</th>
                    <th class="text-center">تاريخ الإنشاء</th>
                    <th class="text-center">تاريخ التحديث</th>
                    <th class="text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php if($showResults): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($expense->name); ?></td>
                            <td class="text-center"><?php echo e(number_format($expense->price, 2)); ?></td>
                            <td><?php echo e($expense->namething); ?></td>
                            <td class="text-center"><?php echo e($expense->created_at->format('Y-m-d')); ?></td>
                            <td class="text-center"><?php echo e($expense->updated_at->format('Y-m-d')); ?></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button (opens modal) -->
                                 

                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal<?php echo e($expense->id); ?>"
                                         class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>


                                    <!-- Delete Button -->
                                    <button wire:click="$dispatch('confirm', { id: <?php echo e($expense->id); ?> })"
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
                            <td colspan="7" class="text-center text-muted py-4">لا توجد نتائج مطابقة</td>
                        </tr>
                    <?php endif; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">الرجاء تحديد التاريخ ثم الضغط على عرض
                            البيانات
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
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
                </div>
            <?php endif; ?>
        </table>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <?php
        $__scriptKey = '2147256975-0';
        ob_start();
    ?>
            <script>
                $wire.on("confirm", (event) => {
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
                            $wire.dispatch("delete", {
                                id: event.id
                            });
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
            <div class=" justify-content-end ">
                <?php echo e($expenses->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\PC\Desktop\New folder (6)\laxe8-12\resources\views\livewire\expenses\show.blade.php ENDPATH**/ ?>