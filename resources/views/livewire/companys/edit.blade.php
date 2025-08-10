<div>
    <form wire:submit.prevent="update">
        <div class="form-group mb-3">
            <label class="companyname">اسم</label>
            <input type="text" wire:model.defer="companyname" class="form-control type-input" autofocus>
            @error('companyname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">

            <button type="submit"
                class="btn btn-outline-primary px-4 rounded-2 d-flex align-items-center justify-content-center"
                wire:loading.attr="disabled" wire:target="update">

                <span wire:loading wire:target="update" class="spinner-border spinner-border-sm me-2"
                    role="status"></span>

                <span wire:loading.remove wire:target="update">
                    <i class="fas fa-save me-2"></i> حفظ البيانات
                </span>

            </button>



            <button type="button" class="btn btn-outline-secondary px-4 rounded-2" data-bs-dismiss="modal">
                إغلاق
            </button>
        </div>
    </form>
</div>
