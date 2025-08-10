<div>
    <div class="container-fluid p-0">
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row g-3 mb-4 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label small text-muted mb-1">بحث</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" wire:model.live="search" class="form-control" id="search"
                            placeholder="ابحث بالاسم أو الكود..." autocomplete="off">
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="selected_type" class="form-label small text-muted mb-1">تصفية حسب النوع</label>
                    <select class="form-select" wire:model.live="selected_type" id="selected_type">
                        <option value="">جميع الأنواع</option>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->typename); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3">

                    <div class="btn-group w-100" role="group" style="height: 35px">
                        <button wire:click="filterActive('active')" type="button"
                            class="btn btn-outline-success btn-sm">
                            <i class="fas fa-check-circle me-1"></i> نشط
                        </button>
                        <button wire:click="filterActive('inactive')" type="button"
                            class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-times-circle me-1"></i> غير نشط
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="40" class="text-center">#</th>
                            <th>الاسم</th>
                            <th class="text-center" width="150">الكود</th>
                            <th class="text-center"width="200">الباركود</th>
                            <th class="text-center" width="200">النوع</th>
                            <th width="100" class="text-center">الحالة</th>
                            <th class="text-center" width="100">الكمية</th>
                            <th width="80" class="text-center">سعر بيع</th>
                            <th width="150" class="text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="align-middle" style="cursor: pointer;"
                                wire:key="definition-<?php echo e($product->definition->id); ?>">
                                <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                <td class="fw-medium"><?php echo e($product->definition->name); ?></td>
                                <td class="text-center"><?php echo e($product->definition->code); ?></td>
                                <td class="text-center"><?php echo e($product->definition->barcode); ?></td>
                                <td class="text-center">
                                    <span class="text-center">
                                        <?php echo e($product->definition->type->typename ?? 'غير محدد'); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if($product->definition->is_active === 'active'): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-check-circle me-1"></i> نشط
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger">
                                            <i class="fas fa-times-circle me-1"></i> غير نشط
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge 
        <?php echo e($product->quantity <=0
            ? 'bg-danger'
            : ($product->quantity > 0 && $product->quantity < 5
                ? 'bg-warning text-dark'
                : 'bg-light text-dark')); ?>">
                                        <?php echo e($product->quantity); ?>

                                    </span>
                                </td>


                                <td class="text-center"><?php echo e(number_format($product->price_sell)); ?></td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button data-bs-toggle="modal"
                                            data-bs-target="#Edit<?php echo e($product->definition->id); ?>"
                                            class="btn btn-sm btn-icon btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </button>


                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="Edit<?php echo e($product->definition->id); ?>" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="editModalLabel<?php echo e($product->definition->id); ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">تعديل المخزن</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('products.edit', ['productId' => $product->id,'product_id' => $product->id]);

$__html = app('livewire')->mount($__name, $__params, 'product-edit-' . $product->definition->id, $__slots ?? [], get_defined_vars());

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
                                <td colspan="9" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                        <span class="text-muted">لا توجد تعريفات متاحة</span>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- Pagination -->
                <?php echo e($products->links('pagination::bootstrap-5')); ?>


            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\products\show.blade.php ENDPATH**/ ?>