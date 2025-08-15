<div >

    <div class="row g-3">
        <!-- First Column -->
        <div class="col-md-6">
            <!-- Name Field -->
            <div class="mb-3">
                <label for="nameInput" class="form-label fw-medium">اسم السائق</label>
                <input type="text" class="form-control <?php $__errorArgs = ['nameDriver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nameInput"
                    wire:model='nameDriver' placeholder="أدخل الاسم الكامل" autocomplete="off">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nameDriver'];
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

            <!-- Mobile Field -->
            <div class="mb-3">
                <label for="mobile" class="form-label fw-medium">رقم الهاتف</label>
                <input type="text" class="form-control <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="mobile"
                    wire:model='mobile' autocomplete="off" placeholder="أدخل رقم الهاتف">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="mb-3 col-md-5" >
                <label for="taxiprice" class="form-label fw-medium">سعر التوصيل</label>
                <input type="number" class="form-control text-center <?php $__errorArgs = ['taxiprice'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="taxiprice"
                    wire:model='taxiprice' autocomplete="off" min="0" step="1000" value="0">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['taxiprice'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Second Column -->
        <div class="col-md-6">
            <!-- Car Number Field -->
            <div class="mb-3">
                <label for="numcar" class="form-label fw-medium">رقم السيارة</label>
                <input type="text" class="form-control <?php $__errorArgs = ['numcar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="numcar"
                    wire:model='numcar' autocomplete="off" placeholder="أدخل رقم السيارة">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['numcar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- Address Field -->
            <div class="mb-3">
                <label for="address" class="form-label fw-medium">العنوان</label>
                <input type="text" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="address"
                    wire:model='address' autocomplete="off" placeholder="أدخل العنوان">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">

        <button type="submit" class="btn btn-outline-primary px-4 rounded-2 d-flex align-items-center justify-content-center"
            wire:click="store" wire:loading.attr="disabled" wire:target="store">

            
            <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2" role="status"></span>

            
            <span wire:loading.remove wire:target="store">
                <i class="fas fa-save me-2"></i> حفظ البيانات
            </span>

        </button>

        <button type="button" class="btn btn-outline-secondary px-4 rounded-2" data-bs-dismiss="modal">
            إغلاق
        </button>
    </div>



</div>
<?php /**PATH C:\Users\DELL\Desktop\laxe8-10\resources\views/livewire/drivers/insert.blade.php ENDPATH**/ ?>