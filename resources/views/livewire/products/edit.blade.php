<div>
    <form wire:submit.prevent="update">
        <div class="modal-body">
            <h4 class="mb-4 text-center fw-bold text-primary">{{ $name }}</h4>

            <div class="mb-3">
                <label class="form-label">سعر البيع</label>
                <input type="number" class="form-control"  step="250" wire:model.defer="price_sell" placeholder="أدخل الكمية">
                @error('price_sell') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-10">
                <label class="form-label d-block">حالة المنتج</label>
                <div class="btn-group w-100" role="group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model.defer="is_active" id="active" value="active" style="cursor: pointer">
                        <label class="form-check-label text-success" for="active">
                            <i class="fas fa-check-circle me-1"></i> نشط
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model.defer="is_active" id="inactive" value="not active" style="cursor: pointer">
                        <label class="form-check-label text-danger" for="inactive">
                            <i class="fas fa-times-circle me-1"></i> غير نشط
                        </label>
                    </div>
                </div>
                @error('is_active') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button type="submit" class="btn btn-primary">تحديث</button>
        </div>
    </form>
</div>
