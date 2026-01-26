<div>
    <!-- Search and Per Page -->
    <div class="d-flex justify-content-between mb-3">
        <div>
            <input type="text" class="form-control" placeholder="بحث..." wire:model.debounce.500ms="search">
        </div>
        <div>
            <select class="form-select" wire:model="perPage">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    <!-- Invoices Table -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th wire:click="sortBy('id')" style="cursor:pointer"># <?php if($sortField=='id'): ?> <?php echo e($sortDirection=='asc'?'↑':'↓'); ?> <?php endif; ?></th>
                <th wire:click="sortBy('num_invoice_sell')" style="cursor:pointer">رقم الفاتورة <?php if($sortField=='num_invoice_sell'): ?> <?php echo e($sortDirection=='asc'?'↑':'↓'); ?> <?php endif; ?></th>
                <th wire:click="sortBy('customermobile')" style="cursor:pointer">الهاتف <?php if($sortField=='customermobile'): ?> <?php echo e($sortDirection=='asc'?'↑':'↓'); ?> <?php endif; ?></th>
                <th wire:click="sortBy('user')" style="cursor:pointer">المستخدم <?php if($sortField=='user'): ?> <?php echo e($sortDirection=='asc'?'↑':'↓'); ?> <?php endif; ?></th>
                <th wire:click="sortBy('totalprice')" style="cursor:pointer">الإجمالي <?php if($sortField=='totalprice'): ?> <?php echo e($sortDirection=='asc'?'↑':'↓'); ?> <?php endif; ?></th>
                <th wire:click="sortBy('created_at')" style="cursor:pointer">تاريخ الإنشاء <?php if($sortField=='created_at'): ?> <?php echo e($sortDirection=='asc'?'↑':'↓'); ?> <?php endif; ?></th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($invoice->id); ?></td>
                    <td><?php echo e($invoice->num_invoice_sell); ?></td>
                    <td><?php echo e($invoice->customermobile); ?></td>
                    <td><?php echo e($invoice->user); ?></td>
                    <td><?php echo e(number_format($invoice->totalprice, 2)); ?></td>
                    <td><?php echo e($invoice->created_at->format('Y-m-d H:i')); ?></td>
                    <td>
                        <button class="btn btn-sm btn-primary" wire:click="viewInvoice(<?php echo e($invoice->id); ?>)">عرض الفاتورة</button>
                        <button class="btn btn-sm btn-success" wire:click="printInvoice">طباعة</button>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center">لا توجد فواتير</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        <?php echo e($invoices->links()); ?>

    </div>

    <!-- Invoice Items Modal -->
    <?php if($showModal && $invoiceDetails): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">فاتورة رقم: <?php echo e($invoiceDetails->num_invoice_sell); ?></h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>الهاتف:</strong> <?php echo e($invoiceDetails->customermobile); ?></p>
                        <p><strong>المستخدم:</strong> <?php echo e($invoiceDetails->user); ?></p>
                        <p><strong>العنوان:</strong> <?php echo e($invoiceDetails->address); ?></p>

                        <table class="table table-sm table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المنتج</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $invoiceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e($item->product->name ?? 'منتج غير معروف'); ?></td>
                                        <td><?php echo e($item->quantity); ?></td>
                                        <td><?php echo e(number_format($item->price, 2)); ?></td>
                                        <td><?php echo e(number_format($item->price * $item->quantity, 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <p class="text-end"><strong>الإجمالي: </strong><?php echo e(number_format($invoiceDetails->totalprice, 2)); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="closeModal">إغلاق</button>
                        <button class="btn btn-success" wire:click="printInvoice">طباعة</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\delete-invoices\deleted-invoice.blade.php ENDPATH**/ ?>