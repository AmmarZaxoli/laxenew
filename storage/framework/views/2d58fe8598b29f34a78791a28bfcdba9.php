<div>
    <form wire:submit.prevent='store'>
        <div class="form-group mb-3">
            <label for="typename" class="form-label">اسم النوع</label>
            <input type="text" class="form-control" wire:model='typename'>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['typename'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-danger"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">
            <button type="submit" class="btn btn-outline-primary">إنشاء</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </form>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/types/insert.blade.php ENDPATH**/ ?>