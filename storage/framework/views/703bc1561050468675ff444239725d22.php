<div>
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <!-- Search Input -->
                <div class="col-md-6" x-data="{ open: <?php if ((object) ('showDropdown') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showDropdown'->value()); ?>')<?php echo e('showDropdown'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showDropdown'); ?>')<?php endif; ?> }"
                    x-on:click.away="open = false; $wire.set('showDropdown', false)">
                    <label for="search" class="form-label fw-bold">بحث</label>
                    <div class="input-group">
                        <input type="search" autocomplete="off" wire:model.live="search" class="form-control"
                            placeholder="Enter product name, code or barcode..." wire:focus="$set('showDropdown', true)"
                            x-ref="searchInput">
                    </div>

                    <!-- Search Results Dropdown -->
                    <?php if($showDropdown && $definitions->isNotEmpty()): ?>
                        <div class="card mt-2 shadow-lg position-absolute w-100" style="z-index: 1050;border:none">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush" style="width: 47%;">
                                    <?php $__currentLoopData = $definitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $definition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="#" class="list-group-item list-group-item-action"
                                            wire:click.prevent="selectProduct(<?php echo e($definition->id); ?>)">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <?php if($definition->image): ?>
                                                        <img src="<?php echo e(asset('storage/' . $definition->image)); ?>"
                                                            alt="<?php echo e($definition->name); ?>" width="50" height="50"
                                                            class="rounded me-3 object-fit-cover">
                                                    <?php else: ?>
                                                        <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center"
                                                            style="width: 50px; height: 50px;">
                                                            <i class="fas fa-box text-white"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <strong><?php echo e($definition->name); ?></strong>
                                                        <div class="text-muted small">
                                                            <p>كود: <?php echo e($definition->code); ?></span>
                                                                <span class="d-none">كود:
                                                                    <?php echo e($definition->type_id); ?></span>
                                                                <?php if($definition->barcode): ?>
                                                                    <span class="ms-2 d-none">Barcode:
                                                                        <?php echo e($definition->barcode); ?></span>
                                                                <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="badge bg-primary rounded-pill">اختار</span>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <label for="name" class="form-label fw-bold">اسم المنتج</label>

                    <input type="search" autocomplete="off" wire:model.live="name" class="form-control" readonly>

                </div>
                <div class="col-md-3">
                    <label for="code" class="form-label fw-bold">كود</label>

                    <input type="search" autocomplete="off" wire:model.live="code" class="form-control" readonly>

                </div>
            </div>
        </div>
    </div>

    <!-- Create Definition Modal -->
    <?php if($selectedProduct && $purchases->count() > 0): ?>
        <div class="row mt-4" x-data="{ showTable: true }">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">آخر عملية شراء للمنتج</h5>
                        <div>
                            <button x-show="!showTable" @click="showTable = true" class="btn btn-sm btn-success mx-1">
                                <i class="fas fa-eye"></i> عرض
                            </button>
                            <button x-show="showTable" @click="showTable = false" class="btn btn-sm btn-danger mx-1">
                                <i class="fas fa-eye-slash"></i> إخفاء
                            </button>
                        </div>
                    </div>
                    <div class="card-body" x-show="showTable" x-transition>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>رقم الفاتورة</th>
                                        <th>اسم الزبون</th>
                                        <th>التاريخ</th>
                                        <th>سعر الشراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($purchase->buy_invoice?->num_invoice); ?></td>
                                            <td><?php echo e($purchase->buy_invoice?->name_invoice); ?></td>
                                            <td><?php echo e($purchase->created_at->format('Y-m-d')); ?></td>
                                            <td><?php echo e(number_format($purchase->buy_price)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

<script>
    window.addEventListener('focus-search-input', () => {
        const input = document.getElementById('searchInput');
        if (input) {
            input.focus();
        }
    });
</script>
<?php /**PATH C:\Users\user\Desktop\laxe8-10 (7)\resources\views\livewire\add-invoices\search-product.blade.php ENDPATH**/ ?>