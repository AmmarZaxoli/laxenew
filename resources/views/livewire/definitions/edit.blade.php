<div>
    <form wire:submit.prevent="update">
        <div class="modal-body row g-3">
            <div class="col-md-6">
                <label class="form-label">اسم المنتج</label>
                <input type="text" class="form-control" wire:model.defer="name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">الكود</label>
                <input type="text" class="form-control" wire:model.defer="code">
                @error('code')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">الباركود</label>
                <input type="text" class="form-control" wire:model.defer="barcode">
            </div>

            <div class="col-md-6">
                <label class="form-label">نوع المنتج</label>
                <select class="form-select" wire:model.defer="type_id">
                    <option value="">اختر النوع</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->typename }}</option>
                    @endforeach
                </select>
                @error('type_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
                            value="active" style="cursor: pointer">
                        <label class="form-check-label text-success" for="active">
                            <i class="fas fa-check-circle me-1"></i> نشط
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model.defer="is_active" id="inactive"
                            value="not active" style="cursor: pointer">
                        <label class="form-check-label text-danger" for="inactive">
                            <i class="fas fa-times-circle me-1"></i> غير نشط
                        </label>
                    </div>
                </div>
                @error('is_active')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">التوصيل مجاني ؟</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" wire:model.live="delivery_type"
                        id="deliverableSwitch" style="width: 3em; height: 1.5em; cursor: pointer;">
                    <label class="form-check-label ms-2" for="deliverableSwitch">
                        <span class="fw-bold {{ $delivery_type ? 'text-success' : 'text-danger' }}">

                        </span>
                    </label>
                </div>
                @error('delivery_type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="col-md-6">
                <label class="form-label">صورة جديدة (اختياري)</label>
                <input type="file" class="form-control" wire:model="new_image">
                @error('new_image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                @if ($current_image)
                    <div class="mt-2">
                        <p class="mb-1">الصورة الحالية:</p>
                        <img src="{{ $current_image }}" alt="صورة المنتج الحالية" class="img-thumbnail"
                            style="max-width: 100px;">
                        <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="removeImage">
                            <i class="fas fa-trash"></i> حذف الصورة
                        </button>
                    </div>
                @endif

                @if ($new_image)
                    <div class="mt-2">
                        <p class="mb-1">معاينة الصورة الجديدة:</p>
                        <img src="{{ $new_image->temporaryUrl() }}" alt="معاينة الصورة الجديدة" class="img-thumbnail"
                            style="max-width: 100px;">
                    </div>
                @endif
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary">تحديث</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
        </div>
    </form>

</div>
