<div>
    
        <div class="modal-body row g-3">
            <div class="col-md-6">
                <label class="form-label">اسم المنتج</label>
                <input type="text" class="form-control" wire:model.defer="name">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="col-md-6">
                <label class="form-label">الكود</label>
                <input type="text" class="form-control" wire:model.defer="code">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="col-md-6">
                <label class="form-label">الباركود</label>
                <input type="text" class="form-control" wire:model.defer="barcode">
            </div>

            <div class="col-md-6">
                <label class="form-label">نوع المنتج</label>
                <select class="form-select" wire:model.defer="type_id">
                    <option value="">اختر النوع</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>"><?php echo e($type->typename); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="col-md-6">
                <label class="form-label">المدينة</label>
                <input type="text" class="form-control" wire:model.defer="madin">
            </div>

            <div class="col-md-6">
                <label class="form-label">حالة المنتج</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model.defer="is_active" id="active"
                            value="1" style="cursor: pointer">
                        <label class="form-check-label text-success" for="active">
                            <i class="fas fa-check-circle me-1"></i> نشط
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model.defer="is_active" id="inactive"
                            value="0" style="cursor: pointer">
                        <label class="form-check-label text-danger" for="inactive">
                            <i class="fas fa-times-circle me-1"></i> غير نشط
                        </label>
                    </div>
                </div>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="col-md-6">
                <label class="form-label">التوصيل مجاني ؟</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" wire:model.live="delivery_type"
                        id="deliverableSwitch" style="width: 3em; height: 1.5em; cursor: pointer;">
                    <label class="form-check-label ms-2" for="deliverableSwitch">
                        <span class="fw-bold <?php echo e($delivery_type ? 'text-success' : 'text-danger'); ?>">

                        </span>
                    </label>
                </div>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['delivery_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>


            <div class="col-md-6">
                <label class="form-label">صورة جديدة (اختياري)</label>
                <input type="file" class="form-control" wire:model="new_image">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['new_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($current_image): ?>
                    <div class="mt-2">
                        <p class="mb-1">الصورة الحالية:</p>
                        <img src="<?php echo e($current_image); ?>" alt="صورة المنتج الحالية" class="img-thumbnail"
                            style="max-width: 100px;">
                        <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="removeImage">
                            <i class="fas fa-trash"></i> حذف الصورة
                        </button>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($new_image): ?>
                    <div class="mt-2">
                        <p class="mb-1">معاينة الصورة الجديدة:</p>
                        <img src="<?php echo e($new_image->temporaryUrl()); ?>" alt="معاينة الصورة الجديدة" class="img-thumbnail"
                            style="max-width: 100px;">
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <div class="modal-footer">
            <button wire:click='update' class="btn btn-outline-primary">تحديث</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
        </div>
   

</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10 (2)\resources\views/livewire/definitions/edit.blade.php ENDPATH**/ ?>