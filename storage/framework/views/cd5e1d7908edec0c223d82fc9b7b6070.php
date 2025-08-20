<div>
    <form wire:submit.prevent="update">
        <div class="modal-body">
            <h4 class="mb-4 text-center fw-bold text-primary"><?php echo e($name); ?></h4>

            <div class="mb-3">
                <label class="form-label">سعر البيع</label>
                <input type="number" class="form-control"  step="1" wire:model="price_sell" placeholder="أدخل مبلغ">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['price_sell'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="mb-10">
                <label class="form-label d-block">حالة المنتج</label>
                <div class="btn-group w-100" role="group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model.live="is_active" id="active" value="1" style="cursor: pointer">
                        <label class="form-check-label text-success" for="active">
                            <i class="fas fa-check-circle me-1"></i> نشط
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model.live="is_active" id="inactive" value="0" style="cursor: pointer">
                        <label class="form-check-label text-danger" for="inactive">
                            <i class="fas fa-times-circle me-1"></i> غير نشط
                        </label>
                    </div>
                </div>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger d-block mt-1"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button type="submit" class="btn btn-primary">تحديث</button>
        </div>
    </form>
</div>
<?php /**PATH C:\Users\Malta Computer\Desktop\laxe8-20\resources\views/livewire/products/edit.blade.php ENDPATH**/ ?>