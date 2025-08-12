<div>
    <div class="p-1" style="margin-top: -40px;">
        <form wire:submit.prevent='store' class="needs-validation" novalidate>
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم</label>
                        <input type="text" class="form-control shadow-sm" wire:model.lazy='name' id="name"
                            autocomplete="off">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">الكود</label>
                        <input type="text" class="form-control shadow-sm" wire:model='code' id="code"
                            autocomplete="off">
                        <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="barcode" class="form-label">الباركود</label>
                        <input type="text" class="form-control shadow-sm" wire:model='barcode' id="barcode"
                            autocomplete="off">
                        <?php $__errorArgs = ['barcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="typeproduct" class="form-label">النوع</label>
                        <select class="form-select shadow-sm" wire:model="type_id" id="typeproduct">
                            <option value="">اختر النوع</option>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>"><?php echo e($type->typename); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="madin" class="form-label">المدين</label>
                        <input type="text" class="form-control shadow-sm" wire:model='madin' id="madin"
                            autocomplete="off">
                        <?php $__errorArgs = ['madin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Product Status -->
                    <div class="mb-3">
                        <label class="form-label">حالة المنتج</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.defer="is_active"
                                    style="cursor: pointer" id="active" value="active">
                                <label class="form-check-label text-success" for="active">
                                    <i class="fas fa-check-circle me-1"></i> نشط
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.defer="is_active"
                                    style="cursor: pointer" id="inactive" value="not active">
                                <label class="form-check-label text-danger" for="inactive">
                                    <i class="fas fa-times-circle me-1"></i> غير نشط
                                </label>
                            </div>
                        </div>
                        <?php $__errorArgs = ['is_active'];
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

                    <!-- Delivery Option - Redesigned with Switch -->
                </div>
                <div class="mb-3" style="margin-top: -20px;">
                    <label class="form-label">التوصيل مجاني ؟</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" wire:model.live="delivery_type"
                            id="deliverableSwitch" style="width: 3em; height: 1.5em; cursor: pointer;">
                        <label class="form-check-label ms-2" for="deliverableSwitch">
                            <span class="fw-bold <?php echo e($delivery_type ? 'text-success' : 'text-danger'); ?>">

                            </span>
                        </label>
                    </div>
                    <?php $__errorArgs = ['delivery_type'];
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


                <!-- Product Image Upload -->
                <div class="mb-4" style="max-height: 200px;margin-top: -20px;">
                    <label for="image" class="form-label">صورة المنتج</label>
                    <div class="border rounded p-3 text-center">
                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                            <?php if($image): ?>
                                <img src="<?php echo e($image->temporaryUrl()); ?>" class="img-thumbnail mb-3"
                                    style="max-height: 100px">
                            <?php else: ?>
                                <div class="image-placeholder mb-3">
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                    <p class="text-muted mt-2">لا توجد صورة</p>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-center">
                                <label for="image" class="btn btn-outline-primary position-relative">
                                    <i class="fas fa-upload me-2"></i> رفع صورة
                                    <input type="file" wire:model="image" class="d-none" id="image"
                                        accept="image/jpeg,image/png">
                                </label>
                            </div>

                            <div x-show="isUploading" class="mt-3">
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" x-bind:style="`width: ${progress}%`"
                                        x-bind:aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100">
                                        <span x-text="progress + '%'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">
                    <button type="submit" class="btn btn-outline-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="fas fa-save me-2"></i> حفظ المنتج
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            جاري الحفظ...
                        </span>
                    </button>

                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> إغلاق
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\Users\PC\Desktop\New folder (6)\laxe8-12\resources\views\livewire\definitions\insert.blade.php ENDPATH**/ ?>