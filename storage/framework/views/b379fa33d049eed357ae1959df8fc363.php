<div>
<div>
    <div class="container-fluid p-0">

        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('add-invoices.search-product', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-875626026-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

            <!-- Product Addition Section -->
            <form wire:submit.prevent="addproduct">
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <div class="row g-3">


                            <!-- Quantity -->
                            <div class="col-md-3 col-6">
                                <label for="quantity" class="form-label fw-bold">عدد</label>
                                <input type="number" wire:model.live="quantity"
                                    class="form-control text-center <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    min="1" step="1">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Buy Price -->
                            <div class="col-md-3 col-6">
                                <label for="buy_price" class="form-label fw-bold">سعر الشراء</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" wire:model.live="buy_price"
                                        class="form-control text-center <?php $__errorArgs = ['buy_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        min="0" step="0.01">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['buy_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Sell Price -->
                            <div class="col-md-3 col-6">
                                <label for="sell_price" class="form-label fw-bold">سعر البيع</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" wire:model.live="sell_price"
                                        class="form-control text-center <?php $__errorArgs = ['sell_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        min="0.01" step="0.01">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['sell_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Profit -->
                            <div class="col-md-3 col-6">
                                <label for="profit" class="form-label fw-bold">نسبة %</label>
                                <input type="text" value="<?php echo e($profit); ?>%"
                                    class="form-control text-center <?php echo e($profit <= 0 ? 'bg-danger text-white' : 'bg-light'); ?>"
                                    readonly>
                            </div>

                            <!-- Total Price -->
                            <div class="col-md-3 col-6">
                                <label for="tprice" class="form-label fw-bold">سعر الكلي</label>
                                <input type="text" value="<?php echo e(number_format($tprice)); ?> "
                                    class="form-control bg-light text-center" readonly>
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-md-3 col-6">
                                <label for="dateex" class="form-label fw-bold">التاريخ انتهاء</label>
                                <input type="date" id="dateex" class="form-control text-center"
                                    wire:model="dateex">
                            </div>

                            <!-- Save Button -->
                            <div class="col-md-3 col-6 d-flex align-items-end" style="margin-top: 58px">
                                <button type="submit" class="btn btn-icon btn-outline-primary pulse-hover w-100"
                                    style="height: 40px;" wire:loading.attr="disabled" wire:target="addproduct"
                                    >
                                    <span wire:loading.remove wire:target="addproduct">
                                        <i class="fas fa-plus"></i> إضافة
                                    </span>
                                    <span wire:loading wire:target="addproduct">
                                        <i class="fas fa-spinner fa-spin"></i> جاري الإضافة...
                                    </span>
                                </button>
                            </div>


                        </div>
                    </div>
                </div>
            </form>

            <!-- Products Table -->
            <!--[if BLOCK]><![endif]--><?php if(count($products) > 0): ?>
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="40" class="text-center">#</th>
                                    <th class="text-center">الاسم</th>
                                    <th class="text-center" width="40">الكود</th>
                                    <th class="text-center" width="200">الباركود</th>
                                    <th class="text-center" width="120">الكمية</th>
                                    <th class="text-center" width="120">سعر الشراء</th>
                                    <th class="text-center" width="120">سعر البيع</th>
                                    <th class="text-center" width="100">الربح %</th>
                                    <th class="text-center" width="120">تاريخ الانتهاء</th>
                                    <th width="100" class="text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="align-middle">
                                        <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                        <td class="fw-medium"><?php echo e($product['name']); ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <?php echo e($product['code']); ?>

                                            </span>
                                        </td>
                                        <td class="text-center"><?php echo e($product['barcode']); ?></td>
                                        <td class="text-center"><?php echo e($product['quantity']); ?></td>
                                        <td class="text-center"><?php echo e(number_format($product['buy_price'])); ?> </td>
                                        <td class="text-center"><?php echo e(number_format($product['sell_price'])); ?> </td>
                                        <td class="text-center"><?php echo e($product['profit']); ?>%</td>
                                        <td class="text-center"><?php echo e($product['dateex'] ?? '-'); ?></td>
                                        <td class="text-center">
                                            <button wire:click="removeProduct(<?php echo e($index); ?>)"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(!empty($product) && is_array($product) && count($product)): ?>
                <form wire:submit.prevent="update_store_total_invoice">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="row g-3">


                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="min-width:140px">المبلغ الإجمالي</label>
                                    <input type="text" class="form-control text-center" readonly
                                        value="<?php echo e(number_format($this->totalTprice)); ?>">
                                </div>

                               

                                <!--[if BLOCK]><![endif]--><?php if(count($products) > 0): ?>
                                    <div class="col-md-3 col-6 d-flex align-items-end">
                                        <button type="button" wire:click="store"
                                            class="btn btn-icon btn-outline-success pulse-hover w-100"
                                            style="height: 40px;" wire:loading.attr="disabled" wire:target="store">
                                            <span wire:loading.remove wire:target="store">
                                                <i class="fas fa-save"></i> حفظ الكل
                                            </span>
                                            <span wire:loading wire:target="store">
                                                <i class="fas fa-spinner fa-spin"></i> جاري الحفظ...
                                            </span>
                                        </button>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                        </div>

                    </div>
                </form>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

</div>
</div>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10 (2)\resources\views/livewire/add-invoices/addedit/insertproduct.blade.php ENDPATH**/ ?>