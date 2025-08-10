<div>
    <form wire:submit.prevent="update">

        <div class="form-group mb-3">
            <label class="form-label">اسم</label>
            <input type="text" wire:model.defer="nameDriver"
                class="form-control @error('nameDriver') is-invalid @enderror">
            @error('nameDriver')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label class="form-label">الهاتف</label>
            <input type="text" wire:model.defer="mobile" class="form-control @error('mobile') is-invalid @enderror">
            @error('mobile')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3 ">
            <label for="taxiprice" class="form-label fw-medium">سعر التوصيل</label>
            <input type="number" class="form-control @error('taxiprice') is-invalid @enderror"
                style="text-align: right;" id="taxiprice" wire:model="taxiprice" autocomplete="off" min="0"
                step="1000">

            @error('taxiprice')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label class="form-label">رقم السيارة</label>
            <input type="text" wire:model.defer="numcar" class="form-control @error('numcar') is-invalid @enderror">
            @error('numcar')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label class="form-label">عنوان</label>
            <input type="text" wire:model.defer="address"
                class="form-control @error('address') is-invalid @enderror">
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">

            <button type="submit"
                class="btn btn-outline-primary px-4 rounded-2 d-flex align-items-center justify-content-center"
                wire:loading.attr="disabled" wire:target="store">

                {{-- Spinner يظهر أثناء التحميل --}}
                <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2"
                    role="status"></span>

                {{-- نص الزر يظهر فقط إذا لم يكن هناك تحميل --}}
                <span wire:loading.remove wire:target="store">
                    <i class="fas fa-save me-2"></i>تحديث
                </span>

            </button>



            <button type="button" class="btn btn-outline-secondary px-4 rounded-2" data-bs-dismiss="modal">
                إغلاق
            </button>
        </div>
    </form>


</div>
