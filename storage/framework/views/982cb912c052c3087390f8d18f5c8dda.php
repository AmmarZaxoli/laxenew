<div>
    <form wire:submit.prevent="update">
        <div class="form-group mb-3">
            <label class="companyname">اسم</label>
            <input type="text" wire:model.defer="companyname" class="form-control type-input" autofocus>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['companyname'];
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
        <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">

            <button type="submit"
                class="btn btn-outline-primary px-4 rounded-2 d-flex align-items-center justify-content-center"
                wire:loading.attr="disabled" wire:target="update">

                <span wire:loading wire:target="update" class="spinner-border spinner-border-sm me-2"
                    role="status"></span>

                <span wire:loading.remove wire:target="update">
                    <i class="fas fa-save me-2"></i> حفظ البيانات
                </span>

            </button>



            <button type="button" class="btn btn-outline-secondary px-4 rounded-2" data-bs-dismiss="modal">
                إغلاق
            </button>
        </div>
    </form>
</div>
<?php /**PATH C:\Users\DELL\Desktop\laxe8-10\resources\views/livewire/companys/edit.blade.php ENDPATH**/ ?>