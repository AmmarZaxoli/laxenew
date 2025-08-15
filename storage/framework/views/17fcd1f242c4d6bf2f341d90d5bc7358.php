<div>
    <div class="container-fluid p-0">
        <!-- Invoice Creation Section -->
        

        

            <!-- Product Addition Section -->
            

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


                                <div class="col-md-2">
                                    <label class="form-label fw-bold">الخصم %</label>
                                    <input type="number" wire:model.live="discount" min="0" max="100"
                                        class="form-control text-center">

                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-bold">بعد الخصم</label>
                                    <input type="text" class="form-control text-center" readonly
                                        value="<?php echo e(number_format($this->getAfterDiscountTotalPriceProperty())); ?>">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-bold">المدفوع</label>
                                    <input type="number" wire:model.live="cash" min="0"
                                        class="form-control text-center">

                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">المدفوع</label>
                                    <label for="note" class="form-label fw-bold">ملاحظات</label>
                                    <textarea name="note" class="form-control mb-3" wire:model="note" rows="3" style="height: 20px"></textarea>

                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-bold">المتبقي</label>
                                    <input type="text" class="form-control text-center" readonly
                                        value="<?php echo e(number_format($this->afterCash)); ?>">
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
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/add-invoices/insert.blade.php ENDPATH**/ ?>