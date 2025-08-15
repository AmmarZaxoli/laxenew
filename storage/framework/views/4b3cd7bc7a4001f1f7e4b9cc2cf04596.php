<div class="container">
    <div class="card shadow-sm border-3">
        <div class="card-header  text-black py-3" style="background-color: rgb(231, 231, 231)">
            <h5 class="mb-0">إضافة حساب الجديد </h5>
        </div>
        <div class="card-body p-4 borde">
            <form wire:submit.prevent="store">
                <?php echo csrf_field(); ?>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">اسم</label>
                            <input type="text" class="form-control" id="nameInput" wire:model='name' autofocus>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e("يرجى إدخال الاسم"); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div class="mb-3">
                            <label for="priceInput" class="form-label">رقم السر </label>
                            <input type="text" class="form-control" id="priceInput" wire:model='password'>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e("يرجى إدخال رقم السر"); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-3">
                            <label for="roleSelect" class="form-label">رول</label>
                            <select class="form-select" id="roleSelect" wire:model="role">
                                <option value="">اختر رول...</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e("يرجى إدخال رول"); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4" wire:click="resetForm"
                        data-bs-dismiss="modal">
                        إغلاق
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-1"></span>
                        إضافة
                    </button>
                </div>
            </form>
        </div>
    </div>
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
</div><?php /**PATH C:\Users\DELL\Desktop\laxe8-10\resources\views/livewire/accounts/insert.blade.php ENDPATH**/ ?>