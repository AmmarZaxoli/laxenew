<div>
    <div class="card body formtype">
        <input type="text" wire:model.live="search" class="form-control mb-3" placeholder="ابحث...">

        <div class="table-responsive">
            <table class="table table-hover">
                <?php
                    $count = 1;
                ?>
                <thead class="thead-light">
                    <tr>
                        <th class="d-none border-end">ID</th>
                        <th class="font-weight-bold  border-end">#</th>
                        <th class="font-weight-bold  border-end">أنواع</th>
                        <th class="text-center" style="width: 25%">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="align-middle" style="height: 42px;">
                            <td class="d-none border-end"><?php echo e($type->id); ?></td>
                            <td class="font-weight-medium border-end" style="text-align: center;width:5%">
                                <?php echo e($count++); ?>

                            </td>
                            <td class="font-weight-medium border-end"><?php echo e($type->typename); ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button data-bs-toggle="modal" data-bs-target="#Edit<?php echo e($type->id); ?>"
                                        class="btn btn-sm btn-outline-primary d-flex align-items-center py-1">
                                        <i class="fas fa-edit mr-1"></i> تعديل
                                    </button>



                                    


                                </div>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="Edit<?php echo e($type->id); ?>" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="padding: 10px">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="staticBackdropLabel">تعديل نوع</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('types.edit', ['typeId' => $type->id,'type_id' => $type->id]);

$__html = app('livewire')->mount($__name, $__params, 'type-edit-' . $type->id, $__slots ?? [], get_defined_vars());

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
                            <td colspan="3" class="text-center py-3 text-muted">
                                <i class="fas fa-info-circle mr-2"></i> لا توجد أنواع متاحة
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
            <?php echo e($types->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
        $__scriptKey = '1268641596-0';
        ob_start();
    ?>
    <script>
        $wire.on("confirm", (event) => {

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
                    $wire.dispatch("delete", {
                        id: event.id
                    });
                }
            });

        });
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH C:\Users\DELL\Desktop\laxe8-10\resources\views/livewire/types/show.blade.php ENDPATH**/ ?>