<div>
    <form wire:submit.prevent="update">
        <div class="form-group mb-3">
            <label class="form-label">اسم</label>
            <input type="text" wire:model.defer="typename" class="form-control type-input" autofocus>
            <?php $__errorArgs = ['typename'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-danger"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">
            <button type="submit" class="btn btn-outline-primary">تحديث</button>
            <button type="button" class="btn btn-outline-secondary px-4 rounded-2" data-bs-dismiss="modal">
            إغلاق
        </button>
        </div>
    </form>
</div>
<?php /**PATH C:\Users\PC\Desktop\New folder (6)\laxe8-12\resources\views\livewire\types\edit.blade.php ENDPATH**/ ?>