<div>
    <div class="container py-4">
    <!-- Header with Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">
            <i class="fas fa-file-invoice text-primary me-2"></i>
            تعديل الفاتورة رقم: <?php echo e($invoice->num_invoice); ?>

        </h2>
        <div>
            <button wire:click="updateInvoice" class="btn btn-outline-primary me-2">
                <i class="fas fa-save me-1"></i> حفظ التعديلات
            </button>
            
        </div>
    </div>

    <!-- Success Alert -->
    <?php if(session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Products Table -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 25%">الاسم</th>
                            <th class="text-center" style="width: 15%">الباركود</th>
                            <th class="text-center" style="width: 10%">الكمية</th>
                            <th class="text-center" style="width: 15%">سعر الشراء</th>
                            <th class="text-center" style="width: 15%">سعر البيع</th>
                            <th class="text-center" style="width: 20%">تاريخ الانتهاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="text" readonly class="form-control-plaintext text-center" 
                                           value="<?php echo e($product['name']); ?>">
                                </td>
                                <td class="text-center align-middle text-muted"><?php echo e($product['barcode']); ?></td>
                                <td>
                                    <input type="number" min="1" wire:model.live="products.<?php echo e($index); ?>.quantity"
                                           class="form-control text-center" >
                                </td>
                                <td>
                                    <input type="number" step="0.01" wire:model.live="products.<?php echo e($index); ?>.buy_price"
                                           class="form-control text-center">
                                </td>
                                <td>
                                    <input type="number" step="0.01" wire:model.live="products.<?php echo e($index); ?>.sell_price"
                                           class="form-control text-center">
                                </td>
                                <td>
                                    <input type="date" wire:model.live="products.<?php echo e($index); ?>.dateex"
                                           class="form-control">
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Invoice Summary -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">السعر الكلي</h6>
                    <p class="card-text h4"><?php echo e(number_format($this->totalPrice)); ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <label for="discount" class="form-label text-muted">الخصم (%)</label>
                    <input type="number" wire:model.live="discount" min="0" max="100"
                           class="form-control" id="discount">
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">السعر بعد الخصم</h6>
                    <p class="card-text h4"><?php echo e(number_format($this->afterDiscountTotalPrice)); ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <label for="cash" class="form-label text-muted">الدفع النقدي</label>
                    <input type="number" wire:model.live="cash" min="0" step="0.01"
                           class="form-control" id="cash">
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">المتبقي</h6>
                    <p class="card-text h4"><?php echo e(number_format($this->residual)); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <label for="note" class="form-label">ملاحظة</label>
            <textarea wire:model="note" class="form-control" id="note" rows="3"
                      placeholder="أضف ملاحظة إذا لزم الأمر..."></textarea>
        </div>
    </div>
</div>


</div><?php /**PATH C:\Users\PC\Desktop\New folder (6)\laxe8-12\resources\views\livewire\add-invoices\edit.blade.php ENDPATH**/ ?>