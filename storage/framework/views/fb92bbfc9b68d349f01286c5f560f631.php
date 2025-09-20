<div>
    <div class="table-responsive" style="border-radius: 10px; background-color:white; padding: 20px">
        <!-- Filters Section -->
        <div class="d-flex justify-content-between mb-3 flex-wrap">

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
                    <th class="font-weight-bold border-end text-center">#</th>
                    <th class="font-weight-bold border-end">الاسم</th>
                    <th class="font-weight-bold border-end"> رقم السر</th>
                    <th class="font-weight-bold border-end"> رول </th>
                    <th class="text-center" style="width: 10%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php if($showResults): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="align-middle text-center" style="width: 42px;"><?php echo e($loop->iteration); ?></td>
                            <td class="font-weight-medium border-end"><?php echo e($account->name); ?></td>
                            <td class="font-weight-medium border-end"><?php echo e($account->password); ?></td>
                            <td class="font-weight-medium border-end"><?php echo e($account->role); ?></td>


                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button (opens modal) -->
                                    <button class="btn btn-sm btn-outline-primary d-flex align-items-center py-1"
                                        data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($account->id); ?>">
                                        <i class="fas fa-edit me-1" style="font-size: 1.2rem;"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <!-- Delete Button -->
                                    <button wire:click="$dispatch('confirm', { id: <?php echo e($account->id); ?> })"
                                        class="btn btn-sm btn-outline-danger d-flex align-items-center py-1">
                                        <i class="fas fa-trash-alt mr-1" style="font-size: 1.2rem;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo e($account->id); ?>" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel<?php echo e($account->id); ?>"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="padding: 10px">
                                    <div class="modal-header" class="card-header  text-black py-3"
                                        style="background-color: rgb(231, 231, 231)">
                                        <h4 class="modal-title">تعديل الحساب</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('accounts.edit', ['accountid' => $account->id]);

$__html = app('livewire')->mount($__name, $__params, $account->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?> </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">لا توجد نتائج مطابقة</td>
                        </tr>
                    <?php endif; ?>
                <?php else: ?>
                <?php endif; ?>
            </tbody>

        </table>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <?php
        $__scriptKey = '2539168922-0';
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
                <?php echo e($accounts->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\user\Desktop\laxe8-10 (7)\resources\views\livewire\accounts\show.blade.php ENDPATH**/ ?>