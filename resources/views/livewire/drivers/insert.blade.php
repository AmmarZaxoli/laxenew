<div >

    <div class="row g-3">
        <!-- First Column -->
        <div class="col-md-6">
            <!-- Name Field -->
            <div class="mb-3">
                <label for="nameInput" class="form-label fw-medium">اسم السائق</label>
                <input type="text" class="form-control @error('nameDriver') is-invalid @enderror" id="nameInput"
                    wire:model='nameDriver' placeholder="أدخل الاسم الكامل" autocomplete="off">
                @error('nameDriver')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Mobile Field -->
            <div class="mb-3">
                <label for="mobile" class="form-label fw-medium">رقم الهاتف</label>
                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile"
                    wire:model='mobile' autocomplete="off" placeholder="أدخل رقم الهاتف">
                @error('mobile')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-5" >
                <label for="taxiprice" class="form-label fw-medium">سعر التوصيل</label>
                <input type="number" class="form-control text-center @error('taxiprice') is-invalid @enderror" id="taxiprice"
                    wire:model='taxiprice' autocomplete="off" min="0" step="1000" value="0">
                @error('taxiprice')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Second Column -->
        <div class="col-md-6">
            <!-- Car Number Field -->
            <div class="mb-3">
                <label for="numcar" class="form-label fw-medium">رقم السيارة</label>
                <input type="text" class="form-control @error('numcar') is-invalid @enderror" id="numcar"
                    wire:model='numcar' autocomplete="off" placeholder="أدخل رقم السيارة">
                @error('numcar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Address Field -->
            <div class="mb-3">
                <label for="address" class="form-label fw-medium">العنوان</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                    wire:model='address' autocomplete="off" placeholder="أدخل العنوان">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">

        <button type="submit" class="btn btn-outline-primary px-4 rounded-2 d-flex align-items-center justify-content-center"
            wire:click="store" wire:loading.attr="disabled" wire:target="store">

            {{-- Spinner يظهر أثناء التحميل --}}
            <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2" role="status"></span>

            {{-- نص الزر يظهر فقط إذا لم يكن هناك تحميل --}}
            <span wire:loading.remove wire:target="store">
                <i class="fas fa-save me-2"></i> حفظ البيانات
            </span>

        </button>

        <button type="button" class="btn btn-outline-secondary px-4 rounded-2" data-bs-dismiss="modal">
            إغلاق
        </button>
    </div>



</div>
