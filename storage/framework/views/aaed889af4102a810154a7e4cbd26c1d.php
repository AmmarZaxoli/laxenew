<div>
    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="container py-3">
                    <h4 class="fw-bold">تعديل الاوفرات</h4>
                </div>

                <!-- Main Offers Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>كود</th>
                                        <th>سعر الاوفر</th>
                                        <th>إجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="align-middle">
                                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($offer->nameoffer); ?></td>
                                            <td class="text-center"><?php echo e($offer->code); ?></td>
                                            <td class="text-center"><?php echo e(number_format($offer->price)); ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary"
                                                    wire:click="editOffer(<?php echo e($offer->id); ?>)" data-bs-toggle="modal"
                                                    data-bs-target="#editOfferModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    wire:click="confirmRemoveOffer(<?php echo e($offer->id); ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">لا توجد عروض متاحة</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Offer Modal -->
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="editOfferModal" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">تعديل الاوفر</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-0">
                    <div class="container-fluid">
                        <div class="row g-3">
                            <!-- Search and Filter -->
                            <div class="col-12">
                                <div class="row g-3 mb-3 p-3">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" wire:model.live="search"
                                                placeholder="ابحث بالاسم أو الكود..." class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <select wire:model.live="selectedType" class="form-select">
                                            <option value="">كل الانواع</option>
                                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($type->id); ?>"><?php echo e($type->typename); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Available Products -->
                            <div class="col-md-7">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>الاسم</th>
                                                <th>النوع</th>
                                                <th>الكود</th>
                                                <th>الرصيد</th>
                                                <th>إجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($search || $selectedType): ?>
                                                <?php $__empty_1 = true; $__currentLoopData = $filteredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <?php if($product->quantity !== null && $product->quantity !== 0 && $product->definition->is_active == '1'): ?>
                                                        <tr>
                                                            <td><?php echo e($loop->iteration); ?></td>
                                                            <td><?php echo e($product->definition->name ?? 'N/A'); ?></td>
                                                            <td><?php echo e($product->definition->type->typename ?? 'N/A'); ?>

                                                            </td>
                                                            <td><?php echo e($product->definition->code ?? 'N/A'); ?></td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-<?php echo e($product->quantity > 0 ? 'success' : 'danger'); ?>">
                                                                    <?php echo e($product->quantity); ?>

                                                                </span>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    $isSelected = collect($selectedProducts)->contains(
                                                                        'id',
                                                                        $product->id,
                                                                    );
                                                                ?>
                                                                <button class="btn btn-sm btn-primary"
                                                                    wire:click="addProduct(<?php echo e($product->id); ?>)"
                                                                    <?php if($isSelected): ?> disabled <?php endif; ?>>
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">لا توجد منتجات</td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">ابدأ بالبحث أو
                                                        اختيار النوع لعرض المنتجات</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <?php if($search || $selectedType): ?>
                                        <?php echo e($filteredProducts->links('pagination::bootstrap-5')); ?>

                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Selected Products -->
                            <div class="col-md-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>الاسم</th>
                                                <th>الكمية</th>
                                                <th>سعر الشراء</th>
                                                <th>إجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $selectedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e($product['name']); ?></td>
                                                    <td>
                                                        <input type="number"
                                                            wire:model="selectedProducts.<?php echo e($index); ?>.quantity"
                                                            wire:change="validateQuantity(<?php echo e($index); ?>, $event.target.value)"
                                                            min="1" max="<?php echo e($product['stock']); ?>"
                                                            class="form-control form-control-sm">
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo e(number_format($totalBuy[$product['id']] ?? 0)); ?></td>

                                                    <td>
                                                        <button class="btn btn-sm btn-danger"
                                                            wire:click="removeProduct(<?php echo e($index); ?>)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php if(count($selectedProducts) > 0): ?>
                    <div class="d-flex justify-content-end mt-3">
                        <div class="bg-light border rounded px-4 py-2 fw-bold text-end">
                            <span>مجموع الشراء:</span>
                            <span class="text-primary">
                                <?php echo e(number_format($this->getGrandTotalBuy())); ?>


                            </span>
                            <span>د.ع</span>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Modal Footer / Offer Info -->
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label">اسم الاوفر</label>
                                <input type="text" class="form-control" wire:model="nameoffer">
                                <?php $__errorArgs = ['nameoffer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label">الكود</label>
                                <input type="text" class="form-control" wire:model="code">
                                <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label">السعر</label>
                                <input type="number" class="form-control" wire:model="price">
                                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary flex-grow-1 flex-md-grow-0"
                            data-bs-dismiss="modal">إغلاق</button>
                        <button type="button" class="btn btn-primary flex-grow-1 flex-md-grow-0"
                            wire:click="updateOffer">
                            <span wire:loading wire:target="updateOffer"
                                class="spinner-border spinner-border-sm"></span>
                            حفظ التغيرات
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.addEventListener('confirm-remove-offer', event => {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن تتمكن من التراجع عن الحذف!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف العرض!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Change this line to use the correct syntax
                    Livewire.dispatch('remove-offer', {
                        offerId: event.detail.id
                    });
                    Swal.fire(
                        'تم الحذف!',
                        'تم حذف العرض بنجاح.',
                        'success'
                    )
                }
            });
        });
    </script>

</div>
<?php /**PATH C:\Users\user\Desktop\laxe8-18\resources\views\livewire\offers\edit.blade.php ENDPATH**/ ?>