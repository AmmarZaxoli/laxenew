<div class="card">
    <div class="card-body">
        <div class="container-fluid p-0">
            <div class="row g-3 mb-4 align-items-end">
                <!-- Search Column -->
                <div class="col-md-8 col-lg-5">
                    <label class="form-label small text-muted mb-1">بحث</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" wire:model.live="search_code_name" placeholder="بحث بالاسم، الكود، ..."
                            class="form-control">
                    </div>
                </div>

                <!-- Type Select Column -->
                <div class="col-md-4 col-lg-3">
                    <label class="form-label small text-muted mb-1">النوع</label>
                    <select wire:model.live="selected_type" class="form-control">
                        <option value="">كل الانواع</option>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->typename); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Main Products Table -->
            <div class="col-md-7">
                <div class="table-responsive" wire:poll>
                    <table class="table table-striped table-hover mb-0" id="product-table">
                        <thead class="table-light" style="text-align: end">
                            <tr>
                                <th style="text-align: start">#</th>
                                <th style="text-align: start">الاسم</th>
                                <th class="text-center" width="120">Barcode</th>
                                <th class="text-center" width="120">الكود</th>
                                <th class="text-center" width="80">رصيد</th>
                                <th class="text-center" width="100">الصورة</th>
                                <th class="text-center" width="80">إجراء</th>
                            </tr>
                        </thead>
                        <tbody id="product-table-body text-align-center">
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td style="text-align: start"><?php echo e($loop->iteration); ?></td>
                                    <td style="text-align: start"><?php echo e($product->definition->name); ?></td>
                                    <td class="text-center"><?php echo e($product->definition->barcode); ?></td>
                                    <td class="text-center"><?php echo e($product->definition->code); ?></td>
                                    <td class="text-center"><?php echo e($product->quantity); ?></td>

                                    <td class="text-center">
                                        <?php if($product->definition->image && file_exists(public_path('storage/' . $product->definition->image))): ?>
                                            <img src="<?php echo e(asset('storage/' . $product->definition->image)); ?>"
                                                width="40" height="40"
                                                class="rounded-circle object-fit-cover border" data-bs-toggle="modal"
                                                data-bs-target="#imageModal<?php echo e($product->definition->id); ?>"
                                                style="cursor: pointer;" alt="صورة المنتج">
                                        <?php else: ?>
                                            <span class="text-muted small">لا يوجد</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <button class="btn btn-sm btn-primary"
                                            wire:click="addProduct(<?php echo e($product->id); ?>)">
                                            <i class="fas fa-plus"></i>

                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-2">
                                        لا توجد نتائج مطابقة للبحث.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Secondary Table -->
            <div class="col-md-5">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الكود</th>
                                <th>رصيد</th>
                                <th>سعر الشراء</th>
                                <th style="text-align: center">الكمية</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $selectedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productId => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($product['name']); ?></td>
                                    <td class="text-center"><?php echo e($product['code']); ?></td>
                                    <td class="text-center">
                                        <span
                                            class="badge <?php echo e($product['stock'] <= 0 ? 'bg-danger' : ($product['quantity'] < 5 ? 'bg-warning text-dark' : 'bg-light text-dark')); ?>">
                                            <?php echo e($product['stock']); ?>

                                        </span>
                                    </td>
                                    <td class="text-center"><?php echo e(number_format($totalBuy[$productId] ?? 0)); ?></td>

                                    <td class="text-center">
                                        <input type="number"
                                            wire:model.live="selectedProducts.<?php echo e($productId); ?>.quantity"
                                            wire:change="validateQuantity(<?php echo e($productId); ?>, $event.target.value)"
                                            min="1" max="<?php echo e($product['stock']); ?>"
                                            class="form-control form-control-sm text-center <?php if($product['quantity'] > $product['stock']): ?> is-invalid <?php endif; ?>"
                                            style="width: 70px; display: inline-block;"
                                            oninput="this.value = Math.max(1, Math.min(parseInt(this.value) || 1, <?php echo e($product['stock']); ?>))">

                                        <?php if($product['quantity'] > $product['stock']): ?>
                                            <div class="invalid-feedback d-block small">
                                                الكمية تتجاوز المخزون المتاح (<?php echo e($product['stock']); ?>)
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="removeProduct(<?php echo e($productId); ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
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
            <div class="container mt-4">
                <form wire:submit.prevent='storeOffer'>
                    <div class="row g-4">
                        <!-- اسم العرض -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="nameoffer" class="form-label">اسم الاوفر</label>
                            <input type="text" class="form-control shadow-sm" wire:model="nameoffer"
                                autocomplete="off">
                            <?php $__errorArgs = ['nameoffer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- الكود -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="code" class="form-label">الكود</label>
                            <input type="text" class="form-control shadow-sm" wire:model="code" id="code"
                                autocomplete="off">
                            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- سعر الاوفر -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="price" class="form-label">سعر الاوفر</label>
                            <input type="text" class="form-control shadow-sm" wire:model.lazy="price"
                                id="name" autocomplete="off">
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3" >
                            <label class="form-label">التوصيل مجاني ؟</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    wire:model.live="delivery" id="deliverableSwitch"
                                    style="width: 3em; height: 1.5em; cursor: pointer;">
                                <label class="form-check-label ms-2" for="deliverableSwitch">
                                    <span class="fw-bold <?php echo e($delivery ? 'text-success' : 'text-danger'); ?>">

                                    </span>
                                </label>
                            </div>
                            <?php $__errorArgs = ['delivery'];
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

                        <!-- زر الحفظ -->
                        <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i> حفظ الاوفر
                                <span wire:loading wire:target="storeOffer">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    جاري الحفظ...
                                </span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\offers\insert.blade.php ENDPATH**/ ?>