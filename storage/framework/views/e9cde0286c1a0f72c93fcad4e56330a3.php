<div>
    <div class="card">
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
                        <label for="selected_company" class="form-label small text-muted mb-1">تصفية حسب الشركة</label>
                        <select class="form-select" wire:model.live="selected_company" id="selected_company">
                            <option value="">جميع الشركات</option>
                            <?php $__currentLoopData = $companys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($company->companyname); ?>"><?php echo e($company->companyname); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="40" class="text-center">#</th>
                                <th class="text-center">رقم الفاتورة</th>
                                <th class="text-center">اسم زبون</th>
                                <th class="text-center">التاريخ إنشاء</th>
                                <th class="text-center">سعر القائيمة</th>
                                <th class="text-center">تخفيض القائمة</th>
                                <th class="text-center">سعر بعد تخفيض</th>
                                <th class="text-center">دفع النقد</th>
                                <th class="text-center">الحساب المتبقي</th>
                                <th class="text-center">الملاحظة</th>
                                <th width="150" class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="align-middle" style="cursor: pointer;"
                                    wire:key="invoice-<?php echo e($invoice->id); ?>">
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td class="text-center"><?php echo e($invoice->num_invoice); ?></td>
                                    <td class="text-center"><?php echo e($invoice->name_invoice); ?></td>
                                    <td class="text-center">
                                        <?php echo e(\Carbon\Carbon::parse($invoice->datecreate)->format('Y-m-d')); ?></td>
                                    <td class="text-center"><?php echo e(number_format($invoice->total_price)); ?></td>
                                    <td class="text-center"><?php echo e(number_format($invoice->discount)); ?>%</td>
                                    <td class="text-center"><?php echo e(number_format($invoice->afterDiscountTotalPrice)); ?></td>
                                    <td class="text-center"><?php echo e(number_format($invoice->cash)); ?></td>
                                    <td class="text-center"><?php echo e(number_format($invoice->residual)); ?></td>
                                    <td class="text-center"><?php echo e($invoice->note); ?></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button wire:click="editInvoice(<?php echo e($invoice->id); ?>)"
                                                class="btn btn-sm btn-icon btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <i class="fas fa-file-invoice fa-2x text-muted mb-2"></i>
                                            <span class="text-muted">لا توجد فواتير متاحة</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <?php echo e($invoices->links('pagination::bootstrap-5')); ?>

                </div>
            </div>
        </div>
    </div>


   <?php if($editModal): ?>
    <div class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5)">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تعديل الفاتورة</h5>
                    <button type="button" wire:click="closeModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('add-invoices.edit', ['invoiceId' => $editingInvoiceId]);

$__html = app('livewire')->mount($__name, $__params, 'edit-' . $editingInvoiceId, $__slots ?? [], get_defined_vars());

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
<?php endif; ?>




</div>
<?php /**PATH C:\Users\PC\Desktop\New folder (6)\laxe8-12\resources\views\livewire\invoices\show.blade.php ENDPATH**/ ?>