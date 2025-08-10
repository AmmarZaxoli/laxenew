<div class="container">
    <div class="card shadow-sm border-3">
        
        <div class="card-body p-4 borde">
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
                    <label class="form-label">رقم السر</label>
                    <input type="text" wire:model.defer="password" class="form-control ">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="roleSelect" class="form-label">رول</label>
                    <select class="form-select" id="roleSelect" wire:model="role">
                        <option value="">اختر رول...</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e("يرجى إدخال رول"); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-primary" wire:click="update">تحديث</button>

                </div>
        </div>
    </div>
    </form>
    <style>
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        label.form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
    </style>
</div><?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\accounts\edit.blade.php ENDPATH**/ ?>