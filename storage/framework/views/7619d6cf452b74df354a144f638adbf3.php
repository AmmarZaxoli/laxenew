<div class="container card shadow-sm border-3 card-body p-4 borde">
        <form wire:submit.prevent="update">



            <div class="form-group mb-4">
                <label class="form-label">اسم</label>
                <input type="text" wire:model.defer="name" class="form-control">
               <?php $__errorArgs = ['name'];
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

            <div class="form-group mb-3">
                <label class="form-label">السعر</label>
                <input type="text" wire:model.defer="price" class="form-control ">
                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">الوصف</label>
                <input type="text" wire:model.defer="namething" class="form-control ">
                <?php $__errorArgs = ['namething'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="d-flex justify-content-between">
               <button type="button" class="btn btn-primary" wire:click="update">تحديث</button>

            </div>
        </form>
    </div>

<?php /**PATH C:\Users\user\Desktop\laxe8-18\resources\views\livewire\expenses\edit.blade.php ENDPATH**/ ?>