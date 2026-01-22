<div>
    <head>
        
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/styleaccountingcreate.css')); ?>" />
    </head>


    <div class="container-fluid py-4">
       

     
        <div class="data-table-container">
            <div class="data-table-header">
                <h5><i class="bi bi-table me-2"></i> النتائج</h5>
                <div class="table-controls">
                    <div class="table-search">
                        <i class="bi bi-search"></i>
                        <input type="text" wire:model.live="searchTerm" placeholder="بحث في الجدول...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th wire:click="sortBy('name')" style="cursor: pointer" class="text-leght">الاسم
                                <?php if($sortColumn == 'name'): ?>
                                    <?php if($sortDirection == 'asc'): ?>
                                        <i class="bi bi-sort-alpha-down"></i> 
                                    <?php else: ?>
                                        <i class="bi bi-sort-alpha-down-alt"></i> 
                                    <?php endif; ?>
                                <?php else: ?>
                                    <i class="bi bi-arrow-down-up"></i> 
                                <?php endif; ?>
                            </th>
                            <th wire:click="sortBy('code')" style="cursor: pointer" class="text-center">
                                الكود
                                <i class="ms-1">
                                    <?php if($sortColumn == 'code'): ?>
                                        <?php if($sortDirection == 'asc'): ?>
                                            <i class="bi bi-sort-alpha-down"></i> 
                                        <?php else: ?>
                                            <i class="bi bi-sort-alpha-down-alt"></i> 
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up"></i> 
                                    <?php endif; ?>
                                </i>
                            </th>

                            <th class="text-center">الكمية المباعة</th>
                            <th class="text-center">الكمية الشراء</th>
                            <th class="text-center">الكمية المتوفرة</th>
                            <th class="text-center">سعر الشراء</th>
                            <th class="text-center">رقم الفاتورة</th>
                            <th class="text-center">اسم الفاتورة</th>
                            <th class="text-center">تاريخ الإنشاء</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $filteredResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filteredResult): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo e($loop->iteration + ($filteredResults->currentPage() - 1) * $filteredResults->perPage()); ?>

                                </td>
                                <td class="text-leght"><?php echo e($filteredResult->name); ?></td>
                                <td class="text-center"><?php echo e($filteredResult->code); ?></td>
                                <td class="text-center"><?php echo e($filteredResult->q_sold); ?></td>
                                <td class="text-center"><?php echo e($filteredResult->quantity); ?></td>
                                <td class="text-center"  style="font-weight: bold; "><?php echo e($filteredResult->quantity - $filteredResult->q_sold); ?></td>
                                <td class="text-center"><?php echo e(number_format($filteredResult->buy_price) ?? '-'); ?></td>
                                <td class="text-center"><?php echo e($filteredResult->buy_invoice->num_invoice); ?></td>
                                <td class="text-center"><?php echo e($filteredResult->buy_invoice->name_invoice); ?></td>
                                <td class="text-center"><?php echo e($filteredResult->buy_invoice->datecreate->format('Y-m-d')); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">لا توجد نتائج</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Laravel Livewire Pagination -->
                <div class="table-info" style="padding: 15px">


                    <?php echo e($filteredResults->links()); ?>

                </div>
            </div>
        </div>

    </div>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\accounting\showbuyproduct.blade.php ENDPATH**/ ?>